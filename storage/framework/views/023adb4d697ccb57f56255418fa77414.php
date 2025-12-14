<?php $__env->startSection('title', 'Dodaj Klasę'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.classes.index')); ?>">Klasy</a></li>
<li class="breadcrumb-item active">Dodaj Klasę</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-door-open"></i> Dodaj Nową Klasę</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-door-open"></i> Formularz Dodawania Klasy
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('admin.classes.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Podstawowe informacje -->
                        <div class="col-md-6">
                            <h6 class="text-success mb-3"><i class="fas fa-info-circle"></i> Podstawowe Informacje</h6>

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
                                       id="name" name="name" value="<?php echo e(old('name')); ?>"
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
                                       id="year" name="year" value="<?php echo e(old('year', '2024/2025')); ?>"
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

                            <div class="mb-3">
                                <label for="level" class="form-label fw-bold">
                                    <i class="fas fa-layer-group text-muted"></i> Poziom Edukacji
                                </label>
                                <select class="form-select <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="level" name="level">
                                    <option value="">Wybierz poziom</option>
                                    <option value="podstawowa" <?php echo e(old('level') == 'podstawowa' ? 'selected' : ''); ?>>Szkoła Podstawowa</option>
                                    <option value="gimnazjum" <?php echo e(old('level') == 'gimnazjum' ? 'selected' : ''); ?>>Gimnazjum</option>
                                    <option value="liceum" <?php echo e(old('level') == 'liceum' ? 'selected' : ''); ?>>Liceum</option>
                                    <option value="technikum" <?php echo e(old('level') == 'technikum' ? 'selected' : ''); ?>>Technikum</option>
                                    <option value="zawodowa" <?php echo e(old('level') == 'zavodowa' ? 'selected' : ''); ?>>Szkoła Zawodowa</option>
                                </select>
                                <?php $__errorArgs = ['level'];
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

                        <!-- Wychowawca i szczegóły -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-user-tie"></i> Wychowawca i Szczegóły</h6>

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
                                    <option value="">Wybierz wychowawcę (opcjonalnie)</option>
                                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>" <?php echo e(old('tutor_id') == $teacher->id ? 'selected' : ''); ?>>
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
                                <div class="form-text">Można przypisać później</div>
                            </div>

                            <div class="mb-3">
                                <label for="max_students" class="form-label fw-bold">
                                    <i class="fas fa-users text-muted"></i> Maksymalna Liczba Uczniów
                                </label>
                                <input type="number" class="form-control <?php $__errorArgs = ['max_students'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="max_students" name="max_students"
                                       value="<?php echo e(old('max_students', 30)); ?>" min="1" max="50">
                                <?php $__errorArgs = ['max_students'];
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
                                <label for="classroom" class="form-label fw-bold">
                                    <i class="fas fa-door-closed text-muted"></i> Sala Lekcyjna
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['classroom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="classroom" name="classroom" value="<?php echo e(old('classroom')); ?>"
                                       placeholder="np. Sala 101, Pracownia Informatyczna">
                                <?php $__errorArgs = ['classroom'];
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

                    <!-- Opis -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-info mb-3"><i class="fas fa-comment-alt"></i> Dodatkowe Informacje</h6>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left text-muted"></i> Opis Klasy
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="description" name="description" rows="3"
                                          placeholder="Opcjonalny opis klasy, profil, specjalizacja..."><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
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

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.classes.index')); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-undo"></i> Wyczyść
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-door-open"></i> Dodaj Klasę
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Podgląd przykładowej klasy -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-muted">
                    <i class="fas fa-lightbulb"></i> Przykłady nazw klas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Szkoła Podstawowa:</strong><br>
                        <small class="text-muted">1A, 2B, 3C, 4D, 5A, 6B, 7C, 8A</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Liceum:</strong><br>
                        <small class="text-muted">IA, IIB, IIIC, IVA</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Technikum:</strong><br>
                        <small class="text-muted">1Ti, 2Ei, 3Mi, 4Ti</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Profile:</strong><br>
                        <small class="text-muted">1A-mat, 2B-bio, 3C-hum</small>
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
    // Auto-suggest year
    const currentYear = new Date().getFullYear();
    const nextYear = currentYear + 1;
    const yearInput = document.getElementById('year');

    if (!yearInput.value) {
        yearInput.value = `${currentYear}/${nextYear}`;
    }

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
.bg-gradient-success {
    background: linear-gradient(87deg, #1cc88a 0, #13855c 100%) !important;
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
    border-color: #1cc88a;
    box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
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

.text-success { color: #1cc88a !important; }
.text-primary { color: #4e73df !important; }
.text-info { color: #36b9cc !important; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/admin/classes/create.blade.php ENDPATH**/ ?>