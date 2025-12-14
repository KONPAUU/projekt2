<?php $__env->startSection('title', 'Kalendarz frekwencji'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-calendar-alt"></i> Kalendarz frekwencji</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <a href="<?php echo e(route('student.attendance.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <!-- Nagłówek z nawigacją -->
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="?month=<?php echo e($month == 1 ? 12 : $month - 1); ?>&year=<?php echo e($month == 1 ? $year - 1 : $year); ?>"
                       class="btn btn-light btn-sm">
                        <i class="fas fa-chevron-left"></i> Poprzedni
                    </a>
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-calendar me-2"></i>
                        <?php
                            $monthNames = [
                                1 => 'Styczeń', 2 => 'Luty', 3 => 'Marzec', 4 => 'Kwiecień',
                                5 => 'Maj', 6 => 'Czerwiec', 7 => 'Lipiec', 8 => 'Sierpień',
                                9 => 'Wrzesień', 10 => 'Październik', 11 => 'Listopad', 12 => 'Grudzień'
                            ];
                        ?>
                        <?php echo e($monthNames[$month]); ?> <?php echo e($year); ?>

                    </h4>
                    <a href="?month=<?php echo e($month == 12 ? 1 : $month + 1); ?>&year=<?php echo e($month == 12 ? $year + 1 : $year); ?>"
                       class="btn btn-light btn-sm">
                        Następny <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Kalendarz -->
                <div class="calendar-grid">
                    <!-- Nagłówki dni tygodnia -->
                    <div class="calendar-header">
                        <div class="calendar-day-name">Poniedziałek</div>
                        <div class="calendar-day-name">Wtorek</div>
                        <div class="calendar-day-name">Środa</div>
                        <div class="calendar-day-name">Czwartek</div>
                        <div class="calendar-day-name">Piątek</div>
                        <div class="calendar-day-name weekend">Sobota</div>
                        <div class="calendar-day-name weekend">Niedziela</div>
                    </div>

                    <!-- Dni miesiąca -->
                    <div class="calendar-body">
                        <?php
                            $day = 1;
                            $currentDay = $firstDayOfWeek == 0 ? 6 : $firstDayOfWeek - 1;
                            $today = now()->format('Y-m-d');
                        ?>
                        <?php for($week = 0; $week < 6; $week++): ?>
                            <?php for($dow = 0; $dow < 7; $dow++): ?>
                                <?php if(($week == 0 && $dow < $currentDay) || $day > $daysInMonth): ?>
                                    <div class="calendar-cell empty"></div>
                                <?php else: ?>
                                    <?php
                                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                        $dayAttendances = $attendances->get($dateStr, collect());
                                        $isToday = $dateStr === $today;
                                        $isWeekend = $dow >= 5;
                                        $hasPresent = $dayAttendances->where('status', 'present')->count();
                                        $hasAbsent = $dayAttendances->where('status', 'absent')->count();
                                        $hasLate = $dayAttendances->where('status', 'late')->count();
                                    ?>
                                    <div class="calendar-cell <?php echo e($isToday ? 'today' : ''); ?> <?php echo e($isWeekend ? 'weekend' : ''); ?> <?php echo e($dayAttendances->isNotEmpty() ? 'has-attendance' : ''); ?>"
                                         <?php if($dayAttendances->isNotEmpty()): ?> data-bs-toggle="tooltip" data-bs-html="true" title="<?php $__currentLoopData = $dayAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class='text-start'><span class='badge bg-<?php echo e($att->status == 'present' ? 'success' : ($att->status == 'late' ? 'warning' : ($att->status == 'absent' ? 'danger' : 'secondary'))); ?> me-1'><?php echo e($att->status == 'present' ? '✓' : ($att->status == 'late' ? '⏰' : ($att->status == 'absent' ? '✗' : '?'))); ?></span><?php echo e($att->subject->name); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" <?php endif; ?>>
                                        <div class="day-number <?php echo e($isToday ? 'bg-primary text-white' : ''); ?>"><?php echo e($day); ?></div>
                                        <div class="day-content">
                                            <?php if($dayAttendances->isNotEmpty()): ?>
                                                <div class="attendance-dots">
                                                    <?php $__currentLoopData = $dayAttendances->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="attendance-dot <?php echo e($att->status); ?>"></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($dayAttendances->count() > 4): ?>
                                                        <span class="more-indicator">+<?php echo e($dayAttendances->count() - 4); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="attendance-summary">
                                                    <?php if($hasPresent): ?>
                                                        <span class="summary-badge present"><?php echo e($hasPresent); ?></span>
                                                    <?php endif; ?>
                                                    <?php if($hasLate): ?>
                                                        <span class="summary-badge late"><?php echo e($hasLate); ?></span>
                                                    <?php endif; ?>
                                                    <?php if($hasAbsent): ?>
                                                        <span class="summary-badge absent"><?php echo e($hasAbsent); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php $day++; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if($day > $daysInMonth): ?> <?php break; ?> <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Legenda -->
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center gap-4 flex-wrap">
                    <div class="legend-item">
                        <span class="attendance-dot present large"></span>
                        <span>Obecny</span>
                    </div>
                    <div class="legend-item">
                        <span class="attendance-dot late large"></span>
                        <span>Spóźniony</span>
                    </div>
                    <div class="legend-item">
                        <span class="attendance-dot absent large"></span>
                        <span>Nieobecny</span>
                    </div>
                    <div class="legend-item">
                        <span class="attendance-dot excused large"></span>
                        <span>Usprawiedliwiony</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statystyki miesiąca -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Obecności</div>
                <?php
                    $monthPresent = collect($attendances)->flatten()->where('status', 'present')->count();
                ?>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($monthPresent); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Spóźnienia</div>
                <?php
                    $monthLate = collect($attendances)->flatten()->where('status', 'late')->count();
                ?>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($monthLate); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-danger shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Nieobecności</div>
                <?php
                    $monthAbsent = collect($attendances)->flatten()->where('status', 'absent')->count();
                ?>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($monthAbsent); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Frekwencja</div>
                <?php
                    $monthTotal = $monthPresent + $monthLate + $monthAbsent;
                    $monthRate = $monthTotal > 0 ? round(($monthPresent + $monthLate) / $monthTotal * 100, 1) : 0;
                ?>
                <div class="h5 mb-0 font-weight-bold"><?php echo e($monthRate); ?>%</div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.calendar-grid {
    width: 100%;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: #f8f9fc;
    border-bottom: 2px solid #e3e6f0;
}

.calendar-day-name {
    padding: 15px 10px;
    text-align: center;
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.calendar-day-name.weekend {
    color: #e74a3b;
}

.calendar-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.calendar-cell {
    min-height: 100px;
    border: 1px solid #e3e6f0;
    padding: 8px;
    position: relative;
    transition: all 0.2s ease;
    background: white;
}

.calendar-cell:hover:not(.empty) {
    background: #f8f9fc;
    transform: scale(1.02);
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.calendar-cell.empty {
    background: #f8f9fc;
}

.calendar-cell.weekend {
    background: #fff8f8;
}

.calendar-cell.today {
    background: #eef2ff;
    border-color: #4e73df;
}

.calendar-cell.has-attendance {
    cursor: pointer;
}

.day-number {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 8px;
}

.day-content {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.attendance-dots {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: center;
}

.attendance-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.attendance-dot.large {
    width: 16px;
    height: 16px;
}

.attendance-dot.present {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    box-shadow: 0 2px 4px rgba(28, 200, 138, 0.4);
}

.attendance-dot.late {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    box-shadow: 0 2px 4px rgba(246, 194, 62, 0.4);
}

.attendance-dot.absent {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
    box-shadow: 0 2px 4px rgba(231, 74, 59, 0.4);
}

.attendance-dot.excused {
    background: linear-gradient(135deg, #858796 0%, #60616f 100%);
    box-shadow: 0 2px 4px rgba(133, 135, 150, 0.4);
}

.more-indicator {
    font-size: 0.7rem;
    color: #858796;
    font-weight: 600;
}

.attendance-summary {
    display: flex;
    justify-content: center;
    gap: 3px;
}

.summary-badge {
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 600;
    color: white;
}

.summary-badge.present {
    background: #1cc88a;
}

.summary-badge.late {
    background: #f6c23e;
    color: #333;
}

.summary-badge.absent {
    background: #e74a3b;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #5a5c69;
}

.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.border-left-danger { border-left: 4px solid #e74a3b !important; }
.border-left-primary { border-left: 4px solid #4e73df !important; }

/* Responsive */
@media (max-width: 768px) {
    .calendar-day-name {
        font-size: 0.7rem;
        padding: 10px 5px;
    }

    .calendar-cell {
        min-height: 70px;
        padding: 5px;
    }

    .day-number {
        width: 24px;
        height: 24px;
        font-size: 0.8rem;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/attendance/calendar.blade.php ENDPATH**/ ?>