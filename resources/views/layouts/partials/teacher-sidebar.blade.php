<div class="teacher-sidebar shadow-lg" id="teacher-sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-chalkboard-teacher"></i>
            <div class="logo-text">
                <h5 class="mb-0">Panel Nauczyciela</h5>
                <small class="text-muted">Zarządzanie ocenami</small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a href="{{ route('teacher.dashboard') }}" class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="fas fa-home"></i>
                </div>
                <span>Dashboard</span>
                <div class="nav-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>

            <!-- Grades Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-star"></i>
                    <span>Zarządzanie ocenami</span>
                </div>

                <a href="{{ route('teacher.grades.index') }}" class="nav-item {{ request()->routeIs('teacher.grades.index') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <span>Lista ocen</span>
                </a>

                <a href="{{ route('teacher.grades.create') }}" class="nav-item {{ request()->routeIs('teacher.grades.create') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span>Dodaj ocenę</span>
                </a>

                <a href="{{ route('teacher.grades.quick') }}" class="nav-item {{ request()->routeIs('teacher.grades.quick') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span>Szybkie ocenianie</span>
                </a>
            </div>

            <!-- Students Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    <span>Moje klasy</span>
                </div>

                <a href="{{ route('teacher.students.index') }}" class="nav-item {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <span>Lista uczniów</span>
                </a>

                <a href="{{ route('teacher.subjects.index') }}" class="nav-item {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span>Moje przedmioty</span>
                </a>
            </div>

            <!-- Attendance Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-calendar-check"></i>
                    <span>Frekwencja</span>
                </div>

                <a href="{{ route('teacher.attendance.index') }}" class="nav-item {{ request()->routeIs('teacher.attendance.index') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <span>Zarządzaj frekwencją</span>
                </a>

                <a href="{{ route('teacher.attendance.reports') }}" class="nav-item {{ request()->routeIs('teacher.attendance.reports') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span>Raporty frekwencji</span>
                </a>
            </div>
        </nav>
    </div>
</div>

<style>
.teacher-sidebar {
    width: 280px;
    min-height: 100vh;
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%);
    color: white;
    position: relative;
    overflow-y: auto;
    transition: all 0.3s ease;
}

.teacher-sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    z-index: 0;
}

.teacher-sidebar .sidebar-header {
    position: relative;
    z-index: 1;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.teacher-sidebar .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.teacher-sidebar .sidebar-logo i {
    font-size: 2rem;
    color: #ffd700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.teacher-sidebar .logo-text h5 {
    color: white;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    margin: 0;
}

.teacher-sidebar .logo-text small {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    font-weight: 500;
}

.teacher-sidebar .sidebar-nav {
    position: relative;
    z-index: 1;
    padding: 1rem 0;
}

.teacher-sidebar .nav-section {
    margin-bottom: 1.5rem;
}

.teacher-sidebar .section-title {
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

.teacher-sidebar .section-title i {
    font-size: 0.875rem;
    opacity: 0.8;
}

.teacher-sidebar .nav-item {
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

.teacher-sidebar .nav-item:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    border-left-color: rgba(255, 255, 255, 0.3);
    transform: translateX(5px);
}

.teacher-sidebar .nav-item.active {
    color: white;
    background: rgba(255, 255, 255, 0.15);
    border-left-color: #ffd700;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
}

.teacher-sidebar .nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #ffd700, #ffed4e);
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.teacher-sidebar .nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    margin-right: 0.875rem;
    font-size: 1rem;
}

.teacher-sidebar .nav-item span {
    flex: 1;
    font-size: 0.9rem;
}

.teacher-sidebar .nav-arrow {
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 0.75rem;
}

.teacher-sidebar .nav-item:hover .nav-arrow {
    opacity: 1;
}

.teacher-sidebar .nav-item.active .nav-arrow {
    opacity: 1;
    color: #ffd700;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .teacher-sidebar {
        width: 100%;
        position: fixed;
        top: 0;
        left: -100%;
        z-index: 1050;
        transition: left 0.3s ease;
    }

    .teacher-sidebar.show {
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

.teacher-sidebar .nav-item {
    animation: slideInFromLeft 0.3s ease forwards;
}

.teacher-sidebar .nav-section:nth-child(1) .nav-item { animation-delay: 0.1s; }
.teacher-sidebar .nav-section:nth-child(2) .nav-item { animation-delay: 0.2s; }
.teacher-sidebar .nav-section:nth-child(3) .nav-item { animation-delay: 0.3s; }

/* Scrollbar styling */
.teacher-sidebar::-webkit-scrollbar {
    width: 4px;
}

.teacher-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.teacher-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.teacher-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>