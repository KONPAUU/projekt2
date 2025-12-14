<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="sidebar-header text-center mb-4">
            <div class="user-avatar">
                <i class="fas fa-chalkboard-teacher fa-3x text-warning"></i>
            </div>
            <h6 class="text-white mt-2">{{ auth()->user()->name }}</h6>
            <small class="text-muted">Nauczyciel</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"
                   href="{{ route('teacher.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>OCENY</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.grades.index') ? 'active' : '' }}"
                   href="{{ route('teacher.grades.index') }}">
                    <i class="fas fa-star me-2"></i>
                    Wszystkie Oceny
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.grades.create') ? 'active' : '' }}"
                   href="{{ route('teacher.grades.create') }}">
                    <i class="fas fa-plus me-2"></i>
                    Dodaj Oceny
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.grades.quick') ? 'active' : '' }}"
                   href="{{ route('teacher.grades.quick') }}">
                    <i class="fas fa-bolt me-2"></i>
                    Szybkie Dodawanie
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.grades.history') ? 'active' : '' }}"
                   href="{{ route('teacher.grades.history') }}">
                    <i class="fas fa-history me-2"></i>
                    Historia Ocen
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>UCZNIOWIE</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}"
                   href="{{ route('teacher.students.index') }}">
                    <i class="fas fa-users me-2"></i>
                    Lista Uczniów
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>FREKWENCJA</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.attendance.index') ? 'active' : '' }}"
                   href="{{ route('teacher.attendance.index') }}">
                    <i class="fas fa-calendar-check me-2"></i>
                    Frekwencja
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.attendance.reports') ? 'active' : '' }}"
                   href="{{ route('teacher.attendance.reports') }}">
                    <i class="fas fa-chart-line me-2"></i>
                    Raporty Frekwencji
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>PRZEDMIOTY</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}"
                   href="{{ route('teacher.subjects.index') }}">
                    <i class="fas fa-book me-2"></i>
                    Moje Przedmioty
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>RAPORTY</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.reports.grades') ? 'active' : '' }}"
                   href="{{ route('teacher.reports.grades') }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Raporty Ocen
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('teacher.reports.class-performance') ? 'active' : '' }}"
                   href="{{ route('teacher.reports.class-performance') }}">
                    <i class="fas fa-chart-pie me-2"></i>
                    Wydajność Klas
                </a>
            </li>

            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Wyloguj
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>

<style>
.sidebar {
    background: linear-gradient(135deg, #fd7e14, #e55a4e);
    min-height: 100vh;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar .nav-link {
    color: #ecf0f1 !important;
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    margin: 0.125rem 0.5rem;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 193, 7, 0.2);
    color: #ffc107 !important;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: #ffc107;
    color: #212529 !important;
    box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
    font-weight: 600;
}

.sidebar-header {
    background: rgba(255, 193, 7, 0.1);
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin: 0 0.5rem;
}

.sidebar-divider {
    margin: 1rem 0.5rem;
    border-color: rgba(236, 240, 241, 0.1);
}

.sidebar-heading {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1rem;
    padding: 0 1rem;
}

.user-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
</style>