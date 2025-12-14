@extends('layouts.app')

@section('title', 'Zarządzanie Frekwencją')

@section('header')
<h1 class="h2"><i class="fas fa-calendar-check"></i> Zarządzanie Frekwencją</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('teacher.attendance.reports') }}" class="btn btn-outline-primary">
            <i class="fas fa-chart-bar"></i> Raporty
        </a>
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Wybór klasy i przedmiotu -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-search"></i> Wybierz klasę i przedmiot</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('teacher.attendance.show-class', ['class' => 0, 'subject' => 0]) }}" id="selectForm">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="class_id" class="form-label">
                                <i class="fas fa-door-open"></i> Klasa
                            </label>
                            <select class="form-select" id="class_id" name="class_id" required>
                                <option value="">Wybierz klasę</option>
                                @php
                                    $teacher = auth()->user();
                                    $teacherClasses = \App\Models\SchoolClass::whereExists(function($query) use ($teacher) {
                                        $query->select(\DB::raw(1))
                                              ->from('class_subject_teacher')
                                              ->whereColumn('class_subject_teacher.class_id', 'school_classes.id')
                                              ->where('class_subject_teacher.teacher_id', $teacher->id);
                                    })->withCount('students')->get();
                                @endphp
                                @foreach($teacherClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->students_count }} uczniów)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="subject_id" class="form-label">
                                <i class="fas fa-book"></i> Przedmiot
                            </label>
                            <select class="form-select" id="subject_id" name="subject_id" required>
                                <option value="">Wybierz przedmiot</option>
                                @php
                                    $teacherSubjects = \App\Models\Subject::whereIn('id', function($query) use ($teacher) {
                                        $query->select('subject_id')
                                              ->from('class_subject_teacher')
                                              ->where('teacher_id', $teacher->id);
                                    })->get();
                                @endphp
                                @foreach($teacherSubjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date" class="form-label">
                                <i class="fas fa-calendar"></i> Data
                            </label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-1 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statystyki -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Moje klasy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_classes'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-school fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Uczniów</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_students'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dziś sprawdzono</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['todays_attendance'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ten tydzień</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['weekly_attendance'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Szybki dostęp do klas -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Szybki dostęp</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $classSubjects = \DB::table('class_subject_teacher')
                            ->where('teacher_id', $teacher->id)
                            ->join('school_classes', 'class_subject_teacher.class_id', '=', 'school_classes.id')
                            ->join('subjects', 'class_subject_teacher.subject_id', '=', 'subjects.id')
                            ->select('school_classes.id as class_id', 'school_classes.name as class_name',
                                     'subjects.id as subject_id', 'subjects.name as subject_name')
                            ->get();
                    @endphp
                    @forelse($classSubjects as $cs)
                    <div class="col-md-4 col-lg-3 mb-3">
                        <a href="{{ route('teacher.attendance.show-class', ['class' => $cs->class_id, 'subject' => $cs->subject_id]) }}"
                           class="btn btn-outline-primary w-100 text-start">
                            <i class="fas fa-door-open"></i> {{ $cs->class_name }}<br>
                            <small class="text-muted">{{ $cs->subject_name }}</small>
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        <i class="fas fa-info-circle"></i> Brak przypisanych klas i przedmiotów
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('selectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const classId = document.getElementById('class_id').value;
    const subjectId = document.getElementById('subject_id').value;
    const date = document.getElementById('date').value;

    if (classId && subjectId) {
        window.location.href = `/teacher/attendance/${classId}/${subjectId}?date=${date}`;
    }
});
</script>
@endpush

@push('styles')
<style>
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
</style>
@endpush
