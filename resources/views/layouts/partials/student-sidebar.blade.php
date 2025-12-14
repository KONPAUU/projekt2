<div class="student-sidebar shadow-lg" id="student-sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-user-graduate"></i>
            <div class="logo-text">
                <h5 class="mb-0">Panel Ucznia</h5>
                <small class="text-muted">Moje oceny i przedmioty</small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a href="{{ route('student.dashboard') }}" class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
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
                    <span>Moje oceny</span>
                </div>

                <a href="{{ route('student.grades.index') }}" class="nav-item {{ request()->routeIs('student.grades.index') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <span>Wszystkie oceny</span>
                </a>

                <a href="{{ route('student.grades.by-subject') }}" class="nav-item {{ request()->routeIs('student.grades.by-subject') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <span>Oceny wg przedmiotów</span>
                </a>
            </div>

            <!-- Subjects Section -->
            <div class="nav-section">
                <div class="section-title">
                    <i class="fas fa-book-open"></i>
                    <span>Moje przedmioty</span>
                </div>

                <a href="{{ route('student.subjects.index') }}" class="nav-item {{ request()->routeIs('student.subjects.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span>Lista przedmiotów</span>
                </a>
            </div>
        </nav>
    </div>
</div>

<style>
.student-sidebar {
    width: 280px;
    min-height: 100vh;
    background: linear-gradient(135deg, #48c774 0%, #2ecc71 100%);
    color: white;
    position: relative;
    overflow-y: auto;
    transition: all 0.3s ease;
}

.student-sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    z-index: 0;
}

.student-sidebar .sidebar-header {
    position: relative;
    z-index: 1;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.student-sidebar .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.student-sidebar .sidebar-logo i {
    font-size: 2rem;
    color: #ffd700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.student-sidebar .logo-text h5 {
    color: white;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    margin: 0;
}

.student-sidebar .logo-text small {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    font-weight: 500;
}

.student-sidebar .sidebar-nav {
    position: relative;
    z-index: 1;
    padding: 1rem 0;
}

.student-sidebar .nav-section {
    margin-bottom: 1.5rem;
}

.student-sidebar .section-title {
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

.student-sidebar .section-title i {
    font-size: 0.875rem;
    opacity: 0.8;
}

.student-sidebar .nav-item {
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

.student-sidebar .nav-item:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    border-left-color: rgba(255, 255, 255, 0.3);
    transform: translateX(5px);
}

.student-sidebar .nav-item.active {
    color: white;
    background: rgba(255, 255, 255, 0.15);
    border-left-color: #ffd700;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
}

.student-sidebar .nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #ffd700, #ffed4e);
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.student-sidebar .nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    margin-right: 0.875rem;
    font-size: 1rem;
}

.student-sidebar .nav-item span {
    flex: 1;
    font-size: 0.9rem;
}

.student-sidebar .nav-arrow {
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 0.75rem;
}

.student-sidebar .nav-item:hover .nav-arrow {
    opacity: 1;
}

.student-sidebar .nav-item.active .nav-arrow {
    opacity: 1;
    color: #ffd700;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .student-sidebar {
        width: 100%;
        position: fixed;
        top: 0;
        left: -100%;
        z-index: 1050;
        transition: left 0.3s ease;
    }

    .student-sidebar.show {
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

.student-sidebar .nav-item {
    animation: slideInFromLeft 0.3s ease forwards;
}

.student-sidebar .nav-section:nth-child(1) .nav-item { animation-delay: 0.1s; }
.student-sidebar .nav-section:nth-child(2) .nav-item { animation-delay: 0.2s; }
.student-sidebar .nav-section:nth-child(3) .nav-item { animation-delay: 0.3s; }

/* Scrollbar styling */
.student-sidebar::-webkit-scrollbar {
    width: 4px;
}

.student-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.student-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.student-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>