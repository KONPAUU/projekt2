@extends('layouts.app')

@section('title', 'Zarządzanie Przedmiotami')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Przedmioty</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-book"></i> Zarządzanie Przedmiotami</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj Przedmiot
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statsModal">
            <i class="fas fa-chart-bar"></i> Statystyki
        </button>
        <button type="button" class="btn btn-outline-success" onclick="exportSubjects()">
            <i class="fas fa-download"></i> Eksport
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Statystyki przedmiotów -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Łączna liczba przedmiotów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_subjects'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
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
                            Przedmioty z nauczycielami
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['subjects_with_teachers'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
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
                            Przedmioty z ocenami
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['subjects_with_grades'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
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
                            Średnia wszystkich ocen
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['average_grade'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista przedmiotów -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list"></i> Lista Przedmiotów
                </h6>
            </div>
            <div class="card-body">
                <!-- Pasek wyszukiwania -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Wyszukaj przedmioty..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchSubjects()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="assignTeachersModal()">
                                <i class="fas fa-user-plus"></i> Przypisz nauczycieli
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Przedmiot</th>
                                <th>Opis</th>
                                <th>Nauczyciele</th>
                                <th>Klasy</th>
                                <th>Liczba ocen</th>
                                <th>Średnia</th>
                                <th width="150">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="subject-icon me-3">
                                            <i class="fas fa-{{ $subject->icon ?? 'book' }} fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-primary">{{ $subject->name }}</div>
                                            <small class="text-muted">Kod: {{ $subject->code ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($subject->description)
                                        <span class="text-muted" title="{{ $subject->description }}" data-bs-toggle="tooltip">
                                            {{ Str::limit($subject->description, 50) }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Brak opisu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="teachers-list">
                                        @if($subject->teachers->count() > 0)
                                            @foreach($subject->teachers->take(2) as $teacher)
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="avatar avatar-sm me-2">
                                                    <div class="avatar-title bg-success text-white rounded-circle">
                                                        {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                                    </div>
                                                </div>
                                                <small>{{ $teacher->name }}</small>
                                            </div>
                                            @endforeach
                                            @if($subject->teachers->count() > 2)
                                                <small class="text-muted">+{{ $subject->teachers->count() - 2 }} więcej</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Brak nauczycieli</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($subject->classes->count() > 0)
                                        @foreach($subject->classes->take(3) as $class)
                                        <span class="badge bg-light text-dark me-1 mb-1">{{ $class->name }}</span>
                                        @endforeach
                                        @if($subject->classes->count() > 3)
                                        <span class="badge bg-secondary">+{{ $subject->classes->count() - 3 }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Brak klas</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info fs-6">{{ $subject->grades_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if(($subject->grades_count ?? 0) > 0)
                                        <span class="badge bg-{{ $subject->average_grade >= 4.5 ? 'success' : ($subject->average_grade >= 3.5 ? 'warning' : 'danger') }}">
                                            {{ number_format($subject->average_grade, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.subjects.show', $subject) }}" class="btn btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-outline-primary" title="Edytuj">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" onclick="deleteSubject({{ $subject->id }})" title="Usuń">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Brak przedmiotów</h5>
                                    <p class="text-muted">Dodaj pierwszy przedmiot aby rozpocząć</p>
                                    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Dodaj Przedmiot
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginacja -->
                @if($subjects->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $subjects->appends(request()->query())->links() }}
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
                <h5 class="modal-title">Szczegółowe statystyki przedmiotów</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="subjectsChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="averagesChart"></canvas>
                    </div>
                </div>
                <hr>
                <h6>Szczegółowe statystyki</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Przedmiot</th>
                                <th>Nauczyciele</th>
                                <th>Klasy</th>
                                <th>Oceny</th>
                                <th>Średnia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->teachers->count() }}</td>
                                <td>{{ $subject->classes->count() }}</td>
                                <td>{{ $subject->grades_count ?? 0 }}</td>
                                <td>
                                    @if(($subject->grades_count ?? 0) > 0)
                                        {{ number_format($subject->average_grade, 2) }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchSubjects();
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});

function searchSubjects() {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = `{{ route('admin.subjects.index') }}?search=${encodeURIComponent(searchTerm)}`;
}

function deleteSubject(subjectId) {
    if (confirm('Czy na pewno chcesz usunąć ten przedmiot? Ta operacja usunie również wszystkie powiązane oceny.')) {
        fetch(`/admin/subjects/${subjectId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Wystąpił błąd podczas usuwania przedmiotu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas usuwania przedmiotu.');
        });
    }
}

function assignTeachersModal() {
    alert('Funkcja przypisywania nauczycieli będzie dostępna wkrótce.');
}

function exportSubjects() {
    window.location.href = '{{ route("admin.export.pdf") }}?type=subjects';
}

// Charts for statistics modal
document.getElementById('statsModal').addEventListener('shown.bs.modal', function() {
    // Subjects by teachers chart
    const subjectsCtx = document.getElementById('subjectsChart').getContext('2d');
    new Chart(subjectsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Z nauczycielami', 'Bez nauczycieli'],
            datasets: [{
                data: [{{ $stats['subjects_with_teachers'] }}, {{ $stats['total_subjects'] - $stats['subjects_with_teachers'] }}],
                backgroundColor: ['#1cc88a', '#e74a3b'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Przedmioty z nauczycielami'
                }
            }
        }
    });

    // Average grades chart
    const averagesCtx = document.getElementById('averagesChart').getContext('2d');
    new Chart(averagesCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($subjects->take(10) as $subject)
                '{{ $subject->name }}',
                @endforeach
            ],
            datasets: [{
                label: 'Średnia ocen',
                data: [
                    @foreach($subjects->take(10) as $subject)
                    {{ $subject->average_grade ?? 0 }},
                    @endforeach
                ],
                backgroundColor: '#4e73df',
                borderColor: '#2e59d9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 6
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Średnie ocen z przedmiotów'
                }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(87deg, #4e73df 0, #224abe 100%) !important;
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

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.subject-icon {
    width: 50px;
    text-align: center;
}

.teachers-list {
    max-width: 200px;
}
</style>
@endpush