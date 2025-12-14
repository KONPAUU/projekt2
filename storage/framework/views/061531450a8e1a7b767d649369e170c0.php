<?php $__env->startSection('title', 'Edytuj Ocenę'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-edit"></i> Edytuj Ocenę</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card glass-card">
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('teacher.grades.update', $grade)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-4">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informacje o ocenie
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Uczeń</label>
                            <input type="text" class="form-control" value="<?php echo e($grade->student->name); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Przedmiot</label>
                            <input type="text" class="form-control" value="<?php echo e($grade->subject->name); ?>" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label">Ocena <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="grade"
                                        name="grade"
                                        required>
                                    <option value="">Wybierz ocenę</option>
                                    <?php for($i = 1; $i <= 6; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e(old('grade', $grade->grade) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <?php $__errorArgs = ['grade'];
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

                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label">Waga <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="weight"
                                        name="weight"
                                        required>
                                    <option value="">Wybierz wagę</option>
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e(old('weight', $grade->weight) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <?php $__errorArgs = ['weight'];
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

                        <div class="mb-3">
                            <label for="type" class="form-label">Typ oceny <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="type"
                                    name="type"
                                    required>
                                <option value="">Wybierz typ</option>
                                <option value="sprawdzian" <?php echo e(old('type', $grade->type) == 'sprawdzian' ? 'selected' : ''); ?>>
                                    Sprawdzian
                                </option>
                                <option value="kartkówka" <?php echo e(old('type', $grade->type) == 'kartkówka' ? 'selected' : ''); ?>>
                                    Kartkówka
                                </option>
                                <option value="odpowiedź" <?php echo e(old('type', $grade->type) == 'odpowiedź' ? 'selected' : ''); ?>>
                                    Odpowiedź ustna
                                </option>
                                <option value="projekt" <?php echo e(old('type', $grade->type) == 'projekt' ? 'selected' : ''); ?>>
                                    Projekt
                                </option>
                                <option value="praca_domowa" <?php echo e(old('type', $grade->type) == 'praca_domowa' ? 'selected' : ''); ?>>
                                    Praca domowa
                                </option>
                                <option value="aktywność" <?php echo e(old('type', $grade->type) == 'aktywność' ? 'selected' : ''); ?>>
                                    Aktywność
                                </option>
                            </select>
                            <?php $__errorArgs = ['type'];
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
                            <label for="description" class="form-label">Opis / Komentarz</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Opcjonalny opis oceny..."><?php echo e(old('description', $grade->description)); ?></textarea>
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
                            <small class="form-text text-muted">Maksymalnie 500 znaków</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Zapisz zmiany
                        </button>
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light">
                            <i class="fas fa-times me-2"></i>Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card glass-card">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Szczegóły
                </h5>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Aktualna ocena</small>
                    <span class="badge fs-5 bg-<?php echo e($grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger'))); ?>">
                        <?php echo e($grade->grade); ?>

                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Data wystawienia</small>
                    <strong><?php echo e($grade->created_at->format('d.m.Y H:i')); ?></strong>
                </div>

                <?php if($grade->updated_at != $grade->created_at): ?>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Ostatnia aktualizacja</small>
                    <strong><?php echo e($grade->updated_at->format('d.m.Y H:i')); ?></strong>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Liczba zmian</small>
                    <strong><?php echo e($grade->histories()->count()); ?></strong>
                </div>
            </div>
        </div>

        <div class="card glass-card mt-3">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Ważne informacje
                </h5>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Zmiana oceny zostanie zapisana w historii
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Uczeń zobaczy zmianę od razu
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        Średnia ucznia zostanie przeliczona
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.glass-card {
    border: none !important;
    border-radius: 20px !important;
    background: rgba(255, 255, 255, 0.86);
    backdrop-filter: blur(16px);
    box-shadow: 0 20px 45px -25px rgba(15, 23, 42, 0.35);
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/teacher/grades/edit.blade.php ENDPATH**/ ?>