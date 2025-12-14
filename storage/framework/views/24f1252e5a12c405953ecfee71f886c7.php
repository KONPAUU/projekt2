<?php $__env->startSection('title', 'Moje Oceny'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('student.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Moje Oceny</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-star"></i> Moje Oceny</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('student.grades.by-subject')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-book"></i> Wg przedmiotów
        </a>
        <a href="<?php echo e(route('student.grades.statistics')); ?>" class="btn btn-outline-success">
            <i class="fas fa-chart-bar"></i> Statystyki
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filtry
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Statystyki podsumowania -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Średnia ogólna
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($stats['overall_average'] ? number_format($stats['overall_average'], 2) : '---'); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Liczba ocen
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_grades']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
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
                            Najwyższa ocena
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['highest_grade'] ?? '---'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
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
                            Pozycja w klasie
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['class_rank'] ?? '---'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trophy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista ocen -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list"></i> Wszystkie Oceny
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
                            <select name="type" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie typy</option>
                                <option value="sprawdzian" <?php echo e(request('type') == 'sprawdzian' ? 'selected' : ''); ?>>Sprawdzian</option>
                                <option value="kartkówka" <?php echo e(request('type') == 'kartkówka' ? 'selected' : ''); ?>>Kartkówka</option>
                                <option value="odpowiedź" <?php echo e(request('type') == 'odpowiedź' ? 'selected' : ''); ?>>Odpowiedź</option>
                                <option value="projekt" <?php echo e(request('type') == 'projekt' ? 'selected' : ''); ?>>Projekt</option>
                                <option value="praca_domowa" <?php echo e(request('type') == 'praca_domowa' ? 'selected' : ''); ?>>Praca domowa</option>
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
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Data</th>
                                <th>Opis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-2">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                        <span class="fw-bold"><?php echo e($grade->subject->name); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-success text-white rounded-circle">
                                                <?php echo e(strtoupper(substr($grade->teacher->name, 0, 2))); ?>

                                            </div>
                                        </div>
                                        <span><?php echo e($grade->teacher->name); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge fs-6 bg-<?php echo e($grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger'))); ?>">
                                        <?php echo e($grade->grade); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e($grade->weight); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e(ucfirst($grade->type)); ?></span>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold"><?php echo e($grade->created_at->format('d.m.Y')); ?></span>
                                        <br>
                                        <small class="text-muted"><?php echo e($grade->created_at->format('H:i')); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php if($grade->description): ?>
                                        <span class="text-muted" title="<?php echo e($grade->description); ?>" data-bs-toggle="tooltip">
                                            <?php echo e(Str::limit($grade->description, 40)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">Brak opisu</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Nie masz jeszcze żadnych ocen</h5>
                                    <p class="text-muted">Oceny będą pojawiać się tutaj po wystawieniu przez nauczycieli</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($grades->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($grades->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Wykres średnich -->
<?php if($grades->count() > 0): ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-area"></i> Wykres Średnich z Przedmiotów
                </h6>
            </div>
            <div class="card-body">
                <canvas id="subjectAveragesChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Modal filtrów -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtry Ocen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Przedmiot</label>
                            <select name="subject_id" class="form-select">
                                <option value="">Wszystkie przedmioty</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e(request('subject_id') == $subject->id ? 'selected' : ''); ?>>
                                    <?php echo e($subject->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Typ oceny</label>
                            <select name="type" class="form-select">
                                <option value="">Wszystkie typy</option>
                                <option value="sprawdzian" <?php echo e(request('type') == 'sprawdzian' ? 'selected' : ''); ?>>Sprawdzian</option>
                                <option value="kartkówka" <?php echo e(request('type') == 'kartkówka' ? 'selected' : ''); ?>>Kartkówka</option>
                                <option value="odpowiedź" <?php echo e(request('type') == 'odpowiedź' ? 'selected' : ''); ?>>Odpowiedź ustna</option>
                                <option value="projekt" <?php echo e(request('type') == 'projekt' ? 'selected' : ''); ?>>Projekt</option>
                                <option value="praca_domowa" <?php echo e(request('type') == 'praca_domowa' ? 'selected' : ''); ?>>Praca domowa</option>
                                <option value="aktywność" <?php echo e(request('type') == 'aktywność' ? 'selected' : ''); ?>>Aktywność</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Data od</label>
                            <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data do</label>
                            <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Ocena od</label>
                            <select name="grade_from" class="form-select">
                                <option value="">Wybierz</option>
                                <?php for($i = 1; $i <= 6; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(request('grade_from') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ocena do</label>
                            <select name="grade_to" class="form-select">
                                <option value="">Wybierz</option>
                                <?php for($i = 1; $i <= 6; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(request('grade_to') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo e(route('student.grades.index')); ?>" class="btn btn-secondary">Wyczyść filtry</a>
                    <button type="submit" class="btn btn-primary">Zastosuj filtry</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if($grades->count() > 0): ?>
// Wykres średnich z przedmiotów
const ctx = document.getElementById('subjectAveragesChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($subjectAverages->pluck('name')->toArray()); ?>,
        datasets: [{
            label: 'Średnia z przedmiotu',
            data: <?php echo json_encode($subjectAverages->pluck('average')->toArray()); ?>,
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796',
                '#5a5c69'
            ],
            borderColor: '#ffffff',
            borderWidth: 2
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
                beginAtZero: false,
                min: 1,
                max: 6,
                ticks: {
                    stepSize: 0.5
                }
            }
        }
    }
});
<?php endif; ?>

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
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/student/grades/index.blade.php ENDPATH**/ ?>