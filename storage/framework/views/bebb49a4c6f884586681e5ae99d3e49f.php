<?php $__env->startSection('title', 'Ostatnie zmiany ocen'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-history"></i> Ostatnie zmiany ocen</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Statystyki -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Zmiany dzisiaj</h6>
                    <h2 class="text-primary"><?php echo e($stats['today_changes']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Zmiany w tym tygodniu</h6>
                    <h2 class="text-info"><?php echo e($stats['week_changes']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Wszystkie zmiany</h6>
                    <h2><?php echo e($stats['total_changes']); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista zmian -->
    <div class="card">
        <div class="card-header">
            <h5>Historia zmian</h5>
        </div>
        <div class="card-body">
            <?php if($recentHistories->isEmpty()): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak zmian ocen w historii.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data zmiany</th>
                                <th>Uczeń</th>
                                <th>Przedmiot</th>
                                <th>Stara ocena</th>
                                <th>Nowa ocena</th>
                                <th>Kto zmienił</th>
                                <th>Powód</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($history->created_at->format('d.m.Y H:i')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('teacher.grades.index', ['student_id' => $history->grade->student->id])); ?>">
                                            <?php echo e($history->grade->student->name); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($history->grade->subject->name); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($history->old_grade); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge
                                            <?php if($history->new_grade > $history->old_grade): ?> bg-success
                                            <?php elseif($history->new_grade < $history->old_grade): ?> bg-danger
                                            <?php else: ?> bg-primary
                                            <?php endif; ?>">
                                            <?php echo e($history->new_grade); ?>

                                            <?php if($history->new_grade > $history->old_grade): ?>
                                                <i class="fas fa-arrow-up"></i>
                                            <?php elseif($history->new_grade < $history->old_grade): ?>
                                                <i class="fas fa-arrow-down"></i>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td><?php echo e($history->changedBy->name); ?></td>
                                    <td><?php echo e($history->reason ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($recentHistories->links('vendor.pagination.custom')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Custom Pagination Styles */
.pagination-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-custom .page-item {
    display: inline-block;
}

.pagination-custom .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    min-width: 36px;
    padding: 0;
    font-size: 1rem;
    line-height: 1;
    color: #4e73df;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-custom .page-link:hover {
    background-color: #f8f9fa;
    border-color: #4e73df;
    color: #2e59d9;
}

.pagination-custom .page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: #fff;
    font-weight: 600;
}

.pagination-custom .page-item.disabled .page-link {
    color: #d1d5db;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/teacher/grades/recent-changes.blade.php ENDPATH**/ ?>