<?php $__env->startSection('title', 'Panel Administracyjny'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Strona główna</a></li>
<li class="breadcrumb-item active">Panel Administracyjny</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-tachometer-alt text-primary"></i> Panel Administracyjny</h1>
        <p class="mb-0 text-muted">Zarządzaj systemem dziennika lekcyjnego</p>
    </div>
    <div class="btn-toolbar">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-primary shadow-sm" onclick="refreshStats()">
                <i class="fas fa-sync-alt"></i> Odśwież
            </button>
            <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-success shadow-sm">
                <i class="fas fa-chart-bar"></i> Raporty
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Karty statystyk głównych -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-primary text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                            Łączni Użytkownicy
                        </div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo e($stats['total_users']); ?></div>
                        <div class="mt-2 mb-0 text-white-50 text-xs">
                            <i class="fas fa-arrow-up"></i> Aktywni w systemie
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-success text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                            Uczniowie
                        </div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo e($stats['total_students']); ?></div>
                        <div class="mt-2 mb-0 text-white-50 text-xs">
                            <i class="fas fa-graduation-cap"></i> Zarejestrowanych
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-user-graduate fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-info text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                            Nauczyciele
                        </div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo e($stats['total_teachers']); ?></div>
                        <div class="mt-2 mb-0 text-white-50 text-xs">
                            <i class="fas fa-chalkboard"></i> Pracujących
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-gradient-warning text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                            Średnia Systemu
                        </div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo e(number_format($stats['average_grade'], 2)); ?></div>
                        <div class="mt-2 mb-0 text-white-50 text-xs">
                            <i class="fas fa-star"></i> Z wszystkich ocen
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="fas fa-chart-line fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dodatkowe statystyki -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-primary bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-door-open text-primary"></i>
                </div>
                <div class="fw-bold text-primary"><?php echo e($stats['total_classes']); ?></div>
                <small class="text-muted">Klas</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-success bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-book text-success"></i>
                </div>
                <div class="fw-bold text-success"><?php echo e($stats['total_subjects']); ?></div>
                <small class="text-muted">Przedmiotów</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-info bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-star text-info"></i>
                </div>
                <div class="fw-bold text-info"><?php echo e($stats['total_grades']); ?></div>
                <small class="text-muted">Ocen</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-warning bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-calendar-check text-warning"></i>
                </div>
                <div class="fw-bold text-warning"><?php echo e($recentGrades->where('created_at', '>=', now()->startOfDay())->count()); ?></div>
                <small class="text-muted">Dziś</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-danger bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-clock text-danger"></i>
                </div>
                <div class="fw-bold text-danger"><?php echo e($recentGrades->where('created_at', '>=', now()->subDays(7))->count()); ?></div>
                <small class="text-muted">Ten tydzień</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-3">
                <div class="icon-circle-sm bg-secondary bg-opacity-10 mx-auto mb-2">
                    <i class="fas fa-calendar text-secondary"></i>
                </div>
                <div class="fw-bold text-secondary"><?php echo e($recentGrades->where('created_at', '>=', now()->subDays(30))->count()); ?></div>
                <small class="text-muted">Ten miesiąc</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Szczegółowe statystyki -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie"></i> Statystyki systemu
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="border-left-success pl-3 mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Klasy</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_classes']); ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border-left-info pl-3 mb-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Przedmioty</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_subjects']); ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border-left-warning pl-3 mb-3">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Oceny</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total_grades']); ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border-left-danger pl-3 mb-3">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Aktywność dziś</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($recentGrades->where('created_at', '>=', now()->startOfDay())->count()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wykres rozkładu ocen -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar"></i> Rozkład ocen w systemie
                </h6>
            </div>
            <div class="card-body">
                <canvas id="gradeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Ostatnie oceny -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock"></i> Ostatnie wpisy ocen
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="<?php echo e(route('admin.reports')); ?>">
                            <i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i>
                            Zobacz wszystkie raporty
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Uczeń</th>
                                <th>Nauczyciel</th>
                                <th>Przedmiot</th>
                                <th>Ocena</th>
                                <th>Typ</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-light text-dark rounded-circle">
                                                <?php echo e(strtoupper(substr($grade->student->name, 0, 2))); ?>

                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?php echo e($grade->student->name); ?></div>
                                            <small class="text-muted"><?php echo e($grade->student->schoolClass->name ?? 'Brak klasy'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($grade->teacher->name); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark"><?php echo e($grade->subject->name); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger'))); ?>">
                                        <?php echo e($grade->grade); ?>

                                    </span>
                                    <small class="text-muted">(waga: <?php echo e($grade->weight); ?>)</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($grade->type)); ?></span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e($grade->created_at->format('d.m.Y H:i')); ?>

                                    </small>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Brak ostatnich ocen
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Szybkie akcje -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt"></i> Szybkie akcje
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Dodaj użytkownika
                    </a>
                    <a href="<?php echo e(route('admin.classes.create')); ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Utwórz klasę
                    </a>
                    <a href="<?php echo e(route('admin.subjects.create')); ?>" class="btn btn-info">
                        <i class="fas fa-book-open"></i> Dodaj przedmiot
                    </a>
                    <hr>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-users"></i> Zarządzaj użytkownikami
                    </a>
                    <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-outline-success">
                        <i class="fas fa-chart-line"></i> Zobacz raporty
                    </a>
                </div>
            </div>
        </div>

        <!-- Ostatnie logowania -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-sign-in-alt"></i> Aktywność użytkowników
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="h4 font-weight-bold text-success"><?php echo e($stats['total_users']); ?></div>
                    <div class="text-xs text-uppercase text-muted">Zarejestrowanych użytkowników</div>
                </div>
                <hr>
                <div class="small text-muted">
                    <p class="mb-1"><i class="fas fa-circle text-success"></i> Administratorzy:
                        <?php echo e(\App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->count()); ?>

                    </p>
                    <p class="mb-1"><i class="fas fa-circle text-primary"></i> Nauczyciele: <?php echo e($stats['total_teachers']); ?></p>
                    <p class="mb-0"><i class="fas fa-circle text-info"></i> Uczniowie: <?php echo e($stats['total_students']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Wykres rozkładu ocen
const ctx = document.getElementById('gradeChart').getContext('2d');
const gradeChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            <?php $__currentLoopData = $gradeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            '<?php echo e($stat->grade); ?>',
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        datasets: [{
            data: [
                <?php $__currentLoopData = $gradeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($stat->count); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            backgroundColor: [
                '#dc3545', // 1
                '#dc3545', // 2
                '#ffc107', // 3
                '#0d6efd', // 4
                '#198754', // 5
                '#198754'  // 6
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Ocena ' + context.label + ': ' + context.parsed + ' (' +
                               Math.round(context.parsed / <?php echo e($stats['total_grades']); ?> * 100) + '%)';
                    }
                }
            }
        }
    }
});

// Funkcja odświeżania statystyk
function refreshStats() {
    location.reload();
}

// Auto-refresh co 5 minut
setInterval(refreshStats, 300000);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Gradienty tła */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Ikony kołowe */
.icon-circle {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-circle-sm {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Karty */
.card {
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: none;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.card.shadow-lg {
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.card.shadow-sm {
    box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important;
}

/* Tabela */
.table {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    border: none;
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e8ff 100%);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    color: #5a5c69;
}

.table td {
    border-color: #f0f2f5;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

/* Avatar */
.avatar {
    width: 2.5rem;
    height: 2.5rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    border-radius: 50%;
}

/* Przyciski */
.btn {
    border-radius: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-group .btn {
    border-radius: 8px;
}

/* Badge */
.badge {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.5em 0.8em;
}

/* Text utilities */
.text-gray-800 { color: #2d3436 !important; }
.text-white-50 { color: rgba(255,255,255,0.7) !important; }

/* Animacje */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 40px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }

/* Progress bars */
.progress {
    border-radius: 10px;
    height: 0.5rem;
}

.progress-bar {
    border-radius: 10px;
}

/* Responsywność */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }

    .icon-circle {
        width: 3rem;
        height: 3rem;
    }

    .h4 {
        font-size: 1.2rem;
    }
}

/* Hover efekty na kartach statystyk */
.bg-gradient-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6b4a9c 100%);
}

.bg-gradient-success:hover {
    background: linear-gradient(135deg, #0e8981 0%, #32d470 100%);
}

.bg-gradient-info:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #e085f4 100%);
}

.bg-gradient-warning:hover {
    background: linear-gradient(135deg, #e085f4 0%, #e84f65 100%);
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>