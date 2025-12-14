<?php $__env->startSection('title', 'Przedmiot: ' . $subject->name); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-book"></i> <?php echo e($subject->name); ?></h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('admin.subjects.edit', $subject)); ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="<?php echo e(route('admin.subjects.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Statystyki -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Klasy</div>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['classes_count']); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nauczyciele</div>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['teachers_count']); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Liczba ocen</div>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['grades_count']); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Średnia ocen</div>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['average_grade'] ? number_format($stats['average_grade'], 2) : '-'); ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informacje o przedmiocie -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informacje</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Nazwa:</th>
                        <td><?php echo e($subject->name); ?></td>
                    </tr>
                    <tr>
                        <th>Kod:</th>
                        <td><?php echo e($subject->code ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Kategoria:</th>
                        <td><?php echo e($subject->category ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Godziny/tydzień:</th>
                        <td><?php echo e($subject->hours_per_week ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Obowiązkowy:</th>
                        <td>
                            <?php if($subject->is_mandatory): ?>
                                <span class="badge bg-success">Tak</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nie</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Egzamin końcowy:</th>
                        <td>
                            <?php if($subject->has_final_exam): ?>
                                <span class="badge bg-warning">Tak</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nie</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <?php if($subject->description): ?>
                <hr>
                <h6>Opis:</h6>
                <p class="text-muted"><?php echo e($subject->description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Nauczyciele -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-user-tie"></i> Nauczyciele (<?php echo e($subject->teachers->unique('id')->count()); ?>)</h6>
            </div>
            <div class="card-body">
                <?php if($subject->teachers->unique('id')->count() > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $subject->teachers->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="avatar avatar-sm me-2">
                                <div class="avatar-title bg-success text-white rounded-circle">
                                    <?php echo e(strtoupper(substr($teacher->name, 0, 2))); ?>

                                </div>
                            </div>
                            <div>
                                <strong><?php echo e($teacher->name); ?></strong><br>
                                <small class="text-muted"><?php echo e($teacher->email); ?></small>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Brak przypisanych nauczycieli</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Klasy -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-door-open"></i> Klasy (<?php echo e($subject->classes->unique('id')->count()); ?>)</h6>
            </div>
            <div class="card-body">
                <?php if($subject->classes->unique('id')->count() > 0): ?>
                    <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $subject->classes->unique('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.classes.show', $class)); ?>" class="btn btn-outline-info">
                            <i class="fas fa-door-open"></i> <?php echo e($class->name); ?>

                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Brak przypisanych klas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Ostatnie oceny -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-star"></i> Ostatnie oceny (<?php echo e(min($subject->grades->count(), 20)); ?> z <?php echo e($subject->grades->count()); ?>)</h6>
            </div>
            <div class="card-body">
                <?php if($subject->grades->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Uczeń</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $subject->grades->sortByDesc('created_at')->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($grade->student->name ?? 'Nieznany'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($grade->grade >= 4 ? 'success' : ($grade->grade >= 3 ? 'warning' : 'danger')); ?> fs-6">
                                        <?php echo e($grade->grade); ?>

                                    </span>
                                </td>
                                <td><?php echo e($grade->weight); ?></td>
                                <td><?php echo e($grade->type ?? '-'); ?></td>
                                <td><?php echo e($grade->created_at->format('d.m.Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted text-center mb-0">Brak ocen dla tego przedmiotu</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.avatar-sm { width: 2rem; height: 2rem; }
.avatar-title {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 600;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/subjects/show.blade.php ENDPATH**/ ?>