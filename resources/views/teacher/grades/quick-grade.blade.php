@extends('layouts.app')

@section('title', 'Szybkie Wpisywanie Ocen')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('teacher.grades.index') }}">Oceny</a></li>
<li class="breadcrumb-item active">Szybkie Wpisywanie</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-bolt"></i> Szybkie Wpisywanie Ocen</h1>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightning-bolt"></i> Szybkie Dodawanie Oceny
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('teacher.grades.quick.store') }}" id="quickGradeForm">
                    @csrf

                    <div class="row">
                        <!-- Wybór klasy -->
                        <div class="col-md-6 mb-3">
                            <label for="class_id" class="form-label">
                                <i class="fas fa-door-open"></i> Klasa <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('class_id') is-invalid @enderror"
                                    id="class_id" name="class_id" required>
                                <option value="">Wybierz klasę</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Wybór przedmiotu -->
                        <div class="col-md-6 mb-3">
                            <label for="subject_id" class="form-label">
                                <i class="fas fa-book"></i> Przedmiot <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('subject_id') is-invalid @enderror"
                                    id="subject_id" name="subject_id" required>
                                <option value="">Wybierz przedmiot</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Wybór ucznia -->
                    <div class="mb-3">
                        <label for="student_id" class="form-label">
                            <i class="fas fa-user-graduate"></i> Uczeń <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('student_id') is-invalid @enderror"
                                id="student_id" name="student_id" required>
                            <option value="">Najpierw wybierz klasę</option>
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Szczegóły oceny -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="grade" class="form-label">
                                <i class="fas fa-star"></i> Ocena <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('grade') is-invalid @enderror"
                                    id="grade" name="grade" required>
                                <option value="">Wybierz</option>
                                <option value="1">1 - Niedostateczny</option>
                                <option value="2">2 - Dopuszczający</option>
                                <option value="3">3 - Dostateczny</option>
                                <option value="4">4 - Dobry</option>
                                <option value="5">5 - Bardzo dobry</option>
                                <option value="6">6 - Celujący</option>
                            </select>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="weight" class="form-label">
                                <i class="fas fa-weight-hanging"></i> Waga <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('weight') is-invalid @enderror"
                                    id="weight" name="weight" required>
                                <option value="">Wybierz</option>
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">
                                <i class="fas fa-tag"></i> Typ oceny <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required>
                                <option value="">Wybierz typ</option>
                                <option value="sprawdzian">Sprawdzian</option>
                                <option value="kartkówka">Kartkówka</option>
                                <option value="odpowiedź">Odpowiedź ustna</option>
                                <option value="projekt">Projekt</option>
                                <option value="praca_domowa">Praca domowa</option>
                                <option value="aktywność">Aktywność</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Opis -->
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-comment"></i> Opis / Komentarz
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="2"
                                  placeholder="Opcjonalny opis oceny...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teacher.grades.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning">
                                <i class="fas fa-undo"></i> Wyczyść
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-bolt"></i> Dodaj Ocenę
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Historia ostatnich ocen -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-history"></i> Ostatnio Dodane Oceny
                </h6>
            </div>
            <div class="card-body">
                <div id="recent-grades">
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-clock fa-2x mb-2"></i><br>
                        Ostatnie oceny będą wyświetlane tutaj
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const studentSelect = document.getElementById('student_id');
    const quickGradeForm = document.getElementById('quickGradeForm');

    // Ładowanie uczniów po wyborze klasy
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        studentSelect.innerHTML = '<option value="">Ładowanie...</option>';

        if (!classId) {
            studentSelect.innerHTML = '<option value="">Najpierw wybierz klasę</option>';
            return;
        }

        // AJAX call to load students
        fetch(`/api/classes/${classId}/students`)
            .then(response => response.json())
            .then(students => {
                studentSelect.innerHTML = '<option value="">Wybierz ucznia</option>';
                students.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.textContent = student.name;
                    studentSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading students:', error);
                studentSelect.innerHTML = '<option value="">Błąd ładowania uczniów</option>';
            });
    });

    // Submit form with AJAX
    quickGradeForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Dodawanie...';
        submitBtn.disabled = true;

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);

                // Reset form
                this.reset();
                studentSelect.innerHTML = '<option value="">Najpierw wybierz klasę</option>';

                // Load recent grades
                loadRecentGrades();
            } else {
                showAlert('danger', 'Wystąpił błąd podczas dodawania oceny.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Wystąpił błąd podczas dodawania oceny.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Insert alert at the top of the form
        const cardBody = document.querySelector('.card-body');
        cardBody.insertAdjacentHTML('afterbegin', alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = cardBody.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    function loadRecentGrades() {
        // This would load recent grades via AJAX
        // For now, just show a message
        document.getElementById('recent-grades').innerHTML = `
            <div class="text-center text-success py-3">
                <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                Ocena została dodana pomyślnie!
            </div>
        `;
    }
});
</script>
@endpush