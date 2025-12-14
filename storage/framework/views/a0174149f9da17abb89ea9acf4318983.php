<?php $__env->startSection('title', 'Eksport danych do PDF'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Strona główna</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Panel Administratora</a></li>
<li class="breadcrumb-item active">Eksport PDF</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-file-pdf"></i> Eksport danych do PDF</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-export"></i> Wybierz dane do eksportu</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    <i class="fas fa-info-circle"></i> Zaznacz sekcje, które mają zostać uwzględnione w raporcie PDF.
                </p>

                <form action="<?php echo e(route('admin.export.generate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="sections[]" value="summary" id="section_summary" checked>
                            <label class="form-check-label fw-bold" for="section_summary">
                                <i class="fas fa-chart-pie text-primary"></i> Podsumowanie statystyk
                            </label>
                            <small class="d-block text-muted ms-4">
                                Ogólne statystyki: liczba użytkowników, uczniów, nauczycieli, klas, przedmiotów, ocen i średnia ocen
                            </small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="sections[]" value="classes" id="section_classes" checked>
                            <label class="form-check-label fw-bold" for="section_classes">
                                <i class="fas fa-layer-group text-success"></i> Struktura klas
                            </label>
                            <small class="d-block text-muted ms-4">
                                Tabela ze wszystkimi klasami, rokiem, liczbą uczniów i przedmiotów
                            </small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="sections[]" value="top_students" id="section_top_students" checked>
                            <label class="form-check-label fw-bold" for="section_top_students">
                                <i class="fas fa-trophy text-warning"></i> Najaktywniejsi uczniowie
                            </label>
                            <small class="d-block text-muted ms-4">
                                Top 10 uczniów z największą liczbą ocen
                            </small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="sections[]" value="top_teachers" id="section_top_teachers" checked>
                            <label class="form-check-label fw-bold" for="section_top_teachers">
                                <i class="fas fa-star text-info"></i> Najaktywniejsi nauczyciele
                            </label>
                            <small class="d-block text-muted ms-4">
                                Top 10 nauczycieli, którzy wystawili najwięcej ocen
                            </small>
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <strong><i class="fas fa-exclamation-triangle"></i> Błąd:</strong>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-download"></i> Generuj i pobierz PDF
                        </button>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 border-info">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-lightbulb text-info"></i> Wskazówki</h6>
                <ul class="mb-0">
                    <li>Wybierz co najmniej jedną sekcję do wygenerowania raportu</li>
                    <li>Raport zostanie automatycznie pobrany po kliknięciu przycisku</li>
                    <li>Nazwa pliku zawiera datę i godzinę wygenerowania</li>
                    <li>Format pliku: PDF (A4, pionowo)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
}

.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/export/form.blade.php ENDPATH**/ ?>