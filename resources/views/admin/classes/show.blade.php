@extends('layouts.app')

@section('title', 'Szczegóły Klasy')

@section('header')
<h1 class="h2"><i class="fas fa-door-open"></i> Szczegóły Klasy: {{ $class->name }}</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edytuj
        </a>
        <a href="{{ route('admin.classes.manage', $class) }}" class="btn btn-primary">
            <i class="fas fa-cogs"></i> Zarządzaj przedmiotami
        </a>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Statystyki klasy -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Liczba uczniów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['students_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Liczba przedmiotów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['subjects_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Rok szkolny
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $class->year }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Wychowawca
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $class->tutor ? $class->tutor->name : 'Brak' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Lista uczniów -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users"></i> Lista uczniów ({{ $stats['students_count'] }})
                </h6>
            </div>
            <div class="card-body">
                @if($class->students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Lp.</th>
                                <th>Uczeń</th>
                                <th>Email</th>
                                <th>Średnia</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-primary text-white rounded-circle">
                                                {{ strtoupper(substr($student->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div class="fw-bold">{{ $student->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $student->email }}</small>
                                </td>
                                <td>
                                    @php
                                        $avg = $student->getWeightedAverage();
                                    @endphp
                                    @if($avg > 0)
                                        <span class="badge bg-{{ $avg >= 4.5 ? 'success' : ($avg >= 3.5 ? 'primary' : ($avg >= 2.5 ? 'warning' : 'danger')) }}">
                                            {{ number_format($avg, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $student) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-users fa-3x mb-3"></i><br>
                    Brak uczniów w tej klasie
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Przedmioty i wychowawca -->
    <div class="col-lg-4 mb-4">
        <!-- Informacje o klasie -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-info-circle"></i> Informacje o klasie
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Nazwa klasy</small>
                    <strong>{{ $class->name }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Rok szkolny</small>
                    <strong>{{ $class->year }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Wychowawca</small>
                    @if($class->tutor)
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-2">
                                <div class="avatar-title bg-light text-dark rounded-circle">
                                    {{ strtoupper(substr($class->tutor->name, 0, 2)) }}
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $class->tutor->name }}</div>
                                <small class="text-muted">{{ $class->tutor->email }}</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted">Brak wychowawcy</span>
                    @endif
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Data utworzenia</small>
                    <strong>{{ $class->created_at->format('d.m.Y H:i') }}</strong>
                </div>
            </div>
        </div>

        <!-- Lista przedmiotów -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book"></i> Przedmioty ({{ $stats['subjects_count'] }})
                </h6>
            </div>
            <div class="card-body">
                @if($class->subjects->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($class->subjects as $subject)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-book-open text-primary me-2"></i>
                                <strong>{{ $subject->name }}</strong>
                                <br>
                                <small class="text-muted ms-4">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    {{ $subject->teachers->pluck('name')->join(', ') ?: 'Brak nauczyciela' }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-book fa-2x mb-2"></i><br>
                    <small>Brak przypisanych przedmiotów</small>
                </div>
                @endif

                <div class="mt-3 text-center">
                    <a href="{{ route('admin.classes.manage', $class) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-cogs"></i> Zarządzaj przedmiotami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
}
.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.card {
    transition: all 0.3s;
}

.list-group-item {
    border-left: none;
    border-right: none;
}
</style>
@endpush
