<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-house"></i>
        <span>Panel</span>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('teacher.dashboard') }}" class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-gauge"></i></span>
            <span class="sidebar-link__text">Dashboard</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('teacher.subjects.index') }}" class="sidebar-link {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-book-open"></i></span>
            <span class="sidebar-link__text">Moje przedmioty</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-star"></i>
        <span>Oceny</span>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('teacher.grades.index') }}" class="sidebar-link {{ request()->routeIs('teacher.grades.index') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-list"></i></span>
            <span class="sidebar-link__text">Lista ocen</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('teacher.grades.create') }}" class="sidebar-link {{ request()->routeIs('teacher.grades.create') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-plus"></i></span>
            <span class="sidebar-link__text">Dodaj ocenę</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('teacher.grades.history') }}" class="sidebar-link {{ request()->routeIs('teacher.grades.history') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-clock-rotate-left"></i></span>
            <span class="sidebar-link__text">Historia zmian</span>
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
        <a href="{{ route('teacher.attendance.index') }}" class="sidebar-link {{ request()->routeIs('teacher.attendance.index') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-user-check"></i></span>
            <span class="sidebar-link__text">Rejestruj obecność</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('teacher.attendance.reports') }}" class="sidebar-link {{ request()->routeIs('teacher.attendance.reports') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-chart-bar"></i></span>
            <span class="sidebar-link__text">Raporty frekwencji</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>
