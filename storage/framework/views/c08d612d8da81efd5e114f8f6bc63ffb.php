<?php $__env->startSection('title', 'Edycja Profilu'); ?>

<?php $__env->startSection('header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-circle me-2"></i>
                Mój Profil
            </h1>
            <p class="page-subtitle">Zarządzaj swoimi danymi osobowymi</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Informacje podstawowe
                            </h5>

                            <div class="mb-3">
                                <label for="name" class="form-label">Imię i nazwisko</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name"
                                       name="name"
                                       value="<?php echo e(old('name', $user->name)); ?>"
                                       required>
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
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="email"
                                       name="email"
                                       value="<?php echo e(old('email', $user->email)); ?>"
                                       required>
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
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="phone"
                                       name="phone"
                                       value="<?php echo e(old('phone', $user->phone)); ?>"
                                       placeholder="123456789">
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

                            <div class="mb-3">
                                <label for="address" class="form-label">Adres</label>
                                <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="address"
                                          name="address"
                                          rows="2"
                                          placeholder="Ulica, nr domu, miasto"><?php echo e(old('address', $user->address)); ?></textarea>
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

                        <div class="mb-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-lock text-warning me-2"></i>
                                Zmiana hasła
                            </h5>
                            <p class="text-muted small mb-3">Pozostaw puste, jeśli nie chcesz zmieniać hasła</p>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nowe hasło</label>
                                <input type="password"
                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="password"
                                       name="password"
                                       placeholder="Minimum 8 znaków">
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
                                <label for="password_confirmation" class="form-label">Potwierdź nowe hasło</label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Powtórz hasło">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Zapisz zmiany
                            </button>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light">
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
                        <i class="fas fa-id-card text-info me-2"></i>
                        Informacje o koncie
                    </h5>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Rola</small>
                        <span class="badge bg-soft-primary fs-6">
                            <?php echo e($user->role->display_name ?? 'Użytkownik'); ?>

                        </span>
                    </div>

                    <?php if($user->isStudent() && $user->schoolClass): ?>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Klasa</small>
                            <strong><?php echo e($user->schoolClass->name); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Data rejestracji</small>
                        <strong><?php echo e($user->created_at->format('d.m.Y')); ?></strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Ostatnia aktualizacja</small>
                        <strong><?php echo e($user->updated_at->format('d.m.Y H:i')); ?></strong>
                    </div>
                </div>
            </div>

            <div class="card glass-card mt-3">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        Bezpieczeństwo
                    </h5>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Używaj silnego hasła
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Regularnie aktualizuj swoje dane
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Nie udostępniaj swoich danych logowania
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/profile/edit.blade.php ENDPATH**/ ?>