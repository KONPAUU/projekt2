@extends('layouts.app')

@section('title', 'Przedmioty')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-book-open"></i> Moje przedmioty</h2>
        </div>
    </div>

    <div class="row">
        @forelse($subjects as $subject)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $subject->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Średnia</h6>
                            <h2 class="text-primary">{{ number_format($subject->average, 2) }}</h2>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Liczba ocen:</strong> {{ $subject->grades_count }}</p>
                            <p class="mb-0 text-muted">{{ $subject->description }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('student.grades.by-subject', $subject->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Zobacz oceny
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Brak przedmiotów z ocenami.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
