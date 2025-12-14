@extends('layouts.app')

@section('title', 'Edytuj przedmiot: ' . $subject->name)

@section('header')
<h1 class="h2"><i class="fas fa-edit"></i> Edytuj przedmiot</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Powrót
    </a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h5 class="mb-0 text-dark"><i class="fas fa-book"></i> Edycja przedmiotu: {{ $subject->name }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-book"></i> Nazwa przedmiotu <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="code" class="form-label">
                                <i class="fas fa-code"></i> Kod
                            </label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                   id="code" name="code" value="{{ old('code', $subject->code) }}" maxlength="10">
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-folder"></i> Kategoria
                            </label>
                            <select class="form-select" id="category" name="category">
                                <option value="">-- Wybierz kategorię --</option>
                                <option value="humanistyczne" {{ old('category', $subject->category) == 'humanistyczne' ? 'selected' : '' }}>Humanistyczne</option>
                                <option value="scisle" {{ old('category', $subject->category) == 'scisle' ? 'selected' : '' }}>Ścisłe</option>
                                <option value="przyrodnicze" {{ old('category', $subject->category) == 'przyrodnicze' ? 'selected' : '' }}>Przyrodnicze</option>
                                <option value="jezykowe" {{ old('category', $subject->category) == 'jezykowe' ? 'selected' : '' }}>Językowe</option>
                                <option value="artystyczne" {{ old('category', $subject->category) == 'artystyczne' ? 'selected' : '' }}>Artystyczne</option>
                                <option value="sportowe" {{ old('category', $subject->category) == 'sportowe' ? 'selected' : '' }}>Sportowe</option>
                                <option value="inne" {{ old('category', $subject->category) == 'inne' ? 'selected' : '' }}>Inne</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hours_per_week" class="form-label">
                                <i class="fas fa-clock"></i> Godziny tygodniowo
                            </label>
                            <input type="number" class="form-control @error('hours_per_week') is-invalid @enderror"
                                   id="hours_per_week" name="hours_per_week"
                                   value="{{ old('hours_per_week', $subject->hours_per_week) }}" min="1" max="20">
                            @error('hours_per_week')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left"></i> Opis
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Opcjonalny opis przedmiotu...">{{ old('description', $subject->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory"
                                       {{ old('is_mandatory', $subject->is_mandatory) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_mandatory">
                                    <i class="fas fa-exclamation-circle"></i> Przedmiot obowiązkowy
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="has_final_exam" name="has_final_exam"
                                       {{ old('has_final_exam', $subject->has_final_exam) ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_final_exam">
                                    <i class="fas fa-file-alt"></i> Egzamin końcowy
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Anuluj
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
