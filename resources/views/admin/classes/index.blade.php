@extends('layouts.app')

@section('title', 'Zarządzanie Klasami')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Klasy</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-door-open"></i> Zarządzanie Klasami</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj klasę
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Statystyki klas -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Łączna liczba klas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_classes'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
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
                            Łączna liczba uczniów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_students'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            Średnia liczba uczniów
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['average_students'], 1) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
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
                            Klasy z wychowawcami
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['classes_with_tutors'] }}</div>
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
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list"></i> Lista klas
                </h6>
            </div>
            <div class="card-body">
                <!-- Pasek wyszukiwania -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Wyszukaj klasy..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchClasses()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="assignSubjectsModal()">
                                <i class="fas fa-book"></i> Przypisz przedmioty
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nazwa klasy</th>
                                <th>Wychowawca</th>
                                <th>Liczba uczniów</th>
                                <th>Przedmioty</th>
                                <th>Średnia klasy</th>
                                <th>Data utworzenia</th>
                                <th width="180">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="class-icon me-2">
                                            <i class="fas fa-door-open text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $class->name }}</div>
                                            @if($class->description)
                                            <small class="text-muted">{{ Str::limit($class->description, 30) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <span class="badge bg-{{ $class->students_count > 0 ? 'success' : 'secondary' }} fs-6">
                                        {{ $class->students_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="subjects-list">
                                        @if($class->subjects->count() > 0)
                                            @foreach($class->subjects->take(3) as $subject)
                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $subject->name }}</span>
                                            @endforeach
                                            @if($class->subjects->count() > 3)
                                            <span class="badge bg-secondary">+{{ $class->subjects->count() - 3 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Brak przedmiotów</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($class->students_count > 0)
                                        <span class="badge bg-{{ $class->average >= 4.5 ? 'success' : ($class->average >= 3.5 ? 'primary' : ($class->average >= 2.5 ? 'warning' : 'danger')) }}">
                                            {{ number_format($class->average, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $class->created_at->format('d.m.Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.classes.manage', $class) }}" class="btn btn-outline-primary" title="Zarządzaj">
                                            <i class="fas fa-cogs"></i>
                                        </a>
                                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-outline-warning" title="Edytuj">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" onclick="deleteClass({{ $class->id }})" title="Usuń">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-door-open fa-3x mb-3"></i><br>
                                    Brak klas do wyświetlenia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginacja -->
                @if($classes->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $classes->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchClasses();
        }
    });
});

function searchClasses() {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = `{{ route('admin.classes.index') }}?search=${encodeURIComponent(searchTerm)}`;
}

function deleteClass(classId) {
    if (confirm('Czy na pewno chcesz usunąć tę klasę? Ta operacja usunie również wszystkich uczniów z klasy.')) {
        fetch(`/admin/classes/${classId}`, {
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
                alert('Wystąpił błąd podczas usuwania klasy.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas usuwania klasy.');
        });
    }
}

function assignSubjectsModal() {
    // This would open a modal for bulk subject assignment
    alert('Funkcja przypisywania przedmiotów będzie dostępna wkrótce.');
}


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

.avatar {
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

.subjects-list {
    max-width: 200px;
}

.class-icon {
    font-size: 1.2rem;
}
</style>
@endpush