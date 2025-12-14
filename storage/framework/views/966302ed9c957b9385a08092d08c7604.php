<?php $__env->startSection('title', 'Oceny z przedmiotu: ' . $subject->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-book"></i> Oceny z przedmiotu: <?php echo e($subject->name); ?></h2>
        </div>
    </div>

    <!-- Statystyki -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Średnia</h5>
                    <h2 class="text-primary"><?php echo e(number_format($average, 2)); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Liczba ocen</h5>
                    <h2><?php echo e($stats['total_grades']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Najlepsza</h5>
                    <h2 class="text-success"><?php echo e($stats['best_grade'] ?? '-'); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Najgorsza</h5>
                    <h2 class="text-danger"><?php echo e($stats['worst_grade'] ?? '-'); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista ocen -->
    <div class="card">
        <div class="card-header">
            <h5>Wszystkie oceny</h5>
        </div>
        <div class="card-body">
            <?php if($grades->isEmpty()): ?>
                <p class="text-muted">Brak ocen z tego przedmiotu.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Opis</th>
                                <th>Nauczyciel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($grade->created_at->format('d.m.Y')); ?></td>
                                    <td>
                                        <span class="badge bg-primary fs-6"><?php echo e($grade->grade); ?></span>
                                    </td>
                                    <td><?php echo e($grade->weight); ?></td>
                                    <td><?php echo e($grade->type); ?></td>
                                    <td><?php echo e($grade->description ?? '-'); ?></td>
                                    <td><?php echo e($grade->teacher->name); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/grades/by-subject.blade.php ENDPATH**/ ?>