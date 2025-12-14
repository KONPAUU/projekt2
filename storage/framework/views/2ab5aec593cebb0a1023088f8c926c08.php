<?php $__env->startSection('title', 'Raporty Frekwencji'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-chart-bar"></i> Raporty Frekwencji</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('teacher.attendance.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Filtry -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter"></i> Generuj raport</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('teacher.attendance.reports')); ?>">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="class_id" class="form-label">Klasa</label>
                            <select class="form-select" id="class_id" name="class_id" required>
                                <option value="">Wybierz klasę</option>
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>" <?php echo e(request('class_id') == $class->id ? 'selected' : ''); ?>>
                                    <?php echo e($class->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="subject_id" class="form-label">Przedmiot</label>
                            <select class="form-select" id="subject_id" name="subject_id" required>
                                <option value="">Wybierz przedmiot</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e(request('subject_id') == $subject->id ? 'selected' : ''); ?>>
                                    <?php echo e($subject->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_from" class="form-label">Od daty</label>
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                   value="<?php echo e(request('date_from', now()->subMonth()->toDateString())); ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="date_to" class="form-label">Do daty</label>
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                   value="<?php echo e(request('date_to', now()->toDateString())); ?>">
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Generuj
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if($reportData): ?>
<!-- Wyniki raportu -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-table"></i> Raport frekwencji</h5>
                    <button class="btn btn-sm btn-success" onclick="window.print()">
                        <i class="fas fa-print"></i> Drukuj
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Uczeń</th>
                                <th class="text-center">Obecności</th>
                                <th class="text-center">Nieobecności</th>
                                <th class="text-center">Spóźnienia</th>
                                <th class="text-center">Usprawiedliwione</th>
                                <th class="text-center">Razem</th>
                                <th class="text-center">Frekwencja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($data['student']->name); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success"><?php echo e($data['present']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger"><?php echo e($data['absent']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning"><?php echo e($data['late']); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?php echo e($data['excused']); ?></span>
                                </td>
                                <td class="text-center">
                                    <strong><?php echo e($data['total']); ?></strong>
                                </td>
                                <td class="text-center">
                                    <?php
                                        $rate = $data['rate'];
                                        $badgeClass = $rate >= 90 ? 'success' : ($rate >= 75 ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge bg-<?php echo e($badgeClass); ?> fs-6"><?php echo e($rate); ?>%</span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>Podsumowanie</th>
                                <th class="text-center"><?php echo e($reportData->sum('present')); ?></th>
                                <th class="text-center"><?php echo e($reportData->sum('absent')); ?></th>
                                <th class="text-center"><?php echo e($reportData->sum('late')); ?></th>
                                <th class="text-center"><?php echo e($reportData->sum('excused')); ?></th>
                                <th class="text-center"><?php echo e($reportData->sum('total')); ?></th>
                                <th class="text-center">
                                    <?php
                                        $totalRecords = $reportData->sum('total');
                                        $totalPresent = $reportData->sum('present') + $reportData->sum('late');
                                        $avgRate = $totalRecords > 0 ? round(($totalPresent / $totalRecords) * 100, 1) : 0;
                                    ?>
                                    <span class="badge bg-primary fs-6"><?php echo e($avgRate); ?>%</span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-chart-pie fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">Wybierz filtry aby wygenerować raport</h4>
                <p class="text-muted">Wybierz klasę, przedmiot i zakres dat powyżej.</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
@media print {
    .btn-toolbar, .card-header .btn, form { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/teacher/attendance/reports.blade.php ENDPATH**/ ?>