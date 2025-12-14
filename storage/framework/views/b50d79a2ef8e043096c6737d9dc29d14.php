<?php $__env->startSection('title', 'Moje Przedmioty'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Strona główna</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('teacher.dashboard')); ?>">Panel Nauczyciela</a></li>
<li class="breadcrumb-item active">Moje Przedmioty</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-book-open"></i> Moje Przedmioty</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('teacher.grades.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Dodaj ocenę
        </a>
        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót do Dashboard
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Statystyki ogólne -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Liczba przedmiotów</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo e($subjectsWithStats->count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Łącznie uczniów</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo e($subjectsWithStats->sum('students_count')); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Łącznie klas</div>
                        <div class="h5 mb-0 font-weight-bold"><?php echo e($subjectsWithStats->pluck('classes')->flatten()->unique('id')->count()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if($subjectsWithStats->count() > 0): ?>
        <!-- Lista przedmiotów -->
        <div class="row">
            <?php $__currentLoopData = $subjectsWithStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card shadow-lg border-0 h-100 subject-card">
                    <div class="card-header bg-gradient-<?php echo e($loop->index % 4 == 0 ? 'primary' : ($loop->index % 4 == 1 ? 'success' : ($loop->index % 4 == 2 ? 'info' : 'warning'))); ?> text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open me-2"></i><?php echo e($subject->name); ?>

                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Statystyki przedmiotu -->
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="stat-box">
                                    <div class="stat-value text-primary"><?php echo e($subject->students_count); ?></div>
                                    <div class="stat-label">Uczniów</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <div class="stat-value text-success"><?php echo e($subject->grades_count); ?></div>
                                    <div class="stat-label">Ocen</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <div class="stat-value text-info">
                                        <?php echo e($subject->average_grade ? number_format($subject->average_grade, 2) : '—'); ?>

                                    </div>
                                    <div class="stat-label">Średnia</div>
                                </div>
                            </div>
                        </div>

                        <!-- Klasy -->
                        <h6 class="text-muted mb-2"><i class="fas fa-door-open"></i> Klasy:</h6>
                        <div class="classes-list mb-3">
                            <?php if($subject->classes && $subject->classes->count() > 0): ?>
                                <?php $__currentLoopData = $subject->classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-secondary me-1 mb-1"><?php echo e($class->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted small">Brak przypisanych klas</span>
                            <?php endif; ?>
                        </div>

                        <!-- Opis -->
                        <?php if($subject->description): ?>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle"></i> <?php echo e(Str::limit($subject->description, 100)); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('teacher.grades.index', ['subject_id' => $subject->id])); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-star"></i> Oceny
                            </a>
                            <a href="<?php echo e(route('teacher.grades.create')); ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Dodaj ocenę
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <!-- Brak przedmiotów -->
        <div class="card shadow-lg border-0">
            <div class="card-body text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-book fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Brak przypisanych przedmiotów</h4>
                    <p class="text-muted mb-4">
                        Nie masz jeszcze przypisanych żadnych przedmiotów do prowadzenia.<br>
                        Skontaktuj się z administratorem, aby przypisał Ci przedmioty i klasy.
                    </p>
                    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> Powrót do Dashboard
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
}
.bg-gradient-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important;
}
.bg-gradient-info {
    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important;
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important;
}

.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }

.empty-state {
    max-width: 500px;
    margin: 0 auto;
}

.subject-card {
    transition: all 0.3s ease;
    border: none;
}

.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border: none;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.shadow-lg {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

.stat-box {
    padding: 10px;
    background: #f8f9fc;
    border-radius: 8px;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.75rem;
    color: #858796;
    text-transform: uppercase;
}

.classes-list .badge {
    font-size: 0.8rem;
    font-weight: 500;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/teacher/subjects/index.blade.php ENDPATH**/ ?>