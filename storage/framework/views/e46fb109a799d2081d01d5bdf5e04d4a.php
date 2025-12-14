<?php $__env->startSection('title', 'Moja Frekwencja'); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-calendar-check"></i> Moja Frekwencja</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('student.attendance.calendar')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-calendar"></i> Kalendarz
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statsModal">
            <i class="fas fa-chart-pie"></i> Statystyki
        </button>
        <button type="button" class="btn btn-outline-success" onclick="exportAttendance()">
            <i class="fas fa-download"></i> Eksport
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Statystyki frekwencji -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Frekwencja ogólna
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($stats['attendance_rate'], 1)); ?>%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Obecności
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['present_count']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Nieobecności
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['absent_count']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Spóźnienia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['late_count']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wykres frekwencji -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line"></i> Frekwencja w czasie
                </h6>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i> Rozkład obecności
                </h6>
            </div>
            <div class="card-body">
                <canvas id="attendancePieChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Lista frekwencji -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list"></i> Historia Frekwencji
                        </h6>
                    </div>
                    <div class="col-auto">
                        <form method="GET" class="d-flex">
                            <select name="subject_id" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie przedmioty</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e(request('subject_id') == $subject->id ? 'selected' : ''); ?>>
                                    <?php echo e($subject->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Wszystkie statusy</option>
                                <option value="present" <?php echo e(request('status') == 'present' ? 'selected' : ''); ?>>Obecny</option>
                                <option value="absent" <?php echo e(request('status') == 'absent' ? 'selected' : ''); ?>>Nieobecny</option>
                                <option value="late" <?php echo e(request('status') == 'late' ? 'selected' : ''); ?>>Spóźniony</option>
                                <option value="excused" <?php echo e(request('status') == 'excused' ? 'selected' : ''); ?>>Usprawiedliwiony</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Godzina</th>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Status</th>
                                <th>Uwagi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold"><?php echo e($attendance->date->format('d.m.Y')); ?></span>
                                        <br>
                                        <small class="text-muted"><?php echo e($attendance->date->locale('pl')->dayName); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?php echo e($attendance->lesson_hour ?? 'Lekcja'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-2">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                        <span class="fw-bold"><?php echo e($attendance->subject->name); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($attendance->teacher): ?>
                                            <div class="avatar avatar-sm me-2">
                                                <div class="avatar-title bg-success text-white rounded-circle">
                                                    <?php echo e(strtoupper(substr($attendance->teacher->name, 0, 2))); ?>

                                                </div>
                                            </div>
                                            <span><?php echo e($attendance->teacher->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $statusConfig = [
                                            'present' => ['class' => 'success', 'icon' => 'check', 'text' => 'Obecny'],
                                            'absent' => ['class' => 'danger', 'icon' => 'times', 'text' => 'Nieobecny'],
                                            'late' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Spóźniony'],
                                            'excused' => ['class' => 'info', 'icon' => 'user-check', 'text' => 'Usprawiedliwiony']
                                        ];
                                        $config = $statusConfig[$attendance->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Nieznany'];
                                    ?>
                                    <span class="badge bg-<?php echo e($config['class']); ?>">
                                        <i class="fas fa-<?php echo e($config['icon']); ?>"></i> <?php echo e($config['text']); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($attendance->notes): ?>
                                        <span class="text-muted" title="<?php echo e($attendance->notes); ?>" data-bs-toggle="tooltip">
                                            <?php echo e(Str::limit($attendance->notes, 40)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">Brak uwag</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Brak zapisów frekwencji</h5>
                                    <p class="text-muted">Frekwencja będzie widoczna po rozpoczęciu zajęć</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($attendances->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($attendances->links('vendor.pagination.custom')); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal statystyk -->
<div class="modal fade" id="statsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Szczegółowe statystyki frekwencji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Frekwencja według przedmiotów</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Przedmiot</th>
                                        <th>Frekwencja</th>
                                        <th>Lekcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $subjectStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($stat['subject']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($stat['rate'] >= 90 ? 'success' : ($stat['rate'] >= 75 ? 'warning' : 'danger')); ?>">
                                                <?php echo e(number_format($stat['rate'], 1)); ?>%
                                            </span>
                                        </td>
                                        <td><?php echo e($stat['total']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Miesięczne podsumowanie</h6>
                        <div style="position: relative; height: 250px; width: 100%;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Wykres frekwencji w czasie
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chartData['dates'] ?? []); ?>,
        datasets: [{
            label: 'Frekwencja dzienna (%)',
            data: <?php echo json_encode($chartData['rates'] ?? []); ?>,
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Frekwencja: ' + context.parsed.y + '%';
                    }
                }
            }
        }
    }
});

// Wykres kołowy rozkładu obecności
const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
const attendancePieChart = new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['Obecności', 'Nieobecności', 'Spóźnienia', 'Usprawiedliwienia'],
        datasets: [{
            data: [
                <?php echo e($stats['present_count']); ?>,
                <?php echo e($stats['absent_count']); ?>,
                <?php echo e($stats['late_count']); ?>,
                <?php echo e($stats['excused_count'] ?? 0); ?>

            ],
            backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e', '#36b9cc'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Wykres miesięczny w modalu
let monthlyChartInstance = null;
document.getElementById('statsModal').addEventListener('shown.bs.modal', function() {
    // Zniszcz poprzedni wykres jeśli istnieje
    if (monthlyChartInstance) {
        monthlyChartInstance.destroy();
    }

    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    monthlyChartInstance = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthlyData['months'] ?? ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze']); ?>,
            datasets: [{
                label: 'Frekwencja miesięczna (%)',
                data: <?php echo json_encode($monthlyData['rates'] ?? [85, 90, 78, 92, 88, 81]); ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: '#4e73df',
                borderWidth: 2,
                borderRadius: 4,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});

function exportAttendance() {
    alert('Funkcja eksportu będzie dostępna wkrótce.');
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
}
.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.subject-icon {
    font-size: 1.1rem;
}

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/student/attendance/index.blade.php ENDPATH**/ ?>