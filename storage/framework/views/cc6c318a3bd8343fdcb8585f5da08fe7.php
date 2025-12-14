<?php $__env->startSection('title', 'Zarządzanie Klasami'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Klasy</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-door-open"></i> Zarządzanie Klasami</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('admin.classes.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj klasę
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Statystyki klas -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Łączna liczba klas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_classes']); ?></div>
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
                            Łączna liczba uczniów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_students']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            Średnia liczba uczniów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($stats['average_students'], 1)); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
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
                            Klasy z wychowawcami
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['classes_with_tutors']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Lista klas
                </h6>
            </div>
            <div class="card-body">
                <!-- Pasek wyszukiwania -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Wyszukaj klasy..." value="<?php echo e(request('search')); ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchClasses()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="assignSubjectsModal()">
                                <i class="fas fa-book"></i> Przypisz przedmioty
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nazwa klasy</th>
                                <th>Wychowawca</th>
                                <th>Liczba uczniów</th>
                                <th>Przedmioty</th>
                                <th>Średnia klasy</th>
                                <th>Data utworzenia</th>
                                <th width="180">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="class-icon me-2">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?php echo e($class->name); ?></div>
                                            <?php if($class->description): ?>
                                            <small class="text-muted"><?php echo e(Str::limit($class->description, 30)); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($class->tutor): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <div class="avatar-title bg-light text-dark rounded-circle">
                                                    <?php echo e(strtoupper(substr($class->tutor->name, 0, 2))); ?>

                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?php echo e($class->tutor->name); ?></div>
                                                <small class="text-muted"><?php echo e($class->tutor->email); ?></small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Brak wychowawcy</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($class->students_count > 0 ? 'success' : 'secondary'); ?> fs-6">
                                        <?php echo e($class->students_count); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="subjects-list">
                                        <?php if($class->subjects->count() > 0): ?>
                                            <?php $__currentLoopData = $class->subjects->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-light text-dark me-1 mb-1"><?php echo e($subject->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($class->subjects->count() > 3): ?>
                                            <span class="badge bg-secondary">+<?php echo e($class->subjects->count() - 3); ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Brak przedmiotów</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($class->students_count > 0): ?>
                                        <span class="badge bg-<?php echo e($class->average >= 4.5 ? 'success' : ($class->average >= 3.5 ? 'primary' : ($class->average >= 2.5 ? 'warning' : 'danger'))); ?>">
                                            <?php echo e(number_format($class->average, 2)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e($class->created_at->format('d.m.Y')); ?>

                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?php echo e(route('admin.classes.show', $class)); ?>" class="btn btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.classes.manage', $class)); ?>" class="btn btn-outline-primary" title="Zarządzaj">
                                            <i class="fas fa-cogs"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.classes.edit', $class)); ?>" class="btn btn-outline-warning" title="Edytuj">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" onclick="deleteClass(<?php echo e($class->id); ?>)" title="Usuń">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-door-open fa-3x mb-3"></i><br>
                                    Brak klas do wyświetlenia
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginacja -->
                <?php if($classes->hasPages()): ?>
                <div class="d-flex justify-content-center">
                    <?php echo e($classes->appends(request()->query())->links('vendor.pagination.custom')); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal przypisywania przedmiotów -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-book"></i> Przypisz przedmiot do klasy</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignSubjectForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fas fa-door-open"></i> Wybierz klasę</label>
                            <select class="form-select" id="modal_class_id" name="class_id" required>
                                <option value="">-- Wybierz klasę --</option>
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-book"></i> Przedmiot</label>
                            <select class="form-select" id="modal_subject_id" name="subject_id" required>
                                <option value="">-- Wybierz przedmiot --</option>
                                <?php
                                    $allSubjects = \App\Models\Subject::orderBy('name')->get();
                                ?>
                                <?php $__currentLoopData = $allSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user-tie"></i> Nauczyciel</label>
                            <select class="form-select" id="modal_teacher_id" name="teacher_id" required>
                                <option value="">-- Wybierz nauczyciela --</option>
                                <?php
                                    $allTeachers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->orderBy('name')->get();
                                ?>
                                <?php $__currentLoopData = $allTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Aktualne przypisania dla wybranej klasy -->
                    <div id="currentAssignments" class="mt-3" style="display: none;">
                        <h6 class="text-muted"><i class="fas fa-list"></i> Aktualne przedmioty w tej klasie:</h6>
                        <div id="assignmentsList" class="border rounded p-3 bg-light">
                            <div class="text-center text-muted">Wybierz klasę aby zobaczyć przypisane przedmioty</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Anuluj
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Przypisz przedmiot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchClasses();
        }
    });
});

function searchClasses() {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = `<?php echo e(route('admin.classes.index')); ?>?search=${encodeURIComponent(searchTerm)}`;
}

function deleteClass(classId) {
    if (confirm('Czy na pewno chcesz usunąć tę klasę? Ta operacja usunie również wszystkich uczniów z klasy.')) {
        fetch(`/admin/classes/${classId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Wystąpił błąd podczas usuwania klasy.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas usuwania klasy.');
        });
    }
}

function assignSubjectsModal() {
    const modal = new bootstrap.Modal(document.getElementById('assignSubjectModal'));
    modal.show();
}

// Aktualizuj action formularza po wyborze klasy
document.getElementById('modal_class_id').addEventListener('change', function() {
    const classId = this.value;
    const form = document.getElementById('assignSubjectForm');

    if (classId) {
        form.action = `/admin/classes/${classId}/assign-subject`;
        loadClassSubjects(classId);
    } else {
        form.action = '';
        document.getElementById('currentAssignments').style.display = 'none';
    }
});

function loadClassSubjects(classId) {
    const container = document.getElementById('currentAssignments');
    const list = document.getElementById('assignmentsList');

    container.style.display = 'block';
    list.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Ładowanie...</div>';

    fetch(`/api/classes/${classId}/subjects`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                list.innerHTML = '<div class="text-center text-muted"><i class="fas fa-info-circle"></i> Brak przypisanych przedmiotów</div>';
            } else {
                let html = '<div class="row">';
                data.forEach(item => {
                    html += `
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded border">
                                <div>
                                    <strong>${item.subject_name}</strong><br>
                                    <small class="text-muted">${item.teacher_name}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="removeSubjectAssignment(${classId}, ${item.subject_id}, ${item.teacher_id})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                list.innerHTML = html;
            }
        })
        .catch(error => {
            list.innerHTML = '<div class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i> Błąd ładowania</div>';
        });
}

function removeSubjectAssignment(classId, subjectId, teacherId) {
    if (confirm('Czy na pewno chcesz usunąć to przypisanie?')) {
        fetch(`/admin/classes/${classId}/subjects/${subjectId}/${teacherId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => {
            if (response.ok) {
                loadClassSubjects(classId);
            }
        });
    }
}


</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
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

.avatar {
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
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.12) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.subjects-list {
    max-width: 200px;
}

.class-icon {
    font-size: 1.2rem;
}

/* Custom Pagination Styles */
.pagination-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-custom .page-item {
    display: inline-block;
}

.pagination-custom .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    min-width: 36px;
    padding: 0;
    font-size: 1rem;
    line-height: 1;
    color: #4e73df;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-custom .page-link:hover {
    background-color: #f8f9fa;
    border-color: #4e73df;
    color: #2e59d9;
}

.pagination-custom .page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: #fff;
    font-weight: 600;
}

.pagination-custom .page-item.disabled .page-link {
    color: #d1d5db;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/classes/index.blade.php ENDPATH**/ ?>