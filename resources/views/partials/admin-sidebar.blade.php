<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-compass"></i>
        <span>Nawigacja</span>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-gauge-high"></i></span>
            <span class="sidebar-link__text">Panel główny</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-chart-line"></i></span>
            <span class="sidebar-link__text">Raporty</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.export.pdf') }}" class="sidebar-link {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-file-export"></i></span>
            <span class="sidebar-link__text">Eksport PDF</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-users"></i>
        <span>Użytkownicy</span>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-user-group"></i></span>
            <span class="sidebar-link__text">Lista użytkowników</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.users.create') }}" class="sidebar-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-user-plus"></i></span>
            <span class="sidebar-link__text">Dodaj użytkownika</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>

<div class="sidebar-section">
    <div class="sidebar-section__title">
        <i class="fas fa-school"></i>
        <span>Struktura szkoły</span>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('admin.classes.index') }}" class="sidebar-link {{ request()->routeIs('admin.classes.index') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-layer-group"></i></span>
            <span class="sidebar-link__text">Klasy</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.classes.create') }}" class="sidebar-link {{ request()->routeIs('admin.classes.create') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-plus-circle"></i></span>
            <span class="sidebar-link__text">Nowa klasa</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="sidebar-link {{ request()->routeIs('admin.subjects.index') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-book"></i></span>
            <span class="sidebar-link__text">Przedmioty</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
        <a href="{{ route('admin.subjects.create') }}" class="sidebar-link {{ request()->routeIs('admin.subjects.create') ? 'active' : '' }}">
            <span class="sidebar-link__icon"><i class="fas fa-book-open"></i></span>
            <span class="sidebar-link__text">Dodaj przedmiot</span>
            <i class="fas fa-chevron-right sidebar-link__chevron"></i>
        </a>
    </div>
</div>
