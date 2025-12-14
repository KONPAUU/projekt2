<?php $__env->startSection('title', 'Szczegóły Użytkownika'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('admin.users.index')); ?>">Użytkownicy</a></li>
<li class="breadcrumb-item active"><?php echo e($user->name); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<h1 class="h2"><i class="fas fa-user"></i> Szczegóły Użytkownika</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Karta użytkownika -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white text-center py-4">
                <div class="avatar-lg mx-auto mb-3">
                    <div class="avatar-title bg-white text-primary rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                    </div>
                </div>
                <h4 class="mb-1"><?php echo e($user->name); ?></h4>
                <span class="badge bg-<?php echo e($user->role->name == 'admin' ? 'danger' : ($user->role->name == 'teacher' ? 'info' : 'success')); ?> px-3 py-2">
                    <i class="fas fa-<?php echo e($user->role->name == 'admin' ? 'user-shield' : ($user->role->name == 'teacher' ? 'chalkboard-teacher' : 'user-graduate')); ?>"></i>
                    <?php echo e($user->role->display_name); ?>

                </span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope text-muted me-2"></i> Email</span>
                        <span class="text-primary"><?php echo e($user->email); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-id-card text-muted me-2"></i> PESEL</span>
                        <span><?php echo e($user->pesel ?? '—'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-phone text-muted me-2"></i> Telefon</span>
                        <span><?php echo e($user->phone ?? '—'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-door-open text-muted me-2"></i> Klasa</span>
                        <span>
                            <?php if($user->schoolClass): ?>
                                <span class="badge bg-secondary"><?php echo e($user->schoolClass->name); ?></span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar text-muted me-2"></i> Zarejestrowany</span>
                        <span><?php echo e($user->created_at->format('d.m.Y H:i')); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-check-circle text-muted me-2"></i> Status</span>
                        <span class="badge bg-<?php echo e($user->email_verified_at ? 'success' : 'warning'); ?>">
                            <?php echo e($user->email_verified_at ? 'Aktywny' : 'Nieaktywny'); ?>

                        </span>
                    </li>
                </ul>

                <?php if($user->address): ?>
                <div class="mt-3">
                    <h6 class="text-muted"><i class="fas fa-map-marker-alt"></i> Adres</h6>
                    <p class="mb-0"><?php echo e($user->address); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statystyki i szczegóły -->
    <div class="col-xl-8 col-lg-7">
        <?php if($user->isStudent()): ?>
        <!-- Statystyki ucznia -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Liczba ocen</div>
                                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['total_grades']); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Średnia</div>
                                <div class="h5 mb-0 font-weight-bold"><?php echo e(number_format($stats['average'], 2)); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Przedmioty</div>
                                <div class="h5 mb-0 font-weight-bold"><?php echo e($stats['subjects_count']); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista ocen -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-star"></i> Ostatnie oceny
                </h6>
            </div>
            <div class="card-body">
                <?php if($user->grades->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Przedmiot</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Nauczyciel</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $user->grades->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($grade->subject->name ?? '—'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($grade->grade >= 4 ? 'success' : ($grade->grade >= 3 ? 'warning' : 'danger')); ?> fs-6">
                                        <?php echo e($grade->grade); ?>

                                    </span>
                                </td>
                                <td><?php echo e($grade->weight); ?></td>
                                <td><small><?php echo e(ucfirst(str_replace('_', ' ', $grade->type))); ?></small></td>
                                <td><?php echo e($grade->teacher->name ?? '—'); ?></td>
                                <td><small><?php echo e($grade->created_at->format('d.m.Y')); ?></small></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-star fa-3x mb-3 opacity-25"></i>
                    <p>Brak ocen do wyświetlenia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <!-- Informacje dla nauczyciela/admina -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle"></i> Informacje
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center py-5">
                    <i class="fas fa-<?php echo e($user->role->name == 'admin' ? 'user-shield' : 'chalkboard-teacher'); ?> fa-4x text-muted mb-4"></i>
                    <h4><?php echo e($user->role->display_name); ?></h4>
                    <p class="text-muted">
                        <?php if($user->isTeacher()): ?>
                            Ten użytkownik jest nauczycielem w systemie.
                        <?php else: ?>
                            Ten użytkownik jest administratorem systemu.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Przyciski akcji -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Powrót do listy
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edytuj użytkownika
                        </a>
                        <?php if($user->id !== auth()->id()): ?>
                        <button type="button" class="btn btn-danger" onclick="deleteUser(<?php echo e($user->id); ?>)">
                            <i class="fas fa-trash"></i> Usuń użytkownika
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularz usuwania -->
<form id="delete-form-<?php echo e($user->id); ?>" action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function deleteUser(userId) {
    if (confirm('Czy na pewno chcesz usunąć tego użytkownika? Ta operacja jest nieodwracalna.')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-primary {
    background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
}

.avatar-lg {
    display: flex;
    justify-content: center;
}

.avatar-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }

.card {
    border-radius: 10px;
    overflow: hidden;
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.opacity-25 {
    opacity: 0.25;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/admin/users/show.blade.php ENDPATH**/ ?>