<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Dziennik Lekcyjny')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}?v={{ time() }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="{{ auth()->check() ? 'has-dashboard' : '' }}">
@php use Illuminate\Support\Str; @endphp
@auth
    @php
        $user = auth()->user();
        $roleName = $user->role->name ?? 'guest';
        $roleIcon = [
            'admin' => 'fas fa-shield-halved',
            'teacher' => 'fas fa-chalkboard-teacher',
            'student' => 'fas fa-user-graduate',
        ][$roleName] ?? 'fas fa-circle';
    @endphp
    <div class="dashboard-shell">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <aside class="dashboard-sidebar" data-role="{{ $roleName }}" id="dashboardSidebar">
            <div class="sidebar-inner">
                <div class="sidebar-brand">
                    <span class="sidebar-brand__icon"><i class="{{ $roleIcon }}"></i></span>
                    <div class="sidebar-brand__meta">
                        <span>{{ $user->role->display_name ?? 'U�ytkownik' }}</span>
                        <strong>{{ Str::limit($user->name, 26) }}</strong>
                    </div>
                </div>

                <div class="sidebar-menu">
                    @if($user->isAdmin())
                        @include('layouts.partials.admin-sidebar')
                    @elseif($user->isTeacher())
                        @include('layouts.partials.teacher-sidebar')
                    @elseif($user->isStudent())
                        @include('layouts.partials.student-sidebar')
                    @endif
                </div>

                <div class="sidebar-footer">
                    <span>{{ $user->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Wyloguj
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="dashboard-main">
            <header class="dashboard-topbar">
                <div class="topbar-left">
                    <button class="icon-button" id="sidebarToggle" aria-label="Otw�rz menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="topbar-brand">
                        <i class="fas fa-graduation-cap"></i>
                        {{ config('app.name') }}
                        <span>{{ $user->role->display_name ?? '' }}</span>
                    </a>
                </div>
                <div class="topbar-actions">
                    <div class="d-flex align-items-center gap-2">
                        @if($user->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-users"></i></a>
                            <a href="{{ route('admin.classes.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-school"></i></a>
                            <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-chart-line"></i></a>
                        @elseif($user->isTeacher())
                            <a href="{{ route('teacher.grades.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-star"></i></a>
                            <a href="{{ route('teacher.attendance.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-calendar-check"></i></a>
                        @elseif($user->isStudent())
                            <a href="{{ route('student.grades.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-star"></i></a>
                            <a href="{{ route('student.attendance.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-calendar"></i></a>
                            <a href="{{ route('student.subjects.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-book"></i></a>
                        @endif
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" type="button">
                            <div class="avatar-circle bg-soft-primary text-primary fw-semibold">
                                {{ Str::upper(Str::substr($user->name, 0, 2)) }}
                            </div>
                            <span>{{ Str::limit($user->name, 18) }}</span>
                            <i class="fas fa-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('help') }}"><i class="fas fa-circle-question me-2"></i> Pomoc</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-arrow-right-from-bracket me-2"></i> Wyloguj</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="dashboard-content">
                <div class="container-fluid">
                    @hasSection('header')
                    <div class="page-heading mb-4">
                        @yield('header')
                    </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="py-4 text-center text-muted">
                <small>&copy; {{ date('Y') }} {{ config('app.name') }} � Wersja 1.0 � <a href="{{ route('help') }}">Pomoc</a></small>
            </footer>
        </div>
    </div>
@else
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('home') }}"><i class="fas fa-graduation-cap me-2"></i>{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="guestNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Logowanie</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Rejestracja</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-5">
        @yield('content')
    </main>
@endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('dashboardSidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.jQuery) {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            }

            const closeSidebar = () => {
                sidebar?.classList.remove('is-open');
                overlay?.classList.remove('is-active');
            };

            toggle?.addEventListener('click', () => {
                sidebar?.classList.toggle('is-open');
                overlay?.classList.toggle('is-active');
            });

            overlay?.addEventListener('click', closeSidebar);

            document.querySelectorAll('[data-search-target]').forEach((input) => {
                const targetId = input.getAttribute('data-search-target');
                const table = document.getElementById(targetId);
                if (!table) return;

                input.addEventListener('input', () => {
                    const query = input.value.toLowerCase();
                    table.querySelectorAll('[data-filter-text]').forEach((row) => {
                        const text = (row.getAttribute('data-filter-text') || '').toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
                });
            });

            document.querySelectorAll('[data-confirm]').forEach((element) => {
                element.addEventListener('click', (event) => {
                    const message = element.getAttribute('data-confirm') || 'Czy na pewno?';
                    if (!confirm(message)) {
                        event.preventDefault();
                    }
                });
            });

            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    const instance = bootstrap.Alert.getOrCreateInstance(alert);
                    instance.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
