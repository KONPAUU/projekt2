<div class="admin-sidebar shadow-lg" id="admin-sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-shield-alt"></i>
            <div class="logo-text">
                <h5 class="mb-0">Admin Panel</h5>
                <small class="text-muted">System Management</small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <div class="nav-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <span>Dashboard</span>
                <div class="nav-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>

            <!-- Users Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    <span>Zarządzanie użytkownikami</span>
                </div>

                <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.users.index') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <span>Lista użytkowników</span>
                </a>

                <a href="<?php echo e(route('admin.users.create')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.users.create') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <span>Dodaj użytkownika</span>
                </a>
            </div>

            <!-- School Structure Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-school"></i>
                    <span>Struktura szkoły</span>
                </div>

                <a href="<?php echo e(route('admin.classes.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.classes.index') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <span>Lista klas</span>
                </a>

                <a href="<?php echo e(route('admin.classes.create')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.classes.create') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <span>Dodaj klasę</span>
                </a>

                <a href="<?php echo e(route('admin.subjects.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.subjects.index') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <span>Lista przedmiotów</span>
                </a>

                <a href="<?php echo e(route('admin.subjects.create')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.subjects.create') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span>Dodaj przedmiot</span>
                </a>
            </div>

            <!-- Reports Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    <span>Raporty</span>
                </div>

                <a href="<?php echo e(route('admin.reports')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>">
                    <div class="nav-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Raporty</span>
                </a>

            </div>

        </nav>
    </div>
</div>

<style>
.admin-sidebar {
    width: 280px;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow-y: auto;
    transition: all 0.3s ease;
}

.admin-sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    z-index: 0;
}

.sidebar-header {
    position: relative;
    z-index: 1;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sidebar-logo i {
    font-size: 2rem;
    color: #ffd700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.logo-text h5 {
    color: white;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    margin: 0;
}

.logo-text small {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    font-weight: 500;
}

.sidebar-nav {
    position: relative;
    z-index: 1;
    padding: 1rem 0;
}

.nav-section {
    margin-bottom: 1.5rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem 0.5rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 0.5rem;
}

.section-title i {
    font-size: 0.875rem;
    opacity: 0.8;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    border-left: 3px solid transparent;
    font-weight: 500;
}

.nav-item:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    border-left-color: rgba(255, 255, 255, 0.3);
    transform: translateX(5px);
}

.nav-item.active {
    color: white;
    background: rgba(255, 255, 255, 0.15);
    border-left-color: #ffd700;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
}

.nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #ffd700, #ffed4e);
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    margin-right: 0.875rem;
    font-size: 1rem;
}

.nav-item span {
    flex: 1;
    font-size: 0.9rem;
}

.nav-arrow {
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 0.75rem;
}

.nav-item:hover .nav-arrow {
    opacity: 1;
}

.nav-item.active .nav-arrow {
    opacity: 1;
    color: #ffd700;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .admin-sidebar {
        width: 100%;
        position: fixed;
        top: 0;
        left: -100%;
        z-index: 1050;
        transition: left 0.3s ease;
    }

    .admin-sidebar.show {
        left: 0;
    }
}

/* Animation for nav items */
@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.nav-item {
    animation: slideInFromLeft 0.3s ease forwards;
}

.nav-section:nth-child(1) .nav-item { animation-delay: 0.1s; }
.nav-section:nth-child(2) .nav-item { animation-delay: 0.2s; }
.nav-section:nth-child(3) .nav-item { animation-delay: 0.3s; }
.nav-section:nth-child(4) .nav-item { animation-delay: 0.4s; }

/* Scrollbar styling */
.admin-sidebar::-webkit-scrollbar {
    width: 4px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/layouts/partials/admin-sidebar.blade.php ENDPATH**/ ?>