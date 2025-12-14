@extends('layouts.app')

@section('title', 'Edytuj Użytkownika')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Użytkownicy</a></li>
<li class="breadcrumb-item active">Edytuj: {{ $user->name }}</li>
@endsection

@section('header')
<h1 class="h2"><i class="fas fa-user-edit"></i> Edytuj Użytkownika</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Zobacz profil
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-warning text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit"></i> Edycja danych: {{ $user->name }}
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Dane osobowe -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-user"></i> Dane Osobowe</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-signature text-muted"></i> Imię i Nazwisko <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope text-muted"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pesel" class="form-label fw-bold">
                                    <i class="fas fa-id-card text-muted"></i> PESEL
                                </label>
                                <input type="text" class="form-control @error('pesel') is-invalid @enderror"
                                       id="pesel" name="pesel" value="{{ old('pesel', $user->pesel) }}" maxlength="11">
                                @error('pesel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone text-muted"></i> Telefon
                                </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dane systemowe -->
                        <div class="col-md-6">
                            <h6 class="text-success mb-3"><i class="fas fa-cogs"></i> Dane Systemowe</h6>

                            <div class="mb-3">
                                <label for="role_id" class="form-label fw-bold">
                                    <i class="fas fa-user-tag text-muted"></i> Rola <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('role_id') is-invalid @enderror"
                                        id="role_id" name="role_id" required>
                                    <option value="">Wybierz rolę</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="class-section" style="{{ $user->isStudent() ? '' : 'display: none;' }}">
                                <label for="class_id" class="form-label fw-bold">
                                    <i class="fas fa-door-open text-muted"></i> Klasa
                                </label>
                                <select class="form-select @error('class_id') is-invalid @enderror"
                                        id="class_id" name="class_id">
                                    <option value="">Wybierz klasę (opcjonalnie)</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h6 class="text-warning mb-3"><i class="fas fa-lock"></i> Zmiana Hasła</h6>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle"></i> Pozostaw puste, jeśli nie chcesz zmieniać hasła.
                            </p>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">
                                    <i class="fas fa-lock text-muted"></i> Nowe Hasło
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">
                                    <i class="fas fa-lock text-muted"></i> Potwierdź Nowe Hasło
                                </label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <!-- Adres -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-info mb-3"><i class="fas fa-map-marker-alt"></i> Adres</h6>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">
                                    <i class="fas fa-home text-muted"></i> Adres zamieszkania
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informacje o koncie -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-light border">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <small class="text-muted">Utworzony</small><br>
                                        <strong>{{ $user->created_at->format('d.m.Y H:i') }}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Zaktualizowany</small><br>
                                        <strong>{{ $user->updated_at->format('d.m.Y H:i') }}</strong>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Status</small><br>
                                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                            {{ $user->email_verified_at ? 'Aktywny' : 'Nieaktywny' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Powrót
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-undo"></i> Resetuj
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Zapisz Zmiany
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    const classSection = document.getElementById('class-section');
    const classSelect = document.getElementById('class_id');

    roleSelect.addEventListener('change', function() {
        const selectedRole = this.options[this.selectedIndex].text.toLowerCase();

        if (selectedRole.includes('uczeń') || selectedRole.includes('student')) {
            classSection.style.display = 'block';
        } else {
            classSection.style.display = 'none';
            classSelect.value = '';
        }
    });

    // PESEL validation
    const peselInput = document.getElementById('pesel');
    if (peselInput) {
        peselInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient-warning {
    background: linear-gradient(87deg, #f6c23e 0, #dda20a 100%) !important;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.form-label {
    margin-bottom: 0.5rem;
    color: #5a5c69;
}

.text-primary { color: #4e73df !important; }
.text-success { color: #1cc88a !important; }
.text-info { color: #36b9cc !important; }
.text-warning { color: #f6c23e !important; }
</style>
@endpush
