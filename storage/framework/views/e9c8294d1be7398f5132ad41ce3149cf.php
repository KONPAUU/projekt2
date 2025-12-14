<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-home"></i>
        <span>Panel</span>
    </div>
    <div class="sidebar-nav">
        <a href="<?php echo e(route('student.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.dashboard') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-gauge"></i></span>
            <span class="sidebar-link__text">Dashboard</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-star"></i>
        <span>Moje oceny</span>
    </div>
    <div class="sidebar-nav">
        <a href="<?php echo e(route('student.grades.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.grades.index') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-list"></i></span>
            <span class="sidebar-link__text">Wszystkie oceny</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.subjects.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.subjects.*') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-book"></i></span>
            <span class="sidebar-link__text">Według przedmiotów</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.grades.average')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.grades.average') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-scale-balanced"></i></span>
            <span class="sidebar-link__text">Średnie</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.grades.history')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.grades.history') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-clock-rotate-left"></i></span>
            <span class="sidebar-link__text">Historia ocen</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.grades.statistics')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.grades.statistics') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-chart-pie"></i></span>
            <span class="sidebar-link__text">Statystyki</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-calendar-check"></i>
        <span>Frekwencja</span>
    </div>
    <div class="sidebar-nav">
        <a href="<?php echo e(route('student.attendance.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.attendance.index') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-user-check"></i></span>
            <span class="sidebar-link__text">Podsumowanie</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.attendance.calendar')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.attendance.calendar') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-calendar"></i></span>
            <span class="sidebar-link__text">Kalendarz</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-users"></i>
        <span>Klasa</span>
    </div>
    <div class="sidebar-nav">
        <a href="<?php echo e(route('student.class.info')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.class.info') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-circle-info"></i></span>
            <span class="sidebar-link__text">Informacje</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="<?php echo e(route('student.class.ranking')); ?>" class="sidebar-link <?php echo e(request()->routeIs('student.class.ranking') ? 'active' : ''); ?>">
            <span class="sidebar-link__icon"><i class="fas fa-ranking-star"></i></span>
            <span class="sidebar-link__text">Ranking</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>
<?php /**PATH C:\Users\konra\Desktop\dziennik-lekcyjny — kopia (2)\resources\views/layouts/partials/student-sidebar.blade.php ENDPATH**/ ?>