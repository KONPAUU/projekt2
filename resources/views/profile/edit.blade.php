@extends('layouts.app')

@section('title', 'Edycja Profilu')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-circle me-2"></i>
                Mój Profil
            </h1>
            <p class="page-subtitle">Zarządzaj swoimi danymi osobowymi</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Informacje podstawowe
                            </h5>

                            <div class="mb-3">
                                <label for="name" class="form-label">Imię i nazwisko</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="123456789">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Adres</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="2"
                                          placeholder="Ulica, nr domu, miasto">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-lock text-warning me-2"></i>
                                Zmiana hasła
                            </h5>
                            <p class="text-muted small mb-3">Pozostaw puste, jeśli nie chcesz zmieniać hasła</p>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nowe hasło</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Minimum 8 znaków">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Potwierdź nowe hasło</label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Powtórz hasło">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Zapisz zmiany
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light">
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
                        <i class="fas fa-id-card text-info me-2"></i>
                        Informacje o koncie
                    </h5>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Rola</small>
                        <span class="badge bg-soft-primary fs-6">
                            {{ $user->role->display_name ?? 'Użytkownik' }}
                        </span>
                    </div>

                    @if($user->isStudent() && $user->schoolClass)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Klasa</small>
                            <strong>{{ $user->schoolClass->name }}</strong>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Data rejestracji</small>
                        <strong>{{ $user->created_at->format('d.m.Y') }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Ostatnia aktualizacja</small>
                        <strong>{{ $user->updated_at->format('d.m.Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <div class="card glass-card mt-3">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        Bezpieczeństwo
                    </h5>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Używaj silnego hasła
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Regularnie aktualizuj swoje dane
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Nie udostępniaj swoich danych logowania
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
