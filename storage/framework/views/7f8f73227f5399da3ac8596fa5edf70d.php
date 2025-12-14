<?php $__env->startSection('title', 'Zarządzaj Przedmiotami'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-cogs"></i> Zarządzaj Przedmiotami: <?php echo e($class->name); ?></h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('admin.classes.show', $class)); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Powrót do klasy
        </a>
        <a href="<?php echo e(route('admin.classes.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i> Lista klas
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($class->name); ?></div>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($assignedSubjects->count()); ?></div>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($class->students->count()); ?></div>
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
                            <?php echo e($class->tutor ? Str::limit($class->tutor->name, 15) : 'Brak'); ?>

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
                <form method="POST" action="<?php echo e(route('admin.classes.add-student', $class)); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-bold">
                            <i class="fas fa-user-graduate"></i> Wybierz ucznia <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="student_id" name="student_id" required>
                            <option value="">Wybierz ucznia...</option>
                            <?php $__currentLoopData = $availableStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($student->id); ?>">
                                <?php echo e($student->name); ?>

                                <?php if($student->schoolClass): ?>
                                    (obecnie: <?php echo e($student->schoolClass->name); ?>)
                                <?php else: ?>
                                    (bez klasy)
                                <?php endif; ?>
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-user-plus"></i> Dodaj do klasy
                    </button>
                </form>

                <?php if($availableStudents->isEmpty()): ?>
                <div class="alert alert-info mt-3 mb-0">
                    <i class="fas fa-info-circle"></i>
                    <small>Wszyscy uczniowie są już przypisani do klas.</small>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Lista uczniów w klasie -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-users"></i> Uczniowie w klasie (<?php echo e($classStudents->count()); ?>)
                </h6>
            </div>
            <div class="card-body">
                <?php if($classStudents->count() > 0): ?>
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
                            <?php $__currentLoopData = $classStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-primary text-white rounded-circle">
                                                <?php echo e(strtoupper(substr($student->name, 0, 2))); ?>

                                            </div>
                                        </div>
                                        <div>
                                            <strong><?php echo e($student->name); ?></strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope"></i> <?php echo e($student->email); ?>

                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e($student->phone ?? '—'); ?>

                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(route('admin.users.show', $student)); ?>" class="btn btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST"
                                              action="<?php echo e(route('admin.classes.remove-student', [$class, $student])); ?>"
                                              class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć ucznia <?php echo e($student->name); ?> z klasy?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Usuń z klasy">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-users fa-4x mb-3 opacity-25"></i><br>
                    <h5>Brak uczniów w tej klasie</h5>
                    <p class="mb-0">Użyj formularza po lewej stronie, aby dodać uczniów do tej klasy.</p>
                </div>
                <?php endif; ?>
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
                <form method="POST" action="<?php echo e(route('admin.classes.assign-subject', $class)); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="subject_id" class="form-label fw-bold">
                            <i class="fas fa-book"></i> Przedmiot <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php $__errorArgs = ['subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="subject_id" name="subject_id" required>
                            <option value="">Wybierz przedmiot</option>
                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subject->id); ?>" <?php echo e(old('subject_id') == $subject->id ? 'selected' : ''); ?>>
                                <?php echo e($subject->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label fw-bold">
                            <i class="fas fa-chalkboard-teacher"></i> Nauczyciel <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php $__errorArgs = ['teacher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="teacher_id" name="teacher_id" required>
                            <option value="">Wybierz nauczyciela</option>
                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($teacher->id); ?>" <?php echo e(old('teacher_id') == $teacher->id ? 'selected' : ''); ?>>
                                <?php echo e($teacher->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['teacher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <i class="fas fa-list"></i> Przypisane przedmioty (<?php echo e($assignedSubjects->count()); ?>)
                </h6>
            </div>
            <div class="card-body">
                <?php if($assignedSubjects->count() > 0): ?>
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
                            <?php $__currentLoopData = $assignedSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $subject->teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->parent->index + 1); ?>.<?php echo e($loop->index + 1); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-book text-primary me-2"></i>
                                            <strong><?php echo e($subject->name); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <div class="avatar-title bg-success text-white rounded-circle">
                                                    <?php echo e(strtoupper(substr($teacher->name, 0, 2))); ?>

                                                </div>
                                            </div>
                                            <div><?php echo e($teacher->name); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope"></i> <?php echo e($teacher->email); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <form method="POST"
                                              action="<?php echo e(route('admin.classes.remove-subject', [$class, $subject->id, $teacher->id])); ?>"
                                              class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć to przypisanie?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Usuń przypisanie">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-book fa-4x mb-3 opacity-25"></i><br>
                    <h5>Brak przypisanych przedmiotów</h5>
                    <p class="mb-0">Użyj formularza po lewej stronie, aby przypisać przedmioty do tej klasy.</p>
                </div>
                <?php endif; ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4 mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-book-open text-primary me-2"></i>
                            <span><?php echo e($subject->name); ?></span>
                            <?php if($assignedSubjects->contains($subject->id)): ?>
                                <span class="badge bg-success ms-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center text-muted">
                        Brak dostępnych przedmiotów w systemie
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/classes/manage.blade.php ENDPATH**/ ?>