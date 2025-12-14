@extends('layouts.app')

@section('title', 'Raporty Systemu')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Raporty</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-chart-bar"></i> Raporty Systemu</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-primary" onclick="refreshReports()">
            <i class="fas fa-sync-alt"></i> Odśwież
        </button>
        <button type="button" class="btn btn-outline-success" onclick="exportAllReports()">
            <i class="fas fa-download"></i> Eksportuj Wszystko
        </button>
        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#customReportModal">
            <i class="fas fa-cogs"></i> Raport Niestandardowy
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Szybkie statystyki -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Łączne klasy
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($classReports) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
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
                            Aktywne przedmioty
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($subjectReports) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
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
                            Średnia systemowa
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format(collect($classReports)->avg('average_grade') ?? 0, 2) }}
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
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Łączni uczniowie
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ collect($classReports)->sum('students_count') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Raporty klas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-door-open"></i> Raport Wydajności Klas
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Klasa</th>
                                <th>Wychowawca</th>
                                <th>Liczba Uczniów</th>
                                <th>Średnia Klasy</th>
                                <th>Liczba Przedmiotów</th>
                                <th>Status</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classReports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="class-icon me-2">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $report['class']->name }}</div>
                                            <small class="text-muted">{{ $report['class']->year }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($report['class']->tutor)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <div class="avatar-title bg-success text-white rounded-circle">
                                                    {{ strtoupper(substr($report['class']->tutor->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <span>{{ $report['class']->tutor->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Brak wychowawcy</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $report['students_count'] > 0 ? 'success' : 'secondary' }} fs-6">
                                        {{ $report['students_count'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($report['average_grade'])
                                        <span class="badge bg-{{ $report['average_grade'] >= 4.5 ? 'success' : ($report['average_grade'] >= 3.5 ? 'warning' : 'danger') }}">
                                            {{ number_format($report['average_grade'], 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $report['class']->subjects->count() }}</span>
                                </td>
                                <td>
                                    @if($report['students_count'] > 0 && $report['average_grade'])
                                        @if($report['average_grade'] >= 4.5)
                                            <span class="badge bg-success">Bardzo Dobra</span>
                                        @elseif($report['average_grade'] >= 3.5)
                                            <span class="badge bg-primary">Dobra</span>
                                        @elseif($report['average_grade'] >= 2.5)
                                            <span class="badge bg-warning">Średnia</span>
                                        @else
                                            <span class="badge bg-danger">Słaba</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Brak Danych</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-info" onclick="viewClassDetails({{ $report['class']->id }})" title="Szczegóły">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" onclick="exportClassReport({{ $report['class']->id }})" title="Eksportuj">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i><br>
                                    Brak danych do raportu
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Raporty przedmiotów -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-book"></i> Raport Przedmiotów
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Przedmiot</th>
                                <th>Liczba Ocen</th>
                                <th>Średnia Ocen</th>
                                <th>Liczba Klas</th>
                                <th>Nauczyciele</th>
                                <th>Popularność</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjectReports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-2">
                                            <i class="fas fa-{{ $report['subject']->icon ?? 'book' }} text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $report['subject']->name }}</div>
                                            @if($report['subject']->code)
                                                <small class="text-muted">{{ $report['subject']->code }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info fs-6">{{ $report['grades_count'] }}</span>
                                </td>
                                <td>
                                    @if($report['average_grade'])
                                        <span class="badge bg-{{ $report['average_grade'] >= 4.5 ? 'success' : ($report['average_grade'] >= 3.5 ? 'warning' : 'danger') }}">
                                            {{ number_format($report['average_grade'], 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $report['classes_count'] }}</span>
                                </td>
                                <td>
                                    <div class="teachers-avatars">
                                        @foreach($report['subject']->teachers->take(3) as $teacher)
                                            <div class="avatar avatar-sm me-1" title="{{ $teacher->name }}">
                                                <div class="avatar-title bg-warning text-dark rounded-circle">
                                                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($report['subject']->teachers->count() > 3)
                                            <small class="text-muted">+{{ $report['subject']->teachers->count() - 3 }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $totalClasses = count($classReports);
                                        $popularityPercent = $totalClasses > 0 ? ($report['classes_count'] / $totalClasses) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $popularityPercent >= 75 ? 'success' : ($popularityPercent >= 50 ? 'warning' : 'danger') }}"
                                             style="width: {{ $popularityPercent }}%">
                                            {{ number_format($popularityPercent, 0) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-info" onclick="viewSubjectDetails({{ $report['subject']->id }})" title="Szczegóły">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" onclick="exportSubjectReport({{ $report['subject']->id }})" title="Eksportuj">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i><br>
                                    Brak przedmiotów do raportu
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wykresy porównawcze -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i> Rozkład Uczniów w Klasach
                </h6>
            </div>
            <div class="card-body">
                <canvas id="classStudentsChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar"></i> Średnie Ocen w Klasach
                </h6>
            </div>
            <div class="card-body">
                <canvas id="classAveragesChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Modal niestandardowego raportu -->
<div class="modal fade" id="customReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Utwórz Niestandardowy Raport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="customReportForm">
                    <div class="mb-3">
                        <label class="form-label">Typ Raportu</label>
                        <select class="form-select" name="report_type">
                            <option value="class_performance">Wydajność Klas</option>
                            <option value="subject_analysis">Analiza Przedmiotów</option>
                            <option value="teacher_workload">Obciążenie Nauczycieli</option>
                            <option value="grade_trends">Trendy Ocen</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Okres</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="date" class="form-control" name="date_from">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" name="date_to">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Format Eksportu</label>
                        <select class="form-select" name="export_format">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-primary" onclick="generateCustomReport()">Generuj Raport</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Wykres uczniów w klasach
const studentsCtx = document.getElementById('classStudentsChart').getContext('2d');
new Chart(studentsCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($classReports as $report)
            '{{ $report["class"]->name }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($classReports as $report)
                {{ $report['students_count'] }},
                @endforeach
            ],
            backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                '#858796', '#5a5c69', '#2e59d9', '#17a2b8', '#ffc107'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Wykres średnich w klasach
const averagesCtx = document.getElementById('classAveragesChart').getContext('2d');
new Chart(averagesCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($classReports as $report)
            '{{ $report["class"]->name }}',
            @endforeach
        ],
        datasets: [{
            label: 'Średnia klasy',
            data: [
                @foreach($classReports as $report)
                {{ $report['average_grade'] ?? 0 }},
                @endforeach
            ],
            backgroundColor: '#1cc88a',
            borderColor: '#17a085',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 6
            }
        }
    }
});

function refreshReports() {
    location.reload();
}

function exportAllReports() {
    window.location.href = '{{ route("admin.export.pdf") }}?type=all_reports';
}

function viewClassDetails(classId) {
    window.location.href = `/admin/classes/${classId}`;
}

function exportClassReport(classId) {
    window.location.href = `{{ route("admin.export.pdf") }}?type=class&id=${classId}`;
}

function viewSubjectDetails(subjectId) {
    window.location.href = `/admin/subjects/${subjectId}`;
}

function exportSubjectReport(subjectId) {
    window.location.href = `{{ route("admin.export.pdf") }}?type=subject&id=${subjectId}`;
}

function generateCustomReport() {
    const form = document.getElementById('customReportForm');
    const formData = new FormData(form);
    alert('Funkcja niestandardowych raportów będzie dostępna wkrótce.');
}
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(87deg, #1cc88a 0, #13855c 100%) !important;
}

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

.teachers-avatars {
    display: flex;
    align-items: center;
}

.card {
    transition: all 0.3s;
    border-radius: 15px;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.12) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #5a5c69;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
@endpush