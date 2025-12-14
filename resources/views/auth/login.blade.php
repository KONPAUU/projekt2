@extends('layouts.app')

@section('title', 'Logowanie')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4><i class="fas fa-sign-in-alt"></i> Logowanie do Dziennika</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Adres email
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="Wprowadź swój adres email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Hasło
                            </label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Wprowadź swoje hasło">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Zapamiętaj mnie
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="loginButton">
                                <i class="fas fa-sign-in-alt"></i> Zaloguj się
                            </button>
                        </div>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p class="mb-0">
                            Nie masz konta?
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                Zarejestruj się tutaj
                            </a>
                        </p>
                    </div>

                    <!-- Dane testowe -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-muted"><i class="fas fa-info-circle"></i> Dane testowe do logowania:</h6>
                        <small class="text-muted">
                            <strong>Administrator:</strong><br>
                            Email: admin@szkola.pl<br>
                            Hasło: password<br><br>

                            <strong>Nauczyciel:</strong><br>
                            Email: nauczyciel1@szkola.pl<br>
                            Hasło: password<br><br>

                            <strong>Uczeń:</strong><br>
                            Email: uczen1A1@szkola.pl<br>
                            Hasło: password
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Odśwież token CSRF przed wysłaniem formularza
    $('#loginForm').on('submit', function(e) {
        // Pokaż loading na przycisku
        $('#loginButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Logowanie...');

        // Odśwież token CSRF
        $.get('{{ route("login") }}', function(data) {
            var newToken = $(data).find('meta[name="csrf-token"]').attr('content');
            if (newToken) {
                $('meta[name="csrf-token"]').attr('content', newToken);
                $('input[name="_token"]').val(newToken);
            }
        }).fail(function() {
            // W przypadku błędu, po prostu kontynuuj z istniejącym tokenem
            console.log('Could not refresh CSRF token, using existing one');
        });
    });

    // Reset przycisku w przypadku błędu
    if ($('.alert-danger').length > 0) {
        $('#loginButton').prop('disabled', false).html('<i class="fas fa-sign-in-alt"></i> Zaloguj się');
    }

    // Automatyczne odświeżanie strony co 10 minut dla odświeżenia tokena
    setTimeout(function() {
        if (!$('#loginForm').data('submitted')) {
            location.reload();
        }
    }, 600000); // 10 minut

    // Zaznacz, że formularz został wysłany
    $('#loginForm').on('submit', function() {
        $(this).data('submitted', true);
    });
});
</script>
@endpush
@endsection