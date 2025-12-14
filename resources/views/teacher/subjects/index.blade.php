@extends('layouts.app')

@section('title', 'Moje Przedmioty')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
<li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Panel Nauczyciela</a></li>
<li class="breadcrumb-item active">Moje Przedmioty</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-book-open"></i> Moje Przedmioty</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót do Dashboard
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap"></i> Lista przedmiotów do prowadzenia
                </h5>
            </div>
            <div class="card-body text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-book fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Moje przedmioty</h4>
                    <p class="text-muted mb-4">
                        Tutaj znajdziesz listę wszystkich przedmiotów, które prowadzisz w szkole.
                    </p>
                    <div class="alert alert-info">
                        <strong>Informacje o przedmiotach (w przygotowaniu):</strong><br>
                        • Lista przypisanych klas i uczniów<br>
                        • Statystyki ocen z każdego przedmiotu<br>
                        • Plan lekcji i harmonogram<br>
                        • Materiały dydaktyczne
                    </div>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Powrót do Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient {
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b35 100%) !important;
}

.empty-state {
    max-width: 500px;
    margin: 0 auto;
}

.card {
    transition: all 0.3s ease;
    border: none;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border: none;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.shadow-lg {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}
</style>
@endpush