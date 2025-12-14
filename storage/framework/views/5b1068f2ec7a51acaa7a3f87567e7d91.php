<?php $__env->startSection('title', 'Edytuj Użytkownika'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.users.index')); ?>">Użytkownicy</a></li>
<li class="breadcrumb-item active">Edytuj: <?php echo e($user->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-user-edit"></i> Edytuj Użytkownika</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="btn btn-info">
            <i class="fas fa-eye"></i> Zobacz profil
        </a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit"></i> Edycja danych: <?php echo e($user->name); ?>

                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <!-- Dane osobowe -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-user"></i> Dane Osobowe</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-signature text-muted"></i> Imię i Nazwisko <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
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
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope text-muted"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
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
                                <label for="pesel" class="form-label fw-bold">
                                    <i class="fas fa-id-card text-muted"></i> PESEL
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['pesel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="pesel" name="pesel" value="<?php echo e(old('pesel', $user->pesel)); ?>" maxlength="11">
                                <?php $__errorArgs = ['pesel'];
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
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone text-muted"></i> Telefon
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="phone" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                <?php $__errorArgs = ['phone'];
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

                        <!-- Dane systemowe -->
                        <div class="col-md-6">
                            <h6 class="text-success mb-3"><i class="fas fa-cogs"></i> Dane Systemowe</h6>

                            <div class="mb-3">
                                <label for="role_id" class="form-label fw-bold">
                                    <i class="fas fa-user-tag text-muted"></i> Rola <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="role_id" name="role_id" required>
                                    <option value="">Wybierz rolę</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>" <?php echo e(old('role_id', $user->role_id) == $role->id ? 'selected' : ''); ?>>
                                        <?php echo e($role->display_name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['role_id'];
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

                            <div class="mb-3" id="class-section" style="<?php echo e($user->isStudent() ? '' : 'display: none;'); ?>">
                                <label for="class_id" class="form-label fw-bold">
                                    <i class="fas fa-door-open text-muted"></i> Klasa
                                </label>
                                <select class="form-select <?php $__errorArgs = ['class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="class_id" name="class_id">
                                    <option value="">Wybierz klasę (opcjonalnie)</option>
                                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($class->id); ?>" <?php echo e(old('class_id', $user->class_id) == $class->id ? 'selected' : ''); ?>>
                                        <?php echo e($class->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['class_id'];
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

                            <hr class="my-4">
                            <h6 class="text-warning mb-3"><i class="fas fa-lock"></i> Zmiana Hasła</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle"></i> Pozostaw puste, jeśli nie chcesz zmieniać hasła.
                            </p>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">
                                    <i class="fas fa-lock text-muted"></i> Nowe Hasło
                                </label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="password" name="password">
                                <?php $__errorArgs = ['password'];
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
                                <label for="password_confirmation" class="form-label fw-bold">
                                    <i class="fas fa-lock text-muted"></i> Potwierdź Nowe Hasło
                                </label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <!-- Adres -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-info mb-3"><i class="fas fa-map-marker-alt"></i> Adres</h6>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">
                                    <i class="fas fa-home text-muted"></i> Adres zamieszkania
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="address" name="address" rows="2"><?php echo e(old('address', $user->address)); ?></textarea>
                                <?php $__errorArgs = ['address'];
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
                    </div>

                    <!-- Informacje o koncie -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-light border">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <small class="text-muted">Utworzony</small><br>
                                        <strong><?php echo e($user->created_at->format('d.m.Y H:i')); ?></strong>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Zaktualizowany</small><br>
                                        <strong><?php echo e($user->updated_at->format('d.m.Y H:i')); ?></strong>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Status</small><br>
                                        <span class="badge bg-<?php echo e($user->email_verified_at ? 'success' : 'warning'); ?>">
                                            <?php echo e($user->email_verified_at ? 'Aktywny' : 'Nieaktywny'); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-undo"></i> Resetuj
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Zapisz Zmiany
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    const classSection = document.getElementById('class-section');
    const classSelect = document.getElementById('class_id');

    roleSelect.addEventListener('change', function() {
        const selectedRole = this.options[this.selectedIndex].text.toLowerCase();

        if (selectedRole.includes('uczeń') || selectedRole.includes('student')) {
            classSection.style.display = 'block';
        } else {
            classSection.style.display = 'none';
            classSelect.value = '';
        }
    });

    // PESEL validation
    const peselInput = document.getElementById('pesel');
    if (peselInput) {
        peselInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }
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

.text-primary { color: #4e73df !important; }
.text-success { color: #1cc88a !important; }
.text-info { color: #36b9cc !important; }
.text-warning { color: #f6c23e !important; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>