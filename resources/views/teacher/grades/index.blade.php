@extends('layouts.app')

@section('title', 'Zarządzanie Ocenami')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Zarządzanie Ocenami</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-star"></i> Zarządzanie Ocenami</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('teacher.grades.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj ocenę
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filtry
        </button>
        <a href="{{ route('teacher.grades.history') }}" class="btn btn-outline-info">
            <i class="fas fa-history"></i> Historia zmian
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list"></i> Lista Ocen
                        </h6>
                    </div>
                    <div class="col-auto">
                        <form method="GET" class="d-flex">
                            <select name="class_id" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie klasy</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                                @endforeach
                            </select>
                            <select name="subject_id" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="">Wszystkie przedmioty</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
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
                                <th>Uczeń</th>
                                <th>Klasa</th>
                                <th>Przedmiot</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Data</th>
                                <th>Opis</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <div class="avatar-title bg-primary text-white rounded-circle">
                                                {{ strtoupper(substr($grade->student->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $grade->student->name }}</div>
                                            <small class="text-muted">{{ $grade->student->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $grade->student->schoolClass->name ?? 'Brak klasy' }}</span>
                                </td>
                                <td>{{ $grade->subject->name }}</td>
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
                                    <small class="text-muted">
                                        {{ $grade->created_at->format('d.m.Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($grade->description)
                                        <span class="text-muted" title="{{ $grade->description }}">
                                            {{ Str::limit($grade->description, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">Brak opisu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('teacher.grades.edit', $grade) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('teacher.grades.destroy', $grade) }}" class="d-inline"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć tę ocenę?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nie ma jeszcze żadnych ocen</p>
                                    <a href="{{ route('teacher.grades.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Dodaj pierwszą ocenę
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($grades->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $grades->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal filtrów -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zaawansowane filtry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Klasa</label>
                            <select name="class_id" class="form-select">
                                <option value="">Wszystkie klasy</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
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
                            <label class="form-label">Typ oceny</label>
                            <select name="type" class="form-select">
                                <option value="">Wszystkie typy</option>
                                <option value="sprawdzian" {{ request('type') == 'sprawdzian' ? 'selected' : '' }}>Sprawdzian</option>
                                <option value="kartkówka" {{ request('type') == 'kartkówka' ? 'selected' : '' }}>Kartkówka</option>
                                <option value="odpowiedź" {{ request('type') == 'odpowiedź' ? 'selected' : '' }}>Odpowiedź</option>
                                <option value="projekt" {{ request('type') == 'projekt' ? 'selected' : '' }}>Projekt</option>
                                <option value="praca_domowa" {{ request('type') == 'praca_domowa' ? 'selected' : '' }}>Praca domowa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ocena</label>
                            <select name="grade" class="form-select">
                                <option value="">Wszystkie oceny</option>
                                <option value="1" {{ request('grade') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request('grade') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request('grade') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request('grade') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request('grade') == '5' ? 'selected' : '' }}>5</option>
                                <option value="6" {{ request('grade') == '6' ? 'selected' : '' }}>6</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('teacher.grades.index') }}" class="btn btn-secondary">Wyczyść filtry</a>
                    <button type="submit" class="btn btn-primary">Zastosuj filtry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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
</style>
@endpush