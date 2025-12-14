@extends('layouts.app')

@section('title', 'Moja Frekwencja')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Frekwencja</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-calendar-check"></i> Moja Frekwencja</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('student.attendance.calendar') }}" class="btn btn-outline-primary">
            <i class="fas fa-calendar"></i> Kalendarz
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statsModal">
            <i class="fas fa-chart-pie"></i> Statystyki
        </button>
        <button type="button" class="btn btn-outline-success" onclick="exportAttendance()">
            <i class="fas fa-download"></i> Eksport
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Statystyki frekwencji -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Frekwencja ogólna
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['attendance_rate'], 1) }}%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Obecności
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['present_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
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
                            Nieobecności
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['absent_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times fa-2x text-gray-300"></i>
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
                            Spóźnienia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['late_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wykres frekwencji -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line"></i> Frekwencja w czasie
                </h6>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i> Rozkład obecności
                </h6>
            </div>
            <div class="card-body">
                <canvas id="attendancePieChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Lista frekwencji -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list"></i> Historia Frekwencji
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
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Wszystkie statusy</option>
                                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Obecny</option>
                                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Nieobecny</option>
                                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Spóźniony</option>
                                <option value="excused" {{ request('status') == 'excused' ? 'selected' : '' }}>Usprawiedliwiony</option>
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
                                <th>Data</th>
                                <th>Godzina</th>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Status</th>
                                <th>Uwagi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold">{{ $attendance->date->format('d.m.Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $attendance->date->locale('pl')->dayName }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $attendance->lesson_hour ?? 'Lekcja' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-2">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                        <span class="fw-bold">{{ $attendance->subject->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-success text-white rounded-circle">
                                                {{ strtoupper(substr($attendance->teacher->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <span>{{ $attendance->teacher->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'present' => ['class' => 'success', 'icon' => 'check', 'text' => 'Obecny'],
                                            'absent' => ['class' => 'danger', 'icon' => 'times', 'text' => 'Nieobecny'],
                                            'late' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Spóźniony'],
                                            'excused' => ['class' => 'info', 'icon' => 'user-check', 'text' => 'Usprawiedliwiony']
                                        ];
                                        $config = $statusConfig[$attendance->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Nieznany'];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">
                                        <i class="fas fa-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($attendance->notes)
                                        <span class="text-muted" title="{{ $attendance->notes }}" data-bs-toggle="tooltip">
                                            {{ Str::limit($attendance->notes, 40) }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Brak uwag</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Brak zapisów frekwencji</h5>
                                    <p class="text-muted">Frekwencja będzie widoczna po rozpoczęciu zajęć</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($attendances->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $attendances->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal statystyk -->
<div class="modal fade" id="statsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Szczegółowe statystyki frekwencji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Frekwencja według przedmiotów</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Przedmiot</th>
                                        <th>Frekwencja</th>
                                        <th>Lekcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjectStats as $stat)
                                    <tr>
                                        <td>{{ $stat['subject'] }}</td>
                                        <td>
                                            <span class="badge bg-{{ $stat['rate'] >= 90 ? 'success' : ($stat['rate'] >= 75 ? 'warning' : 'danger') }}">
                                                {{ number_format($stat['rate'], 1) }}%
                                            </span>
                                        </td>
                                        <td>{{ $stat['total'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Miesięczne podsumowanie</h6>
                        <canvas id="monthlyChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Wykres frekwencji w czasie
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['dates'] ?? []) !!},
        datasets: [{
            label: 'Frekwencja dzienna (%)',
            data: {!! json_encode($chartData['rates'] ?? []) !!},
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Frekwencja: ' + context.parsed.y + '%';
                    }
                }
            }
        }
    }
});

// Wykres kołowy rozkładu obecności
const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
const attendancePieChart = new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['Obecności', 'Nieobecności', 'Spóźnienia', 'Usprawiedliwienia'],
        datasets: [{
            data: [
                {{ $stats['present_count'] }},
                {{ $stats['absent_count'] }},
                {{ $stats['late_count'] }},
                {{ $stats['excused_count'] ?? 0 }}
            ],
            backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e', '#36b9cc'],
            borderWidth: 2,
            borderColor: '#fff'
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

// Wykres miesięczny w modalu
document.getElementById('statsModal').addEventListener('shown.bs.modal', function() {
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyData['months'] ?? []) !!},
            datasets: [{
                label: 'Frekwencja miesięczna (%)',
                data: {!! json_encode($monthlyData['rates'] ?? []) !!},
                backgroundColor: '#4e73df',
                borderColor: '#2e59d9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
});

function exportAttendance() {
    alert('Funkcja eksportu będzie dostępna wkrótce.');
}

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

.subject-icon {
    font-size: 1.1rem;
}
</style>
@endpush