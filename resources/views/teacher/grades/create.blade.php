@extends('layouts.app')

@section('title', 'Dodaj Ocenę')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('teacher.grades.index') }}">Oceny</a></li>
<li class="breadcrumb-item active">Dodaj Ocenę</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-plus"></i> Dodaj Nową Ocenę</h1>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star"></i> Formularz Dodawania Oceny
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('teacher.grades.store') }}" id="gradeForm">
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
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} ({{ $class->students_count }} uczniów)
                                </option>
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
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Lista uczniów -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-users"></i> Uczniowie
                        </label>
                        <div id="students-container" class="border rounded p-3 bg-light">
                            <p class="text-muted text-center mb-0">
                                <i class="fas fa-arrow-up"></i> Najpierw wybierz klasę i przedmiot
                            </p>
                        </div>
                    </div>

                    <!-- Szczegóły oceny -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="grade" class="form-label">
                                <i class="fas fa-star"></i> Ocena <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('grade') is-invalid @enderror"
                                    id="grade" name="grade" required>
                                <option value="">Wybierz ocenę</option>
                                <option value="1" {{ old('grade') == '1' ? 'selected' : '' }}>1 - Niedostateczny</option>
                                <option value="2" {{ old('grade') == '2' ? 'selected' : '' }}>2 - Dopuszczający</option>
                                <option value="3" {{ old('grade') == '3' ? 'selected' : '' }}>3 - Dostateczny</option>
                                <option value="4" {{ old('grade') == '4' ? 'selected' : '' }}>4 - Dobry</option>
                                <option value="5" {{ old('grade') == '5' ? 'selected' : '' }}>5 - Bardzo dobry</option>
                                <option value="6" {{ old('grade') == '6' ? 'selected' : '' }}>6 - Celujący</option>
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
                                <option value="">Wybierz wagę</option>
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('weight') == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                                <option value="sprawdzian" {{ old('type') == 'sprawdzian' ? 'selected' : '' }}>Sprawdzian</option>
                                <option value="kartkówka" {{ old('type') == 'kartkówka' ? 'selected' : '' }}>Kartkówka</option>
                                <option value="odpowiedź" {{ old('type') == 'odpowiedź' ? 'selected' : '' }}>Odpowiedź ustna</option>
                                <option value="projekt" {{ old('type') == 'projekt' ? 'selected' : '' }}>Projekt</option>
                                <option value="praca_domowa" {{ old('type') == 'praca_domowa' ? 'selected' : '' }}>Praca domowa</option>
                                <option value="aktywność" {{ old('type') == 'aktywność' ? 'selected' : '' }}>Aktywność</option>
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
                                  id="description" name="description" rows="3"
                                  placeholder="Opcjonalny opis oceny, temat sprawdzianu, uwagi...">{{ old('description') }}</textarea>
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
                            <button type="button" class="btn btn-outline-primary" onclick="previewGrade()">
                                <i class="fas fa-eye"></i> Podgląd
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Zapisz Ocenę
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal podglądu -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Podgląd Oceny</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="preview-content">
                    <!-- Dynamically filled by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Zapisz Ocenę</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Ładowanie uczniów po wyborze klasy i przedmiotu
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');
    const studentsContainer = document.getElementById('students-container');

    function loadStudents() {
        const classId = classSelect.value;
        const subjectId = subjectSelect.value;

        if (!classId || !subjectId) {
            studentsContainer.innerHTML = '<p class="text-muted text-center mb-0"><i class="fas fa-arrow-up"></i> Najpierw wybierz klasę i przedmiot</p>';
            return;
        }

        studentsContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Ładowanie uczniów...</div>';

        // Symulacja ładowania uczniów - w rzeczywistej aplikacji to byłby AJAX call
        setTimeout(() => {
            studentsContainer.innerHTML = `
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all" onchange="toggleAllStudents()">
                            <label class="form-check-label fw-bold" for="select-all">
                                Zaznacz wszystkich uczniów
                            </label>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row" id="students-list">
                    <!-- Students will be loaded here via AJAX -->
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input student-checkbox" type="checkbox" name="students[]" value="1" id="student-1">
                            <label class="form-check-label" for="student-1">
                                Jan Kowalski
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input student-checkbox" type="checkbox" name="students[]" value="2" id="student-2">
                            <label class="form-check-label" for="student-2">
                                Anna Nowak
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }, 500);
    }

    classSelect.addEventListener('change', loadStudents);
    subjectSelect.addEventListener('change', loadStudents);
});

function toggleAllStudents() {
    const selectAll = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');

    studentCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function previewGrade() {
    const form = document.getElementById('gradeForm');
    const formData = new FormData(form);

    const classText = document.querySelector('#class_id option:checked').text;
    const subjectText = document.querySelector('#subject_id option:checked').text;
    const gradeText = document.querySelector('#grade option:checked').text;
    const weightText = document.querySelector('#weight option:checked').text;
    const typeText = document.querySelector('#type option:checked').text;

    const selectedStudents = document.querySelectorAll('.student-checkbox:checked');
    let studentsText = '';
    selectedStudents.forEach(checkbox => {
        const label = document.querySelector(`label[for="${checkbox.id}"]`);
        studentsText += `<li>${label.textContent}</li>`;
    });

    const previewContent = `
        <div class="row">
            <div class="col-6"><strong>Klasa:</strong></div>
            <div class="col-6">${classText}</div>
            <div class="col-6"><strong>Przedmiot:</strong></div>
            <div class="col-6">${subjectText}</div>
            <div class="col-6"><strong>Ocena:</strong></div>
            <div class="col-6">${gradeText}</div>
            <div class="col-6"><strong>Waga:</strong></div>
            <div class="col-6">${weightText}</div>
            <div class="col-6"><strong>Typ:</strong></div>
            <div class="col-6">${typeText}</div>
            <div class="col-12 mt-3"><strong>Uczniowie:</strong></div>
            <div class="col-12"><ul>${studentsText}</ul></div>
            <div class="col-12 mt-3"><strong>Opis:</strong></div>
            <div class="col-12">${document.getElementById('description').value || 'Brak opisu'}</div>
        </div>
    `;

    document.getElementById('preview-content').innerHTML = previewContent;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function submitForm() {
    document.getElementById('gradeForm').submit();
}
</script>
@endpush