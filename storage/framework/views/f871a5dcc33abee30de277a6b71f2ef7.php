<?php $__env->startSection('title', 'Rejestracja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-user-plus"></i> Rejestracja w Dzienniku Lekcyjnym</h4>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Imię i nazwisko -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Imię i nazwisko <span class="text-danger">*</span>
                                </label>
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
                                       value="<?php echo e(old('name')); ?>"
                                       required
                                       autocomplete="name"
                                       autofocus
                                       placeholder="Wprowadź imię i nazwisko">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Email i PESEL -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Adres email <span class="text-danger">*</span>
                                </label>
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
                                       value="<?php echo e(old('email')); ?>"
                                       required
                                       autocomplete="email"
                                       placeholder="wprowadz@email.pl">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="pesel" class="form-label">
                                    <i class="fas fa-id-card"></i> PESEL <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['pesel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="pesel"
                                       name="pesel"
                                       value="<?php echo e(old('pesel')); ?>"
                                       required
                                       maxlength="11"
                                       pattern="[0-9]{11}"
                                       placeholder="12345678901">
                                <?php $__errorArgs = ['pesel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">11 cyfr bez spacji i kresek</div>
                            </div>
                        </div>

                        <!-- Hasło -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Hasło <span class="text-danger">*</span>
                                </label>
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
                                       required
                                       autocomplete="new-password"
                                       placeholder="Minimum 8 znaków">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-lock"></i> Potwierdź hasło <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       class="form-control"
                                       id="password-confirm"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Powtórz hasło">
                            </div>
                        </div>

                        <!-- Telefon i adres -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Numer telefonu
                                </label>
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
                                       value="<?php echo e(old('phone')); ?>"
                                       maxlength="9"
                                       pattern="[0-9]{9}"
                                       placeholder="123456789">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">9 cyfr bez spacji (opcjonalne)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">
                                    <i class="fas fa-home"></i> Adres zamieszkania
                                </label>
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
                                          placeholder="ul. Przykładowa 123, 00-000 Miasto"><?php echo e(old('address')); ?></textarea>
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Regulamin -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Akceptuję <a href="#" class="text-primary">regulamin serwisu</a> oraz <a href="#" class="text-primary">politykę prywatności</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <!-- Przyciski -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Utwórz konto
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">
                            Masz już konto?
                            <a href="<?php echo e(route('login')); ?>" class="text-decoration-none fw-bold">
                                <i class="fas fa-sign-in-alt"></i> Zaloguj się tutaj
                            </a>
                        </p>
                    </div>

                    <!-- Informacje -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-muted"><i class="fas fa-info-circle"></i> Informacje o rejestracji:</h6>
                        <small class="text-muted">
                            • Nowi użytkownicy są automatycznie rejestrowani jako uczniowie<br>
                            • Administrator może później zmienić rolę użytkownika<br>
                            • Wszystkie pola oznaczone <span class="text-danger">*</span> są wymagane<br>
                            • PESEL i adres email muszą być unikalne w systemie
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Walidacja PESEL w czasie rzeczywistym
    document.getElementById('pesel').addEventListener('input', function(e) {
        const pesel = e.target.value;
        const feedback = e.target.nextElementSibling;

        if (pesel.length === 11 && /^\d{11}$/.test(pesel)) {
            e.target.classList.remove('is-invalid');
            e.target.classList.add('is-valid');
        } else if (pesel.length > 0) {
            e.target.classList.remove('is-valid');
            e.target.classList.add('is-invalid');
        } else {
            e.target.classList.remove('is-valid', 'is-invalid');
        }
    });

    // Walidacja telefonu
    document.getElementById('phone').addEventListener('input', function(e) {
        const phone = e.target.value;

        if (phone.length === 0) {
            e.target.classList.remove('is-valid', 'is-invalid');
        } else if (phone.length === 9 && /^\d{9}$/.test(phone)) {
            e.target.classList.remove('is-invalid');
            e.target.classList.add('is-valid');
        } else {
            e.target.classList.remove('is-valid');
            e.target.classList.add('is-invalid');
        }
    });

    // Walidacja potwierdzenia hasła
    function validatePasswordConfirmation() {
        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password-confirm').value;
        const confirmField = document.getElementById('password-confirm');

        if (confirmation.length === 0) {
            confirmField.classList.remove('is-valid', 'is-invalid');
        } else if (password === confirmation) {
            confirmField.classList.remove('is-invalid');
            confirmField.classList.add('is-valid');
        } else {
            confirmField.classList.remove('is-valid');
            confirmField.classList.add('is-invalid');
        }
    }

    document.getElementById('password').addEventListener('input', validatePasswordConfirmation);
    document.getElementById('password-confirm').addEventListener('input', validatePasswordConfirmation);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/auth/register.blade.php ENDPATH**/ ?>