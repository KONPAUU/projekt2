@extends('layouts.app')

@section('title', 'Edytuj Ocenę')

@section('header')
<h1 class="h2"><i class="fas fa-edit"></i> Edytuj Ocenę</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card glass-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('teacher.grades.update', $grade) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informacje o ocenie
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Uczeń</label>
                            <input type="text" class="form-control" value="{{ $grade->student->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Przedmiot</label>
                            <input type="text" class="form-control" value="{{ $grade->subject->name }}" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label">Ocena <span class="text-danger">*</span></label>
                                <select class="form-select @error('grade') is-invalid @enderror"
                                        id="grade"
                                        name="grade"
                                        required>
                                    <option value="">Wybierz ocenę</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('grade', $grade->grade) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label">Waga <span class="text-danger">*</span></label>
                                <select class="form-select @error('weight') is-invalid @enderror"
                                        id="weight"
                                        name="weight"
                                        required>
                                    <option value="">Wybierz wagę</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('weight', $grade->weight) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Typ oceny <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required>
                                <option value="">Wybierz typ</option>
                                <option value="sprawdzian" {{ old('type', $grade->type) == 'sprawdzian' ? 'selected' : '' }}>
                                    Sprawdzian
                                </option>
                                <option value="kartkówka" {{ old('type', $grade->type) == 'kartkówka' ? 'selected' : '' }}>
                                    Kartkówka
                                </option>
                                <option value="odpowiedź" {{ old('type', $grade->type) == 'odpowiedź' ? 'selected' : '' }}>
                                    Odpowiedź ustna
                                </option>
                                <option value="projekt" {{ old('type', $grade->type) == 'projekt' ? 'selected' : '' }}>
                                    Projekt
                                </option>
                                <option value="praca_domowa" {{ old('type', $grade->type) == 'praca_domowa' ? 'selected' : '' }}>
                                    Praca domowa
                                </option>
                                <option value="aktywność" {{ old('type', $grade->type) == 'aktywność' ? 'selected' : '' }}>
                                    Aktywność
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Opis / Komentarz</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Opcjonalny opis oceny...">{{ old('description', $grade->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksymalnie 500 znaków</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Zapisz zmiany
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-light">
                            <i class="fas fa-times me-2"></i>Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card glass-card">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Szczegóły
                </h5>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Aktualna ocena</small>
                    <span class="badge fs-5 bg-{{ $grade->grade >= 5 ? 'success' : ($grade->grade >= 4 ? 'primary' : ($grade->grade >= 3 ? 'warning' : 'danger')) }}">
                        {{ $grade->grade }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Data wystawienia</small>
                    <strong>{{ $grade->created_at->format('d.m.Y H:i') }}</strong>
                </div>

                @if($grade->updated_at != $grade->created_at)
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Ostatnia aktualizacja</small>
                    <strong>{{ $grade->updated_at->format('d.m.Y H:i') }}</strong>
                </div>
                @endif

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Liczba zmian</small>
                    <strong>{{ $grade->histories()->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="card glass-card mt-3">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Ważne informacje
                </h5>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Zmiana oceny zostanie zapisana w historii
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Uczeń zobaczy zmianę od razu
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        Średnia ucznia zostanie przeliczona
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.glass-card {
    border: none !important;
    border-radius: 20px !important;
    background: rgba(255, 255, 255, 0.86);
    backdrop-filter: blur(16px);
    box-shadow: 0 20px 45px -25px rgba(15, 23, 42, 0.35);
}
</style>
@endpush
