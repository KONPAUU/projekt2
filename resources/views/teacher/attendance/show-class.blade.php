@extends('layouts.app')

@section('title', 'Sprawdzanie obecności - ' . $class->name)

@section('header')
<h1 class="h2"><i class="fas fa-clipboard-check"></i> Sprawdzanie obecności</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('teacher.attendance.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Informacje o klasie -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-door-open"></i> {{ $class->name }} - {{ $subject->name }}
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('teacher.attendance.show-class', ['class' => $class->id, 'subject' => $subject->id]) }}" class="row align-items-end">
                    <div class="col-md-4">
                        <label for="date" class="form-label">Data</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted">Uczniów w klasie: <strong>{{ $students->count() }}</strong></span>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-success" onclick="setAllPresent()">
                            <i class="fas fa-check-double"></i> Wszyscy obecni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body">
                <h6 class="text-muted mb-3">Statystyki dnia</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-check text-success"></i> Obecni</span>
                    <span class="badge bg-success">{{ $attendanceStats['present'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-times text-danger"></i> Nieobecni</span>
                    <span class="badge bg-danger">{{ $attendanceStats['absent'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-clock text-warning"></i> Spóźnieni</span>
                    <span class="badge bg-warning">{{ $attendanceStats['late'] }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-user-check text-info"></i> Usprawiedliwieni</span>
                    <span class="badge bg-info">{{ $attendanceStats['excused'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularz obecności -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users"></i> Lista uczniów</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('teacher.attendance.store') }}" id="attendanceForm">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 30%">Uczeń</th>
                                    <th style="width: 40%">Status</th>
                                    <th style="width: 25%">Uwagi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                @php
                                    $attendance = $student->attendances->first();
                                    $currentStatus = $attendance ? $attendance->status : 'present';
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $student->name }}</strong>
                                    </td>
                                    <td>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                   id="present-{{ $student->id }}" value="present"
                                                   {{ $currentStatus == 'present' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="present-{{ $student->id }}">
                                                <i class="fas fa-check"></i> Obecny
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                   id="absent-{{ $student->id }}" value="absent"
                                                   {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="absent-{{ $student->id }}">
                                                <i class="fas fa-times"></i> Nieobecny
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                   id="late-{{ $student->id }}" value="late"
                                                   {{ $currentStatus == 'late' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="late-{{ $student->id }}">
                                                <i class="fas fa-clock"></i> Spóźniony
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]"
                                                   id="excused-{{ $student->id }}" value="excused"
                                                   {{ $currentStatus == 'excused' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info" for="excused-{{ $student->id }}">
                                                <i class="fas fa-user-check"></i> Uspr.
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                               name="notes[{{ $student->id }}]"
                                               placeholder="Uwagi..."
                                               value="{{ $attendance->notes ?? '' }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('teacher.attendance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Zapisz obecność
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setAllPresent() {
    document.querySelectorAll('input[id^="present-"]').forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endpush

@push('styles')
<style>
.btn-group .btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}
.btn-check:checked + .btn-outline-success {
    background-color: #198754;
    color: white;
}
.btn-check:checked + .btn-outline-danger {
    background-color: #dc3545;
    color: white;
}
.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    color: black;
}
.btn-check:checked + .btn-outline-info {
    background-color: #0dcaf0;
    color: black;
}
</style>
@endpush
