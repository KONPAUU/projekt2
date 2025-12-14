@extends('layouts.app')

@section('title', 'Statystyki ocen')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-chart-bar"></i> Statystyki ocen</h2>
        </div>
    </div>

    <!-- Podstawowe statystyki -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Średnia ogólna</h6>
                    <h2 class="text-primary">{{ number_format($overallAverage, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Liczba ocen</h6>
                    <h2>{{ $totalGrades }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Najlepsza ocena</h6>
                    <h2 class="text-success">{{ $bestGrade ?? '-' }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Najgorsza ocena</h6>
                    <h2 class="text-danger">{{ $worstGrade ?? '-' }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Rozkład ocen -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rozkład ocen</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ocena</th>
                                <th>Liczba</th>
                                <th>Procent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gradeDistribution as $dist)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $dist->grade }}</span></td>
                                    <td>{{ $dist->count }}</td>
                                    <td>{{ round(($dist->count / $totalGrades) * 100, 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statystyki według typu -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie według typu oceny</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Typ</th>
                                <th>Średnia</th>
                                <th>Liczba</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($typeStats as $stat)
                                <tr>
                                    <td>{{ $stat->type }}</td>
                                    <td>{{ number_format($stat->average, 2) }}</td>
                                    <td>{{ $stat->count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statystyki miesięczne -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie miesięczne</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Miesiąc</th>
                                <th>Średnia</th>
                                <th>Liczba ocen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $stat)
                                <tr>
                                    <td>{{ $stat->month }}/{{ $stat->year }}</td>
                                    <td>{{ number_format($stat->average, 2) }}</td>
                                    <td>{{ $stat->count }}</td>
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
