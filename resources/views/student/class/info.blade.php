@extends('layouts.app')

@section('title', 'Informacje o klasie')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-users"></i> Informacje o klasie {{ $class->name }}</h2>
        </div>
    </div>

    <!-- Informacje o klasie -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-info-circle"></i> Dane klasy</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nazwa:</strong> {{ $class->name }}</p>
                    <p><strong>Rok szkolny:</strong> {{ $class->year }}</p>
                    <p><strong>Liczba uczniów:</strong> {{ $classmates->count() }}</p>
                    <p><strong>Wychowawca:</strong> {{ $tutor ? $tutor->name : 'Brak' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-book"></i> Przedmioty</h5>
                </div>
                <div class="card-body">
                    @forelse($subjects as $subject)
                        <div class="mb-2">
                            <strong>{{ $subject->name }}</strong>
                            @foreach($subject->classSubjectTeachers as $cst)
                                - {{ $cst->teacher->name }}
                            @endforeach
                        </div>
                    @empty
                        <p class="text-muted">Brak przypisanych przedmiotów.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Lista uczniów -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-user-friends"></i> Uczniowie klasy</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imię i nazwisko</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classmates->sortBy('name') as $index => $classmate)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($classmate->id == auth()->id())
                                        <strong>{{ $classmate->name }}</strong> <span class="badge bg-primary">Ty</span>
                                    @else
                                        {{ $classmate->name }}
                                    @endif
                                </td>
                                <td>{{ $classmate->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
