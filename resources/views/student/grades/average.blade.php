@extends('layouts.app')

@section('title', 'Średnie ocen')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-calculator"></i> Obliczanie średniej ważonej</h2>
        </div>
    </div>

    <!-- Średnia ogólna -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>Średnia ogólna</h3>
                    <h1 class="display-3">{{ number_format($overallAverage, 2) }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Średnie z przedmiotów -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Średnie z poszczególnych przedmiotów</h5>
                </div>
                <div class="card-body">
                    @if($subjectAverages->isEmpty())
                        <p class="text-muted">Brak ocen.</p>
                    @else
                        @foreach($subjectAverages as $subjectId => $data)
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $data['subject']->name }}</h6>
                                    <span class="badge bg-primary fs-5">{{ number_format($data['average'], 2) }}</span>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        <strong>Liczba ocen:</strong> {{ $data['grades_count'] }}<br>
                                        <strong>Suma ważona:</strong> {{ $data['total_weighted_sum'] }}<br>
                                        <strong>Suma wag:</strong> {{ $data['total_weight'] }}
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Ocena</th>
                                                    <th>Waga</th>
                                                    <th>Wartość ważona</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['grade_details'] as $detail)
                                                    <tr>
                                                        <td>{{ $detail['grade']->grade }}</td>
                                                        <td>{{ $detail['grade']->weight }}</td>
                                                        <td>{{ $detail['weighted_value'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
