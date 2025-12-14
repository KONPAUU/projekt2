@extends('layouts.app')

@section('title', 'Ostatnie zmiany ocen')

@section('header')
<h1 class="h2"><i class="fas fa-history"></i> Ostatnie zmiany ocen</h1>
@endsection

@section('content')

    <!-- Statystyki -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Zmiany dzisiaj</h6>
                    <h2 class="text-primary">{{ $stats['today_changes'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Zmiany w tym tygodniu</h6>
                    <h2 class="text-info">{{ $stats['week_changes'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Wszystkie zmiany</h6>
                    <h2>{{ $stats['total_changes'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista zmian -->
    <div class="card">
        <div class="card-header">
            <h5>Historia zmian</h5>
        </div>
        <div class="card-body">
            @if($recentHistories->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak zmian ocen w historii.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data zmiany</th>
                                <th>Uczeń</th>
                                <th>Przedmiot</th>
                                <th>Stara ocena</th>
                                <th>Nowa ocena</th>
                                <th>Kto zmienił</th>
                                <th>Powód</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentHistories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('teacher.grades.index', ['student_id' => $history->grade->student->id]) }}">
                                            {{ $history->grade->student->name }}
                                        </a>
                                    </td>
                                    <td>{{ $history->grade->subject->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $history->old_grade }}</span>
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($history->new_grade > $history->old_grade) bg-success
                                            @elseif($history->new_grade < $history->old_grade) bg-danger
                                            @else bg-primary
                                            @endif">
                                            {{ $history->new_grade }}
                                            @if($history->new_grade > $history->old_grade)
                                                <i class="fas fa-arrow-up"></i>
                                            @elseif($history->new_grade < $history->old_grade)
                                                <i class="fas fa-arrow-down"></i>
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $history->changedBy->name }}</td>
                                    <td>{{ $history->reason ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $recentHistories->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
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
