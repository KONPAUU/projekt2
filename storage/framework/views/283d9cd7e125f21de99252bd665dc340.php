<?php $__env->startSection('title', 'Edytuj Klasę'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-edit"></i> Edytuj Klasę: <?php echo e($class->name); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit"></i> Formularz Edycji Klasy
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('admin.classes.update', $class)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <!-- Podstawowe informacje -->
                        <div class="col-md-6">
                            <h6 class="text-warning mb-3"><i class="fas fa-info-circle"></i> Podstawowe Informacje</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag text-muted"></i> Nazwa Klasy <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name" name="name" value="<?php echo e(old('name', $class->name)); ?>"
                                       placeholder="np. 1A, 2B, 3C" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Przykłady: 1A, 2B, 3C, III Technikum</div>
                            </div>

                            <div class="mb-3">
                                <label for="year" class="form-label fw-bold">
                                    <i class="fas fa-calendar text-muted"></i> Rok Szkolny <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="year" name="year" value="<?php echo e(old('year', $class->year)); ?>"
                                       placeholder="2024/2025" required>
                                <?php $__errorArgs = ['year'];
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
                        </div>

                        <!-- Wychowawca -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-user-tie"></i> Wychowawca</h6>

                            <div class="mb-3">
                                <label for="tutor_id" class="form-label fw-bold">
                                    <i class="fas fa-chalkboard-teacher text-muted"></i> Wychowawca
                                </label>
                                <select class="form-select <?php $__errorArgs = ['tutor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="tutor_id" name="tutor_id">
                                    <option value="">Brak wychowawcy</option>
                                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>"
                                        <?php echo e(old('tutor_id', $class->tutor_id) == $teacher->id ? 'selected' : ''); ?>>
                                        <?php echo e($teacher->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tutor_id'];
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

                            <?php if($class->tutor): ?>
                            <div class="alert alert-info">
                                <strong>Obecny wychowawca:</strong><br>
                                <i class="fas fa-user"></i> <?php echo e($class->tutor->name); ?><br>
                                <small><i class="fas fa-envelope"></i> <?php echo e($class->tutor->email); ?></small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Informacje o klasie -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-chart-line"></i> Statystyki klasy
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Liczba uczniów:</strong><br>
                                            <span class="badge bg-primary fs-6"><?php echo e($class->students->count()); ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Liczba przedmiotów:</strong><br>
                                            <span class="badge bg-success fs-6"><?php echo e($class->subjects->count()); ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Data utworzenia:</strong><br>
                                            <small class="text-muted"><?php echo e($class->created_at->format('d.m.Y')); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.classes.show', $class)); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <a href="<?php echo e(route('admin.classes.index')); ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i> Anuluj
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg text-white">
                                <i class="fas fa-save"></i> Zapisz zmiany
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel zarządzania -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-muted">
                    <i class="fas fa-tools"></i> Dodatkowe opcje zarządzania
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.classes.manage', $class)); ?>" class="btn btn-primary w-100">
                            <i class="fas fa-cogs"></i> Zarządzaj przedmiotami
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.users.index', ['class_id' => $class->id])); ?>" class="btn btn-success w-100">
                            <i class="fas fa-users"></i> Zarządzaj uczniami
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ostrzeżenie o usunięciu -->
        <?php if($class->students->count() === 0): ?>
        <div class="card shadow mt-4 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Strefa niebezpieczna
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-3">Usunięcie klasy jest operacją nieodwracalną. Upewnij się, że chcesz kontynuować.</p>
                <form method="POST" action="<?php echo e(route('admin.classes.destroy', $class)); ?>"
                      onsubmit="return confirm('Czy na pewno chcesz usunąć tę klasę? Ta operacja jest nieodwracalna!');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Usuń klasę
                    </button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning mt-4">
            <i class="fas fa-info-circle"></i>
            <strong>Uwaga:</strong> Nie można usunąć klasy, która ma przypisanych uczniów.
            Najpierw przenieś uczniów do innych klas.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Class name formatting
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-warning {
    background: linear-gradient(87deg, #f6c23e 0, #dda20a 100%) !important;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.form-label {
    margin-bottom: 0.5rem;
    color: #5a5c69;
}

.text-warning { color: #f6c23e !important; }
.text-primary { color: #4e73df !important; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/classes/edit.blade.php ENDPATH**/ ?>