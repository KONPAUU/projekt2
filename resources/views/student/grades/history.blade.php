@extends('layouts.app')

@section('title', 'Historia zmian ocen')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-history"></i> Historia zmian ocen</h2>
        </div>
    </div>

    <!-- Wszystkie zmiany -->
    <div class="card">
        <div class="card-header">
            <h5>Wszystkie zmiany ocen</h5>
        </div>
        <div class="card-body">
            @if($allHistories->isEmpty())
                <p class="text-muted">Brak zmian ocen w historii.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data zmiany</th>
                                <th>Przedmiot</th>
                                <th>Stara ocena</th>
                                <th>Nowa ocena</th>
                                <th>Zmienił</th>
                                <th>Powód</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allHistories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->grade->subject->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $history->old_grade }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $history->new_grade }}</span>
                                    </td>
                                    <td>{{ $history->changedBy->name }}</td>
                                    <td>{{ $history->reason ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $allHistories->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
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
