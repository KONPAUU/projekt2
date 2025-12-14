<?php $__env->startSection('title', 'Sprawdzanie obecności - ' . $class->name); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-clipboard-check"></i> Sprawdzanie obecności</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('teacher.attendance.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Informacje o klasie -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-door-open"></i> <?php echo e($class->name); ?> - <?php echo e($subject->name); ?>

                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('teacher.attendance.show-class', ['class' => $class->id, 'subject' => $subject->id])); ?>" class="row align-items-end">
                    <div class="col-md-4">
                        <label for="date" class="form-label">Data</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo e($date); ?>" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted">Uczniów w klasie: <strong><?php echo e($students->count()); ?></strong></span>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="button" class="btn btn-success" onclick="setAllPresent()">
                            <i class="fas fa-check-double"></i> Wszyscy obecni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body">
                <h6 class="text-muted mb-3">Statystyki dnia</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-check text-success"></i> Obecni</span>
                    <span class="badge bg-success"><?php echo e($attendanceStats['present']); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-times text-danger"></i> Nieobecni</span>
                    <span class="badge bg-danger"><?php echo e($attendanceStats['absent']); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-clock text-warning"></i> Spóźnieni</span>
                    <span class="badge bg-warning"><?php echo e($attendanceStats['late']); ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-user-check text-info"></i> Usprawiedliwieni</span>
                    <span class="badge bg-info"><?php echo e($attendanceStats['excused']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularz obecności -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users"></i> Lista uczniów</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('teacher.attendance.store')); ?>" id="attendanceForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="class_id" value="<?php echo e($class->id); ?>">
                    <input type="hidden" name="subject_id" value="<?php echo e($subject->id); ?>">
                    <input type="hidden" name="date" value="<?php echo e($date); ?>">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 30%">Uczeń</th>
                                    <th style="width: 40%">Status</th>
                                    <th style="width: 25%">Uwagi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $attendance = $student->attendances->first();
                                    $currentStatus = $attendance ? $attendance->status : 'present';
                                ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($student->name); ?></strong>
                                    </td>
                                    <td>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>]"
                                                   id="present-<?php echo e($student->id); ?>" value="present"
                                                   <?php echo e($currentStatus == 'present' ? 'checked' : ''); ?>>
                                            <label class="btn btn-outline-success" for="present-<?php echo e($student->id); ?>">
                                                <i class="fas fa-check"></i> Obecny
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>]"
                                                   id="absent-<?php echo e($student->id); ?>" value="absent"
                                                   <?php echo e($currentStatus == 'absent' ? 'checked' : ''); ?>>
                                            <label class="btn btn-outline-danger" for="absent-<?php echo e($student->id); ?>">
                                                <i class="fas fa-times"></i> Nieobecny
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>]"
                                                   id="late-<?php echo e($student->id); ?>" value="late"
                                                   <?php echo e($currentStatus == 'late' ? 'checked' : ''); ?>>
                                            <label class="btn btn-outline-warning" for="late-<?php echo e($student->id); ?>">
                                                <i class="fas fa-clock"></i> Spóźniony
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>]"
                                                   id="excused-<?php echo e($student->id); ?>" value="excused"
                                                   <?php echo e($currentStatus == 'excused' ? 'checked' : ''); ?>>
                                            <label class="btn btn-outline-info" for="excused-<?php echo e($student->id); ?>">
                                                <i class="fas fa-user-check"></i> Uspr.
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                               name="notes[<?php echo e($student->id); ?>]"
                                               placeholder="Uwagi..."
                                               value="<?php echo e($attendance->notes ?? ''); ?>">
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('teacher.attendance.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Zapisz obecność
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function setAllPresent() {
    document.querySelectorAll('input[id^="present-"]').forEach(radio => {
        radio.checked = true;
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.btn-group .btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}
.btn-check:checked + .btn-outline-success {
    background-color: #198754;
    color: white;
}
.btn-check:checked + .btn-outline-danger {
    background-color: #dc3545;
    color: white;
}
.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    color: black;
}
.btn-check:checked + .btn-outline-info {
    background-color: #0dcaf0;
    color: black;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/teacher/attendance/show-class.blade.php ENDPATH**/ ?>