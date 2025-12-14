<?php $__env->startSection('title', 'Przedmioty'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-book-open"></i> Moje przedmioty</h2>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo e($subject->name); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Średnia</h6>
                            <h2 class="text-primary"><?php echo e(number_format($subject->average, 2)); ?></h2>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Liczba ocen:</strong> <?php echo e($subject->grades_count); ?></p>
                            <p class="mb-0 text-muted"><?php echo e($subject->description); ?></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo e(route('student.grades.by-subject', $subject->id)); ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Zobacz oceny
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak przedmiotów z ocenami.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/grades/subjects.blade.php ENDPATH**/ ?>