<?php $__env->startSection('title', 'Edytuj przedmiot: ' . $subject->name); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-edit"></i> Edytuj przedmiot</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <a href="<?php echo e(route('admin.subjects.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h5 class="mb-0 text-dark"><i class="fas fa-book"></i> Edycja przedmiotu: <?php echo e($subject->name); ?></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.subjects.update', $subject)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-book"></i> Nazwa przedmiotu <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="name" name="name" value="<?php echo e(old('name', $subject->name)); ?>" required>
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

                        <div class="col-md-4 mb-3">
                            <label for="code" class="form-label">
                                <i class="fas fa-code"></i> Kod
                            </label>
                            <input type="text" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="code" name="code" value="<?php echo e(old('code', $subject->code)); ?>" maxlength="10">
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-folder"></i> Kategoria
                            </label>
                            <select class="form-select" id="category" name="category">
                                <option value="">-- Wybierz kategorię --</option>
                                <option value="humanistyczne" <?php echo e(old('category', $subject->category) == 'humanistyczne' ? 'selected' : ''); ?>>Humanistyczne</option>
                                <option value="scisle" <?php echo e(old('category', $subject->category) == 'scisle' ? 'selected' : ''); ?>>Ścisłe</option>
                                <option value="przyrodnicze" <?php echo e(old('category', $subject->category) == 'przyrodnicze' ? 'selected' : ''); ?>>Przyrodnicze</option>
                                <option value="jezykowe" <?php echo e(old('category', $subject->category) == 'jezykowe' ? 'selected' : ''); ?>>Językowe</option>
                                <option value="artystyczne" <?php echo e(old('category', $subject->category) == 'artystyczne' ? 'selected' : ''); ?>>Artystyczne</option>
                                <option value="sportowe" <?php echo e(old('category', $subject->category) == 'sportowe' ? 'selected' : ''); ?>>Sportowe</option>
                                <option value="inne" <?php echo e(old('category', $subject->category) == 'inne' ? 'selected' : ''); ?>>Inne</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hours_per_week" class="form-label">
                                <i class="fas fa-clock"></i> Godziny tygodniowo
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
                                   value="<?php echo e(old('hours_per_week', $subject->hours_per_week)); ?>" min="1" max="20">
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
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left"></i> Opis
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
                                  placeholder="Opcjonalny opis przedmiotu..."><?php echo e(old('description', $subject->description)); ?></textarea>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory"
                                       <?php echo e(old('is_mandatory', $subject->is_mandatory) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_mandatory">
                                    <i class="fas fa-exclamation-circle"></i> Przedmiot obowiązkowy
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="has_final_exam" name="has_final_exam"
                                       <?php echo e(old('has_final_exam', $subject->has_final_exam) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="has_final_exam">
                                    <i class="fas fa-file-alt"></i> Egzamin końcowy
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.subjects.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/subjects/edit.blade.php ENDPATH**/ ?>