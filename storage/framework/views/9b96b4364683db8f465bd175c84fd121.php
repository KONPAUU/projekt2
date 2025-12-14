<?php $__env->startSection('title', 'Średnie ocen'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-calculator"></i> Obliczanie średniej ważonej</h2>
        </div>
    </div>

    <!-- Średnia ogólna -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>Średnia ogólna</h3>
                    <h1 class="display-3"><?php echo e(number_format($overallAverage, 2)); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Średnie z przedmiotów -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie z poszczególnych przedmiotów</h5>
                </div>
                <div class="card-body">
                    <?php if($subjectAverages->isEmpty()): ?>
                        <p class="text-muted">Brak ocen.</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $subjectAverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectId => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><?php echo e($data['subject']->name); ?></h6>
                                    <span class="badge bg-primary fs-5"><?php echo e(number_format($data['average'], 2)); ?></span>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        <strong>Liczba ocen:</strong> <?php echo e($data['grades_count']); ?><br>
                                        <strong>Suma ważona:</strong> <?php echo e($data['total_weighted_sum']); ?><br>
                                        <strong>Suma wag:</strong> <?php echo e($data['total_weight']); ?>

                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Ocena</th>
                                                    <th>Waga</th>
                                                    <th>Wartość ważona</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $data['grade_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($detail['grade']->grade); ?></td>
                                                        <td><?php echo e($detail['grade']->weight); ?></td>
                                                        <td><?php echo e($detail['weighted_value']); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/grades/average.blade.php ENDPATH**/ ?>