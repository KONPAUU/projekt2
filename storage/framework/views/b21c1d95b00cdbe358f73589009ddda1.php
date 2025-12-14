<?php $__env->startSection('title', 'Informacje o klasie'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-users"></i> Informacje o klasie <?php echo e($class->name); ?></h2>
        </div>
    </div>

    <!-- Informacje o klasie -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-info-circle"></i> Dane klasy</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nazwa:</strong> <?php echo e($class->name); ?></p>
                    <p><strong>Rok szkolny:</strong> <?php echo e($class->year); ?></p>
                    <p><strong>Liczba uczniów:</strong> <?php echo e($classmates->count()); ?></p>
                    <p><strong>Wychowawca:</strong> <?php echo e($tutor ? $tutor->name : 'Brak'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-book"></i> Przedmioty</h5>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="mb-2">
                            <strong><?php echo e($subject->name); ?></strong>
                            <?php $__currentLoopData = $subject->classSubjectTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                - <?php echo e($cst->teacher->name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted">Brak przypisanych przedmiotów.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista uczniów -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-user-friends"></i> Uczniowie klasy</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imię i nazwisko</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $classmates->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $classmate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <?php if($classmate->id == auth()->id()): ?>
                                        <strong><?php echo e($classmate->name); ?></strong> <span class="badge bg-primary">Ty</span>
                                    <?php else: ?>
                                        <?php echo e($classmate->name); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($classmate->email); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/class/info.blade.php ENDPATH**/ ?>