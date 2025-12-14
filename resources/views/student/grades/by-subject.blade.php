@extends('layouts.app')

@section('title', 'Oceny z przedmiotu: ' . $subject->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-book"></i> Oceny z przedmiotu: {{ $subject->name }}</h2>
        </div>
    </div>

    <!-- Statystyki -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Średnia</h5>
                    <h2 class="text-primary">{{ number_format($average, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Liczba ocen</h5>
                    <h2>{{ $stats['total_grades'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Najlepsza</h5>
                    <h2 class="text-success">{{ $stats['best_grade'] ?? '-' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Najgorsza</h5>
                    <h2 class="text-danger">{{ $stats['worst_grade'] ?? '-' }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista ocen -->
    <div class="card">
        <div class="card-header">
            <h5>Wszystkie oceny</h5>
        </div>
        <div class="card-body">
            @if($grades->isEmpty())
                <p class="text-muted">Brak ocen z tego przedmiotu.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ocena</th>
                                <th>Waga</th>
                                <th>Typ</th>
                                <th>Opis</th>
                                <th>Nauczyciel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $grade->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $grade->grade }}</span>
                                    </td>
                                    <td>{{ $grade->weight }}</td>
                                    <td>{{ $grade->type }}</td>
                                    <td>{{ $grade->description ?? '-' }}</td>
                                    <td>{{ $grade->teacher->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
