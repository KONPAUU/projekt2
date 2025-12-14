<?php $__env->startSection('title', 'Panel Nauczyciela'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Strona główna</a></li>
<li class="breadcrumb-item active">Panel Nauczyciela</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chalkboard-teacher text-warning"></i> Panel Nauczyciela
        </h1>
        <p class="mb-0 text-muted">Witaj <?php echo e(auth()->user()->name); ?>! Wybierz klasę i wystaw oceny</p>
    </div>
    <div class="text-end">
        <div class="h6 mb-1 text-muted">Dzisiejsza data</div>
        <div class="h4 text-primary"><?php echo e(now()->format('d.m.Y')); ?></div>
        <small class="text-muted"><?php echo e(now()->locale('pl')->dayName); ?></small>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Główny formularz wystawiania oceny -->
<div class="row justify-content-center mb-5">
    <div class="col-xl-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star"></i> Wystaw Ocenę
                </h5>
                <p class="mb-0 small">Wybierz klasę, ucznia i wystaw ocenę</p>
            </div>
            <div class="card-body p-4">
                <form id="gradeForm" method="POST" action="<?php echo e(route('teacher.grades.quick.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Wybór klasy -->
                        <div class="col-md-4 mb-4">
                            <label for="class_id" class="form-label fw-bold">
                                <i class="fas fa-door-open text-primary"></i> 1. Wybierz Klasę
                            </label>
                            <select class="form-select form-select-lg" id="class_id" name="class_id" required>
                                <option value="">-- Wybierz klasę --</option>
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Wybór przedmiotu -->
                        <div class="col-md-4 mb-4">
                            <label for="subject_id" class="form-label fw-bold">
                                <i class="fas fa-book text-success"></i> 2. Wybierz Przedmiot
                            </label>
                            <select class="form-select form-select-lg" id="subject_id" name="subject_id" required>
                                <option value="">-- Wybierz przedmiot --</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Wybór ucznia -->
                        <div class="col-md-4 mb-4">
                            <label for="student_id" class="form-label fw-bold">
                                <i class="fas fa-user-graduate text-info"></i> 3. Wybierz Ucznia
                            </label>
                            <select class="form-select form-select-lg" id="student_id" name="student_id" required>
                                <option value="">-- Najpierw wybierz klasę --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Ocena -->
                        <div class="col-md-3 mb-3">
                            <label for="grade" class="form-label fw-bold">
                                <i class="fas fa-star text-warning"></i> Ocena
                            </label>
                            <select class="form-select form-select-lg" id="grade" name="grade" required>
                                <option value="">Ocena</option>
                                <option value="1">1 - Niedostateczny</option>
                                <option value="2">2 - Dopuszczający</option>
                                <option value="3">3 - Dostateczny</option>
                                <option value="4">4 - Dobry</option>
                                <option value="5">5 - Bardzo dobry</option>
                                <option value="6">6 - Celujący</option>
                            </select>
                        </div>

                        <!-- Waga -->
                        <div class="col-md-2 mb-3">
                            <label for="weight" class="form-label fw-bold">
                                <i class="fas fa-weight-hanging text-secondary"></i> Waga
                            </label>
                            <select class="form-select form-select-lg" id="weight" name="weight" required>
                                <option value="">Waga</option>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Typ oceny -->
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label fw-bold">
                                <i class="fas fa-tag text-primary"></i> Typ Oceny
                            </label>
                            <select class="form-select form-select-lg" id="type" name="type" required>
                                <option value="">Typ oceny</option>
                                <option value="sprawdzian">Sprawdzian</option>
                                <option value="kartkówka">Kartkówka</option>
                                <option value="odpowiedź">Odpowiedź ustna</option>
                                <option value="projekt">Projekt</option>
                                <option value="praca_domowa">Praca domowa</option>
                                <option value="aktywność">Aktywność</option>
                            </select>
                        </div>

                        <!-- Przycisk dodaj -->
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-plus"></i> Dodaj Ocenę
                            </button>
                        </div>
                    </div>

                    <!-- Opis -->
                    <div class="row">
                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-comment text-muted"></i> Opis / Komentarz (opcjonalnie)
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="2"
                                      placeholder="Opcjonalny opis oceny, uwagi..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Moje klasy -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chalkboard"></i> Moje Klasy i Przedmioty
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Klasa</th>
                                <th>Przedmiot</th>
                                <th>Uczniowie</th>
                                <th>Średnia</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $classSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle-sm bg-primary bg-opacity-10 me-2">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </div>
                                        <span class="fw-bold"><?php echo e($assignment->class->name); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle-sm bg-success bg-opacity-10 me-2">
                                            <i class="fas fa-book text-success"></i>
                                        </div>
                                        <?php echo e($assignment->subject->name); ?>

                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info fs-6"><?php echo e($assignment->class->students_count); ?></span>
                                </td>
                                <td>
                                    <?php if($assignment->average_grade): ?>
                                        <span class="badge bg-<?php echo e($assignment->average_grade >= 4.5 ? 'success' : ($assignment->average_grade >= 3.5 ? 'warning' : 'danger')); ?> fs-6">
                                            <?php echo e(number_format($assignment->average_grade, 2)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">Brak ocen</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                            onclick="selectClass(<?php echo e($assignment->class->id); ?>, <?php echo e($assignment->subject->id); ?>)">
                                        <i class="fas fa-arrow-up"></i> Wybierz
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Brak przypisanych klas i przedmiotów</h5>
                                        <p class="text-muted mb-3">
                                            Aktualnie nie masz przypisanych żadnych klas ani przedmiotów do prowadzenia.
                                        </p>
                                        <div class="alert alert-info">
                                            <strong>Co robić dalej?</strong><br>
                                            • Skontaktuj się z administratorem szkoły<br>
                                            • Administrator może przypisać Ci klasy i przedmioty w panelu administracyjnym<br>
                                            • Po przypisaniu będziesz mógł zarządzać ocenami i frekwencją
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ostatnie oceny -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-history"></i> Ostatnie Oceny
                </h6>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $recentGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3">
                    <div class="avatar me-3">
                        <div class="avatar-title bg-primary text-white rounded-circle">
                            <?php echo e(strtoupper(substr($grade->student->name, 0, 2))); ?>

                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold"><?php echo e($grade->student->name); ?></div>
                        <small class="text-muted"><?php echo e($grade->subject->name); ?></small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?php echo e($grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger'))); ?> fs-6">
                            <?php echo e($grade->grade); ?>

                        </span>
                        <div class="small text-muted"><?php echo e($grade->created_at->format('d.m')); ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-4">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i><br>
                    <span class="text-muted">Brak ostatnich ocen</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statystyki -->
        <div class="card shadow-lg border-0 mt-4">
            <div class="card-header bg-gradient-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar"></i> Twoje Statystyki
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="h4 text-primary"><?php echo e($stats['total_classes'] ?? 0); ?></div>
                        <small class="text-muted">Klas</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="h4 text-success"><?php echo e($stats['total_students'] ?? 0); ?></div>
                        <small class="text-muted">Uczniów</small>
                    </div>
                    <div class="col-6">
                        <div class="h4 text-warning"><?php echo e($stats['total_grades'] ?? 0); ?></div>
                        <small class="text-muted">Ocen</small>
                    </div>
                    <div class="col-6">
                        <div class="h4 text-info"><?php echo e($stats['total_subjects'] ?? 0); ?></div>
                        <small class="text-muted">Przedmiotów</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const studentSelect = document.getElementById('student_id');
    const gradeForm = document.getElementById('gradeForm');

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
                studentSelect.innerHTML = '<option value="">-- Wybierz ucznia --</option>';
                students.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.textContent = student.name;
                    studentSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                studentSelect.innerHTML = '<option value="">Błąd ładowania uczniów</option>';
            });
    });

    // Submit form with notification
    gradeForm.addEventListener('submit', function(e) {
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
                showNotification('success', 'Ocena została dodana pomyślnie!');
                this.reset();
                studentSelect.innerHTML = '<option value="">Najpierw wybierz klasę</option>';

                // Refresh recent grades
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('error', 'Wystąpił błąd podczas dodawania oceny.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Wystąpił błąd podczas dodawania oceny.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});

function selectClass(classId, subjectId) {
    document.getElementById('class_id').value = classId;
    document.getElementById('subject_id').value = subjectId;

    // Trigger change event to load students
    document.getElementById('class_id').dispatchEvent(new Event('change'));

    // Scroll to form
    document.querySelector('#gradeForm').scrollIntoView({ behavior: 'smooth' });
}

function showNotification(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';

    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas fa-${icon}"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 5000);
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Gradienty */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
}

/* Karty */
.card {
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: none;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

/* Formularze */
.form-select, .form-control {
    border-radius: 12px;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

/* Przyciski */
.btn {
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

/* Ikony */
.icon-circle-sm {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Avatar */
.avatar {
    width: 2.5rem;
    height: 2.5rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    border-radius: 50%;
}

/* Tabela */
.table th {
    border: none;
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e8ff 100%);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    color: #5a5c69;
}

.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
}

/* Badge */
.badge {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.5em 0.8em;
}

/* Animacje */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.card {
    animation: slideInUp 0.6s ease-out;
}

/* Responsywność */
@media (max-width: 768px) {
    .form-select-lg {
        font-size: 0.9rem;
        padding: 0.6rem 0.8rem;
    }

    .btn-lg {
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/teacher/dashboard.blade.php ENDPATH**/ ?>