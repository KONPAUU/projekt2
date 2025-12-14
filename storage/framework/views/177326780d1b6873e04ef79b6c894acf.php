<?php $__env->startSection('title', 'Ranking klasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-trophy"></i> Ranking klasy <?php echo e($class->name); ?></h2>
        </div>
    </div>

    <?php if($myRank): ?>
        <div class="alert alert-info mb-4">
            <i class="fas fa-medal"></i> Twoja pozycja w rankingu: <strong><?php echo e($myRank); ?></strong> miejsce
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5><i class="fas fa-chart-line"></i> Ranking według średniej ocen</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pozycja</th>
                            <th>Uczeń</th>
                            <th>Średnia</th>
                            <th>Liczba ocen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($item['student']->id == auth()->id() ? 'table-primary' : ''); ?>">
                                <td>
                                    <?php if($index < 3): ?>
                                        <span class="fs-4">
                                            <?php if($index == 0): ?> 🥇
                                            <?php elseif($index == 1): ?> 🥈
                                            <?php elseif($index == 2): ?> 🥉
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                    <strong><?php echo e($index + 1); ?></strong>
                                </td>
                                <td>
                                    <?php if($item['student']->id == auth()->id()): ?>
                                        <strong><?php echo e($item['student']->name); ?></strong>
                                        <span class="badge bg-primary">Ty</span>
                                    <?php else: ?>
                                        <?php echo e($item['student']->name); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($item['average'] >= 4.5 ? 'success' : ($item['average'] >= 3 ? 'warning' : 'danger')); ?> fs-6">
                                        <?php echo e(number_format($item['average'], 2)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($item['grades_count']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($ranking->isEmpty()): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak danych do wyświetlenia rankingu.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="alert alert-secondary mt-4">
        <i class="fas fa-info-circle"></i> Ranking uwzględnia średnią ważoną ze wszystkich przedmiotów.
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/class/ranking.blade.php ENDPATH**/ ?>