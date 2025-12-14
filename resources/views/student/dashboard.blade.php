@extends('layouts.app')

@section('title', 'Panel Ucznia')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
<li class="breadcrumb-item active">Panel Ucznia</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-user-graduate"></i> Panel Ucznia</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-primary" onclick="refreshDashboard()">
            <i class="fas fa-sync-alt"></i> Odśwież
        </button>
        <a href="{{ route('student.grades.index') }}" class="btn btn-outline-success">
            <i class="fas fa-star"></i> Moje oceny
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white shadow-lg">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="student-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="mb-1">Witaj, {{ auth()->user()->name }}!</h2>
                        <p class="mb-0 opacity-90">
                            <i class="fas fa-door-open"></i>
                            Klasa: <strong>{{ auth()->user()->schoolClass->name ?? 'Brak przypisanej klasy' }}</strong>
                            <span class="mx-3">|</span>
                            <i class="fas fa-star"></i>
                            Średnia: <strong>{{ $stats['overall_average'] ? number_format($stats['overall_average'], 2) : '---' }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content - Subjects and Grades -->
<div class="row">
    <!-- My Subjects -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0">
                    <i class="fas fa-book-open"></i> Moje przedmioty
                </h5>
            </div>
            <div class="card-body">
                @forelse($subjectAverages as $subject)
                <div class="subject-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="subject-info">
                            <h6 class="subject-name">{{ $subject->name }}</h6>
                            <small class="text-muted">{{ $subject->grades_count }} ocen</small>
                        </div>
                        <div class="subject-grade">
                            @if($subject->average)
                                <span class="grade-badge grade-{{ $subject->average >= 4.5 ? 'excellent' : ($subject->average >= 3.5 ? 'good' : 'poor') }}">
                                    {{ number_format($subject->average, 2) }}
                                </span>
                            @else
                                <span class="text-muted">Brak ocen</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if(!$loop->last)<hr class="my-3">@endif
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-book fa-3x mb-3 text-light"></i>
                    <p>Nie masz jeszcze przypisanych przedmiotów</p>
                </div>
                @endforelse

                @if($subjectAverages->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('student.grades.by-subject') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Zobacz szczegóły przedmiotów
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Grades -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-star"></i> Ostatnie oceny
                </h5>
            </div>
            <div class="card-body">
                @forelse($recentGrades->take(8) as $grade)
                <div class="grade-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="grade-info">
                            <h6 class="grade-subject">{{ $grade->subject->name }}</h6>
                            <small class="text-muted">{{ $grade->teacher->name }} • {{ $grade->created_at->format('d.m.Y') }}</small>
                        </div>
                        <div class="grade-value">
                            <span class="grade-badge grade-{{ $grade->grade >= 5 ? 'excellent' : ($grade->grade >= 4 ? 'good' : ($grade->grade >= 3 ? 'average' : 'poor')) }}">
                                {{ $grade->grade }}
                            </span>
                        </div>
                    </div>
                </div>
                @if(!$loop->last)<hr class="my-3">@endif
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-star fa-3x mb-3 text-light"></i>
                    <p>Nie masz jeszcze żadnych ocen</p>
                </div>
                @endforelse

                @if($recentGrades->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('student.grades.index') }}" class="btn btn-success">
                        <i class="fas fa-list"></i> Zobacz wszystkie oceny
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function refreshDashboard() {
    location.reload();
}

// Simple animations for grade items
$(document).ready(function() {
    $('.subject-item, .grade-item').each(function(index) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(20px)'
        }).delay(index * 100).animate({
            'opacity': '1',
            'transform': 'translateY(0)'
        }, 500);
    });
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #48c774 0%, #2ecc71 100%) !important;
}

.student-avatar {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.subject-item, .grade-item {
    padding: 0.75rem 0;
    transition: all 0.3s ease;
}

.subject-item:hover, .grade-item:hover {
    background: rgba(0, 0, 0, 0.02);
    border-radius: 8px;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.subject-name, .grade-subject {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.grade-badge {
    display: inline-block;
    padding: 0.5rem 0.75rem;
    border-radius: 50px;
    font-weight: bold;
    font-size: 0.9rem;
    text-align: center;
    min-width: 50px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.grade-excellent {
    background: linear-gradient(135deg, #48c774, #2ecc71);
    color: white;
}

.grade-good {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.grade-average {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.grade-poor {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
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

/* Animation classes */
.fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .student-avatar {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .col-lg-6 {
        margin-bottom: 1rem !important;
    }
}
</style>
@endpush