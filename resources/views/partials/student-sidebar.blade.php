<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="sidebar-header text-center mb-4">
            <div class="user-avatar">
                <i class="fas fa-user-graduate fa-3x text-success"></i>
            </div>
            <h6 class="text-white mt-2">{{ auth()->user()->name }}</h6>
            <small class="text-muted">Uczeń</small>
            @if(auth()->user()->schoolClass)
            <div class="class-badge mt-2">
                <span class="badge bg-primary">{{ auth()->user()->schoolClass->name }}</span>
            </div>
            @endif
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
                   href="{{ route('student.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>NAUKA</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.grades.*') ? 'active' : '' }}"
                   href="{{ route('student.grades.index') }}">
                    <i class="fas fa-star me-2"></i>
                    Moje Oceny
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.grades.by-subject') ? 'active' : '' }}"
                   href="{{ route('student.grades.by-subject') }}">
                    <i class="fas fa-book me-2"></i>
                    Oceny wg Przedmiotów
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.grades.statistics') ? 'active' : '' }}"
                   href="{{ route('student.grades.statistics') }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statystyki Ocen
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>FREKWENCJA</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.attendance.index') ? 'active' : '' }}"
                   href="{{ route('student.attendance.index') }}">
                    <i class="fas fa-calendar-check me-2"></i>
                    Moja Frekwencja
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.attendance.calendar') ? 'active' : '' }}"
                   href="{{ route('student.attendance.calendar') }}">
                    <i class="fas fa-calendar me-2"></i>
                    Kalendarz Frekwencji
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>KLASA</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.class.info') ? 'active' : '' }}"
                   href="{{ route('student.class.info') }}">
                    <i class="fas fa-users me-2"></i>
                    Informacje o Klasie
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.class.ranking') ? 'active' : '' }}"
                   href="{{ route('student.class.ranking') }}">
                    <i class="fas fa-trophy me-2"></i>
                    Ranking Klasy
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.subjects.index') ? 'active' : '' }}"
                   href="{{ route('student.subjects.index') }}">
                    <i class="fas fa-book-open me-2"></i>
                    Moje Przedmioty
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>KONTO</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.profile.*') ? 'active' : '' }}"
                   href="{{ route('student.profile.edit') }}">
                    <i class="fas fa-user-edit me-2"></i>
                    Edytuj Profil
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('student.profile.password') ? 'active' : '' }}"
                   href="{{ route('student.profile.password') }}">
                    <i class="fas fa-key me-2"></i>
                    Zmień Hasło
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
    background: linear-gradient(135deg, #1a5d1a, #2d8f2d);
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
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745 !important;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: #28a745;
    color: white !important;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
}

.sidebar-header {
    background: rgba(40, 167, 69, 0.1);
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
    background: linear-gradient(45deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.class-badge {
    margin-top: 0.5rem;
}
</style>