<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="sidebar-header text-center mb-4">
            <div class="user-avatar">
                <i class="fas fa-user-shield fa-3x text-primary"></i>
            </div>
            <h6 class="text-white mt-2">{{ auth()->user()->name }}</h6>
            <small class="text-muted">Administrator</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users me-2"></i>
                    Zarządzanie Użytkownikami
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"
                   href="{{ route('admin.classes.index') }}">
                    <i class="fas fa-door-open me-2"></i>
                    Zarządzanie Klasami
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}"
                   href="{{ route('admin.subjects.index') }}">
                    <i class="fas fa-book me-2"></i>
                    Zarządzanie Przedmiotami
                </a>
            </li>

            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>RAPORTY I STATYSTYKI</span>
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
                   href="{{ route('admin.reports') }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Raporty
                </a>
            </li>


            <li class="nav-item">
                <hr class="sidebar-divider">
                <h6 class="sidebar-heading text-muted">
                    <span>SYSTEM</span>
                </h6>
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
    background: linear-gradient(135deg, #2c3e50, #34495e);
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
    background-color: rgba(52, 152, 219, 0.2);
    color: #3498db !important;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background-color: #3498db;
    color: white !important;
    box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
}

.sidebar-header {
    background: rgba(52, 152, 219, 0.1);
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
    background: linear-gradient(45deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
</style>