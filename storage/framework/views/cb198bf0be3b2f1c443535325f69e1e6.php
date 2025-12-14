<?php $__env->startSection('title', 'Statystyki ocen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-chart-bar"></i> Statystyki ocen</h2>
        </div>
    </div>

    <!-- Podstawowe statystyki -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Średnia ogólna</h6>
                    <h2 class="text-primary"><?php echo e(number_format($overallAverage, 2)); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Liczba ocen</h6>
                    <h2><?php echo e($totalGrades); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Najlepsza ocena</h6>
                    <h2 class="text-success"><?php echo e($bestGrade ?? '-'); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Najgorsza ocena</h6>
                    <h2 class="text-danger"><?php echo e($worstGrade ?? '-'); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Rozkład ocen -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rozkład ocen</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ocena</th>
                                <th>Liczba</th>
                                <th>Procent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $gradeDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><span class="badge bg-primary"><?php echo e($dist->grade); ?></span></td>
                                    <td><?php echo e($dist->count); ?></td>
                                    <td><?php echo e(round(($dist->count / $totalGrades) * 100, 1)); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statystyki według typu -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie według typu oceny</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Typ</th>
                                <th>Średnia</th>
                                <th>Liczba</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $typeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($stat->type); ?></td>
                                    <td><?php echo e(number_format($stat->average, 2)); ?></td>
                                    <td><?php echo e($stat->count); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statystyki miesięczne -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie miesięczne</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Miesiąc</th>
                                <th>Średnia</th>
                                <th>Liczba ocen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $monthlyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($stat->month); ?>/<?php echo e($stat->year); ?></td>
                                    <td><?php echo e(number_format($stat->average, 2)); ?></td>
                                    <td><?php echo e($stat->count); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/grades/statistics.blade.php ENDPATH**/ ?>