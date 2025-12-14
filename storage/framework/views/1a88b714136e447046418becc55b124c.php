<?php $__env->startSection('title', 'Dodaj Przedmiot'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.subjects.index')); ?>">Przedmioty</a></li>
<li class="breadcrumb-item active">Dodaj Przedmiot</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-book"></i> Dodaj Nowy Przedmiot</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book"></i> Formularz Dodawania Przedmiotu
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('admin.subjects.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Podstawowe informacje -->
                        <div class="col-md-6">
                            <h6 class="text-info mb-3"><i class="fas fa-info-circle"></i> Podstawowe Informacje</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-signature text-muted"></i> Nazwa Przedmiotu <span class="text-danger">*</span>
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
                                       placeholder="np. Matematyka, Język Polski, Historia" required>
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
                                <label for="code" class="form-label fw-bold">
                                    <i class="fas fa-hashtag text-muted"></i> Kod Przedmiotu
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="code" name="code" value="<?php echo e(old('code')); ?>"
                                       placeholder="np. MAT, POL, HIS" maxlength="10">
                                <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Krótki kod identyfikujący przedmiot (opcjonalny)</div>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label fw-bold">
                                    <i class="fas fa-tags text-muted"></i> Kategoria
                                </label>
                                <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category" name="category">
                                    <option value="">Wybierz kategorię</option>
                                    <option value="humanistyczne" <?php echo e(old('category') == 'humanistyczne' ? 'selected' : ''); ?>>Przedmioty Humanistyczne</option>
                                    <option value="matematyczno-przyrodnicze" <?php echo e(old('category') == 'matematyczno-przyrodnicze' ? 'selected' : ''); ?>>Matematyczno-Przyrodnicze</option>
                                    <option value="artystyczne" <?php echo e(old('category') == 'artystyczne' ? 'selected' : ''); ?>>Artystyczne</option>
                                    <option value="jezyki" <?php echo e(old('category') == 'jezyki' ? 'selected' : ''); ?>>Języki Obce</option>
                                    <option value="wf" <?php echo e(old('category') == 'wf' ? 'selected' : ''); ?>>Wychowanie Fizyczne</option>
                                    <option value="techniczne" <?php echo e(old('category') == 'techniczne' ? 'selected' : ''); ?>>Techniczne</option>
                                    <option value="zawodowe" <?php echo e(old('category') == 'zawodowe' ? 'selected' : ''); ?>>Zawodowe</option>
                                </select>
                                <?php $__errorArgs = ['category'];
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

                        <!-- Szczegóły przedmiotu -->
                        <div class="col-md-6">
                            <h6 class="text-success mb-3"><i class="fas fa-cogs"></i> Szczegóły Przedmiotu</h6>

                            <div class="mb-3">
                                <label for="icon" class="form-label fw-bold">
                                    <i class="fas fa-icons text-muted"></i> Ikona FontAwesome
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="icon" name="icon" value="<?php echo e(old('icon', 'book')); ?>"
                                       placeholder="np. calculator, flask, globe">
                                <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Nazwa ikony FontAwesome (bez "fas fa-")</div>
                            </div>

                            <div class="mb-3">
                                <label for="hours_per_week" class="form-label fw-bold">
                                    <i class="fas fa-clock text-muted"></i> Godzin Tygodniowo
                                </label>
                                <input type="number" class="form-control <?php $__errorArgs = ['hours_per_week'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="hours_per_week" name="hours_per_week"
                                       value="<?php echo e(old('hours_per_week')); ?>" min="1" max="20">
                                <?php $__errorArgs = ['hours_per_week'];
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
                                <label for="color" class="form-label fw-bold">
                                    <i class="fas fa-palette text-muted"></i> Kolor Motywu
                                </label>
                                <select class="form-select <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="color" name="color">
                                    <option value="">Domyślny</option>
                                    <option value="primary" <?php echo e(old('color') == 'primary' ? 'selected' : ''); ?>>Niebieski</option>
                                    <option value="success" <?php echo e(old('color') == 'success' ? 'selected' : ''); ?>>Zielony</option>
                                    <option value="info" <?php echo e(old('color') == 'info' ? 'selected' : ''); ?>>Turkusowy</option>
                                    <option value="warning" <?php echo e(old('color') == 'warning' ? 'selected' : ''); ?>>Żółty</option>
                                    <option value="danger" <?php echo e(old('color') == 'danger' ? 'selected' : ''); ?>>Czerwony</option>
                                    <option value="secondary" <?php echo e(old('color') == 'secondary' ? 'selected' : ''); ?>>Szary</option>
                                    <option value="dark" <?php echo e(old('color') == 'dark' ? 'selected' : ''); ?>>Ciemny</option>
                                </select>
                                <?php $__errorArgs = ['color'];
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
                            <h6 class="text-primary mb-3"><i class="fas fa-align-left"></i> Opis Przedmiotu</h6>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-comment-alt text-muted"></i> Szczegółowy Opis
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="description" name="description" rows="4"
                                          placeholder="Opisz zakres przedmiotu, cele nauczania, metody oceniania..."><?php echo e(old('description')); ?></textarea>
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
                                <div class="form-text">Maksymalnie 1000 znaków</div>
                            </div>
                        </div>
                    </div>

                    <!-- Dodatkowe opcje -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-warning mb-3"><i class="fas fa-sliders-h"></i> Dodatkowe Opcje</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory"
                                               value="1" <?php echo e(old('is_mandatory') ? 'checked' : ''); ?>>
                                        <label class="form-check-label fw-bold" for="is_mandatory">
                                            Przedmiot obowiązkowy
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="has_final_exam" name="has_final_exam"
                                               value="1" <?php echo e(old('has_final_exam') ? 'checked' : ''); ?>>
                                        <label class="form-check-label fw-bold" for="has_final_exam">
                                            Egzamin końcowy
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.subjects.index')); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-undo"></i> Wyczyść
                            </button>
                            <button type="submit" class="btn btn-info btn-lg">
                                <i class="fas fa-book"></i> Dodaj Przedmiot
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Podgląd przykładowych przedmiotów -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-muted">
                    <i class="fas fa-lightbulb"></i> Przykłady przedmiotów
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Podstawowe:</strong><br>
                        <small class="text-muted">Matematyka, Język Polski, Historia, Geografia</small>
                    </div>
                    <div class="col-md-4">
                        <strong>Języki:</strong><br>
                        <small class="text-muted">Język Angielski, Język Niemiecki, Język Francuski</small>
                    </div>
                    <div class="col-md-4">
                        <strong>Dodatkowe:</strong><br>
                        <small class="text-muted">Informatyka, Plastyka, Muzyka, WF</small>
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
    const nameInput = document.getElementById('name');
    const codeInput = document.getElementById('code');

    // Auto-generate code from name
    nameInput.addEventListener('input', function() {
        if (!codeInput.value) {
            const name = this.value.trim();
            if (name) {
                const words = name.split(' ');
                let code = '';

                if (words.length === 1) {
                    code = words[0].substring(0, 3).toUpperCase();
                } else {
                    words.forEach(word => {
                        if (word.length > 0) {
                            code += word.charAt(0).toUpperCase();
                        }
                    });
                }

                codeInput.value = code.substring(0, 10);
            }
        }
    });

    // Icon preview
    const iconInput = document.getElementById('icon');
    iconInput.addEventListener('input', function() {
        // You could add icon preview here
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-info {
    background: linear-gradient(87deg, #36b9cc 0, #258391 100%) !important;
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
    border-color: #36b9cc;
    box-shadow: 0 0 0 0.2rem rgba(54, 185, 204, 0.25);
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

.form-check-input:checked {
    background-color: #36b9cc;
    border-color: #36b9cc;
}

.text-info { color: #36b9cc !important; }
.text-success { color: #1cc88a !important; }
.text-primary { color: #4e73df !important; }
.text-warning { color: #f6c23e !important; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/subjects/create.blade.php ENDPATH**/ ?>