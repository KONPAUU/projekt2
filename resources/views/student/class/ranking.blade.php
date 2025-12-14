@extends('layouts.app')

@section('title', 'Ranking klasy')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-trophy"></i> Ranking klasy {{ $class->name }}</h2>
        </div>
    </div>

    @if($myRank)
        <div class="alert alert-info mb-4">
            <i class="fas fa-medal"></i> Twoja pozycja w rankingu: <strong>{{ $myRank }}</strong> miejsce
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5><i class="fas fa-chart-line"></i> Ranking według średniej ocen</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pozycja</th>
                            <th>Uczeń</th>
                            <th>Średnia</th>
                            <th>Liczba ocen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking as $index => $item)
                            <tr class="{{ $item['student']->id == auth()->id() ? 'table-primary' : '' }}">
                                <td>
                                    @if($index < 3)
                                        <span class="fs-4">
                                            @if($index == 0) 🥇
                                            @elseif($index == 1) 🥈
                                            @elseif($index == 2) 🥉
                                            @endif
                                        </span>
                                    @endif
                                    <strong>{{ $index + 1 }}</strong>
                                </td>
                                <td>
                                    @if($item['student']->id == auth()->id())
                                        <strong>{{ $item['student']->name }}</strong>
                                        <span class="badge bg-primary">Ty</span>
                                    @else
                                        {{ $item['student']->name }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $item['average'] >= 4.5 ? 'success' : ($item['average'] >= 3 ? 'warning' : 'danger') }} fs-6">
                                        {{ number_format($item['average'], 2) }}
                                    </span>
                                </td>
                                <td>{{ $item['grades_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($ranking->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak danych do wyświetlenia rankingu.
                </div>
            @endif
        </div>
    </div>

    <div class="alert alert-secondary mt-4">
        <i class="fas fa-info-circle"></i> Ranking uwzględnia średnią ważoną ze wszystkich przedmiotów.
    </div>
</div>
@endsection
