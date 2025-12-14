@extends('layouts.app')

@section('title', 'Zarządzaj Przedmiotami')

@section('header')
<h1 class="h2"><i class="fas fa-cogs"></i> Zarządzaj Przedmiotami: {{ $class->name }}</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Powrót do klasy
        </a>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i> Lista klas
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Informacje o klasie -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Klasa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $class->name }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Przypisane przedmioty
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $assignedSubjects->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Uczniowie
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $class->students->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Wychowawca
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $class->tutor ? Str::limit($class->tutor->name, 15) : 'Brak' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sekcja zarządzania uczniami -->
<div class="row mb-4">
    <!-- Formularz dodawania ucznia -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user-plus"></i> Dodaj ucznia do klasy
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.classes.add-student', $class) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-bold">
                            <i class="fas fa-user-graduate"></i> Wybierz ucznia <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('student_id') is-invalid @enderror"
                                id="student_id" name="student_id" required>
                            <option value="">Wybierz ucznia...</option>
                            @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }}
                                @if($student->schoolClass)
                                    (obecnie: {{ $student->schoolClass->name }})
                                @else
                                    (bez klasy)
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-user-plus"></i> Dodaj do klasy
                    </button>
                </form>

                @if($availableStudents->isEmpty())
                <div class="alert alert-info mt-3 mb-0">
                    <i class="fas fa-info-circle"></i>
                    <small>Wszyscy uczniowie są już przypisani do klas.</small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Lista uczniów w klasie -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-users"></i> Uczniowie w klasie ({{ $classStudents->count() }})
                </h6>
            </div>
            <div class="card-body">
                @if($classStudents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Lp.</th>
                                <th>Imię i nazwisko</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th width="100">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classStudents as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-primary text-white rounded-circle">
                                                {{ strtoupper(substr($student->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $student->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope"></i> {{ $student->email }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $student->phone ?? '—' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.show', $student) }}" class="btn btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.classes.remove-student', [$class, $student]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć ucznia {{ $student->name }} z klasy?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Usuń z klasy">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-users fa-4x mb-3 opacity-25"></i><br>
                    <h5>Brak uczniów w tej klasie</h5>
                    <p class="mb-0">Użyj formularza po lewej stronie, aby dodać uczniów do tej klasy.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<hr class="my-4">
<h4 class="mb-4"><i class="fas fa-book"></i> Zarządzanie przedmiotami</h4>

<div class="row">
    <!-- Formularz dodawania przedmiotu -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-plus"></i> Dodaj przedmiot
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.classes.assign-subject', $class) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="subject_id" class="form-label fw-bold">
                            <i class="fas fa-book"></i> Przedmiot <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('subject_id') is-invalid @enderror"
                                id="subject_id" name="subject_id" required>
                            <option value="">Wybierz przedmiot</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label fw-bold">
                            <i class="fas fa-chalkboard-teacher"></i> Nauczyciel <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('teacher_id') is-invalid @enderror"
                                id="teacher_id" name="teacher_id" required>
                            <option value="">Wybierz nauczyciela</option>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i> Przypisz przedmiot
                    </button>
                </form>

                <hr class="my-4">

                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    <small>
                        <strong>Wskazówka:</strong> Możesz przypisać ten sam przedmiot z różnymi nauczycielami (np. grupy).
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista przypisanych przedmiotów -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Przypisane przedmioty ({{ $assignedSubjects->count() }})
                </h6>
            </div>
            <div class="card-body">
                @if($assignedSubjects->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Lp.</th>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Email nauczyciela</th>
                                <th width="100">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignedSubjects as $index => $subject)
                                @foreach($subject->teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->parent->index + 1 }}.{{ $loop->index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-book text-primary me-2"></i>
                                            <strong>{{ $subject->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <div class="avatar-title bg-success text-white rounded-circle">
                                                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div>{{ $teacher->name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope"></i> {{ $teacher->email }}
                                        </small>
                                    </td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('admin.classes.remove-subject', [$class, $subject->id, $teacher->id]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć to przypisanie?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Usuń przypisanie">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-book fa-4x mb-3 opacity-25"></i><br>
                    <h5>Brak przypisanych przedmiotów</h5>
                    <p class="mb-0">Użyj formularza po lewej stronie, aby przypisać przedmioty do tej klasy.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Dostępne przedmioty -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-muted">
                    <i class="fas fa-list-ul"></i> Wszystkie dostępne przedmioty
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($subjects as $subject)
                    <div class="col-md-4 mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-book-open text-primary me-2"></i>
                            <span>{{ $subject->name }}</span>
                            @if($assignedSubjects->contains($subject->id))
                                <span class="badge bg-success ms-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        Brak dostępnych przedmiotów w systemie
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
}
.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.card {
    transition: all 0.3s;
    border-radius: 10px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e3e6f0;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
}

.opacity-25 {
    opacity: 0.25;
}
</style>
@endpush
