@extends('layouts.app')

@section('title', 'Moje Oceny')

@section('header')
<h1 class="h2"><i class="fas fa-star"></i> Moje Oceny</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('student.subjects.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-book"></i> Wg przedmiotów
        </a>
        <a href="{{ route('student.grades.statistics') }}" class="btn btn-outline-success">
            <i class="fas fa-chart-bar"></i> Statystyki
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filtry
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Statystyki podsumowania -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Średnia ogólna
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['overall_average'] ? number_format($stats['overall_average'], 2) : '---' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Liczba ocen
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_grades'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Najwyższa ocena
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['highest_grade'] ?? '---' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pozycja w klasie
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['class_rank'] ?? '---' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trophy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista ocen -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list"></i> Wszystkie Oceny
                        </h6>
                    </div>
                    <div class="col-auto">
                        <form method="GET" class="d-flex">
                            <select name="subject_id" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie przedmioty</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                            <select name="type" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie typy</option>
                                <option value="sprawdzian" {{ request('type') == 'sprawdzian' ? 'selected' : '' }}>Sprawdzian</option>
                                <option value="kartkówka" {{ request('type') == 'kartkówka' ? 'selected' : '' }}>Kartkówka</option>
                                <option value="odpowiedź" {{ request('type') == 'odpowiedź' ? 'selected' : '' }}>Odpowiedź</option>
                                <option value="projekt" {{ request('type') == 'projekt' ? 'selected' : '' }}>Projekt</option>
                                <option value="praca_domowa" {{ request('type') == 'praca_domowa' ? 'selected' : '' }}>Praca domowa</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Data</th>
                                <th>Opis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-2">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                        <span class="fw-bold">{{ $grade->subject->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-success text-white rounded-circle">
                                                {{ strtoupper(substr($grade->teacher->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <span>{{ $grade->teacher->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge fs-6 bg-{{ $grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger')) }}">
                                        {{ $grade->grade }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $grade->weight }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($grade->type) }}</span>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold">{{ $grade->created_at->format('d.m.Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $grade->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($grade->description)
                                        <span class="text-muted" title="{{ $grade->description }}" data-bs-toggle="tooltip">
                                            {{ Str::limit($grade->description, 40) }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Brak opisu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Nie masz jeszcze żadnych ocen</h5>
                                    <p class="text-muted">Oceny będą pojawiać się tutaj po wystawieniu przez nauczycieli</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($grades->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $grades->links('vendor.pagination.custom') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Wykres średnich -->
@if($grades->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-area"></i> Wykres Średnich z Przedmiotów
                </h6>
            </div>
            <div class="card-body">
                <canvas id="subjectAveragesChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal filtrów -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtry Ocen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Przedmiot</label>
                            <select name="subject_id" class="form-select">
                                <option value="">Wszystkie przedmioty</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Typ oceny</label>
                            <select name="type" class="form-select">
                                <option value="">Wszystkie typy</option>
                                <option value="sprawdzian" {{ request('type') == 'sprawdzian' ? 'selected' : '' }}>Sprawdzian</option>
                                <option value="kartkówka" {{ request('type') == 'kartkówka' ? 'selected' : '' }}>Kartkówka</option>
                                <option value="odpowiedź" {{ request('type') == 'odpowiedź' ? 'selected' : '' }}>Odpowiedź ustna</option>
                                <option value="projekt" {{ request('type') == 'projekt' ? 'selected' : '' }}>Projekt</option>
                                <option value="praca_domowa" {{ request('type') == 'praca_domowa' ? 'selected' : '' }}>Praca domowa</option>
                                <option value="aktywność" {{ request('type') == 'aktywność' ? 'selected' : '' }}>Aktywność</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Data od</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data do</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Ocena od</label>
                            <select name="grade_from" class="form-select">
                                <option value="">Wybierz</option>
                                @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('grade_from') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ocena do</label>
                            <select name="grade_to" class="form-select">
                                <option value="">Wybierz</option>
                                @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('grade_to') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('student.grades.index') }}" class="btn btn-secondary">Wyczyść filtry</a>
                    <button type="submit" class="btn btn-primary">Zastosuj filtry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($grades->count() > 0)
// Wykres średnich z przedmiotów
const ctx = document.getElementById('subjectAveragesChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($subjectAverages->pluck('name')->toArray()) !!},
        datasets: [{
            label: 'Średnia z przedmiotu',
            data: {!! json_encode($subjectAverages->pluck('average')->toArray()) !!},
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796',
                '#5a5c69'
            ],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                min: 1,
                max: 6,
                ticks: {
                    stepSize: 0.5
                }
            }
        }
    }
});
@endif

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush

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

/* Custom Pagination Styles */
.pagination-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-custom .page-item {
    display: inline-block;
}

.pagination-custom .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    min-width: 36px;
    padding: 0;
    font-size: 1rem;
    line-height: 1;
    color: #4e73df;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-custom .page-link:hover {
    background-color: #f8f9fa;
    border-color: #4e73df;
    color: #2e59d9;
}

.pagination-custom .page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    color: #fff;
    font-weight: 600;
}

.pagination-custom .page-item.disabled .page-link {
    color: #d1d5db;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
@endpush