@extends('layouts.app')

@section('title', 'Szczegóły Użytkownika')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Użytkownicy</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-user"></i> Szczegóły Użytkownika</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Karta użytkownika -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white text-center py-4">
                <div class="avatar-lg mx-auto mb-3">
                    <div class="avatar-title bg-white text-primary rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <span class="badge bg-{{ $user->role->name == 'admin' ? 'danger' : ($user->role->name == 'teacher' ? 'info' : 'success') }} px-3 py-2">
                    <i class="fas fa-{{ $user->role->name == 'admin' ? 'user-shield' : ($user->role->name == 'teacher' ? 'chalkboard-teacher' : 'user-graduate') }}"></i>
                    {{ $user->role->display_name }}
                </span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope text-muted me-2"></i> Email</span>
                        <span class="text-primary">{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-id-card text-muted me-2"></i> PESEL</span>
                        <span>{{ $user->pesel ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-phone text-muted me-2"></i> Telefon</span>
                        <span>{{ $user->phone ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-door-open text-muted me-2"></i> Klasa</span>
                        <span>
                            @if($user->schoolClass)
                                <span class="badge bg-secondary">{{ $user->schoolClass->name }}</span>
                            @else
                                —
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar text-muted me-2"></i> Zarejestrowany</span>
                        <span>{{ $user->created_at->format('d.m.Y H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-check-circle text-muted me-2"></i> Status</span>
                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                            {{ $user->email_verified_at ? 'Aktywny' : 'Nieaktywny' }}
                        </span>
                    </li>
                </ul>

                @if($user->address)
                <div class="mt-3">
                    <h6 class="text-muted"><i class="fas fa-map-marker-alt"></i> Adres</h6>
                    <p class="mb-0">{{ $user->address }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statystyki i szczegóły -->
    <div class="col-xl-8 col-lg-7">
        @if($user->isStudent())
        <!-- Statystyki ucznia -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Liczba ocen</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['total_grades'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Średnia</div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['average'], 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Przedmioty</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['subjects_count'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista ocen -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-star"></i> Ostatnie oceny
                </h6>
            </div>
            <div class="card-body">
                @if($user->grades->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Przedmiot</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Nauczyciel</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->grades->take(10) as $grade)
                            <tr>
                                <td>{{ $grade->subject->name ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $grade->grade >= 4 ? 'success' : ($grade->grade >= 3 ? 'warning' : 'danger') }} fs-6">
                                        {{ $grade->grade }}
                                    </span>
                                </td>
                                <td>{{ $grade->weight }}</td>
                                <td><small>{{ ucfirst(str_replace('_', ' ', $grade->type)) }}</small></td>
                                <td>{{ $grade->teacher->name ?? '—' }}</td>
                                <td><small>{{ $grade->created_at->format('d.m.Y') }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-star fa-3x mb-3 opacity-25"></i>
                    <p>Brak ocen do wyświetlenia</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <!-- Informacje dla nauczyciela/admina -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle"></i> Informacje
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center py-5">
                    <i class="fas fa-{{ $user->role->name == 'admin' ? 'user-shield' : 'chalkboard-teacher' }} fa-4x text-muted mb-4"></i>
                    <h4>{{ $user->role->display_name }}</h4>
                    <p class="text-muted">
                        @if($user->isTeacher())
                            Ten użytkownik jest nauczycielem w systemie.
                        @else
                            Ten użytkownik jest administratorem systemu.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Przyciski akcji -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Powrót do listy
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edytuj użytkownika
                        </a>
                        @if($user->id !== auth()->id())
                        <button type="button" class="btn btn-danger" onclick="deleteUser({{ $user->id }})">
                            <i class="fas fa-trash"></i> Usuń użytkownika
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formularz usuwania -->
<form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteUser(userId) {
    if (confirm('Czy na pewno chcesz usunąć tego użytkownika? Ta operacja jest nieodwracalna.')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
}

.avatar-lg {
    display: flex;
    justify-content: center;
}

.avatar-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }

.card {
    border-radius: 10px;
    overflow: hidden;
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.opacity-25 {
    opacity: 0.25;
}
</style>
@endpush
