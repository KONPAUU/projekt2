@extends('layouts.app')

@section('title', 'Pomoc')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-question-circle me-2"></i>
                Centrum Pomocy
            </h1>
            <p class="page-subtitle">Znajdź odpowiedzi na najczęściej zadawane pytania</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="input-icon">
                        <i class="fas fa-search"></i>
                        <input type="text"
                               class="form-control"
                               placeholder="Szukaj w pomocy..."
                               id="helpSearch">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-soft-primary" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">Pierwsze kroki</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Jak zalogować się do systemu?</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Resetowanie hasła</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Edycja profilu</a>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Nawigacja w systemie</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if(auth()->user()->isStudent())
        <div class="col-lg-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-soft-emerald" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">Oceny</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Jak sprawdzić moje oceny?</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Jak liczyć średnią?</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Historia ocen</a>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Statystyki wyników</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-soft-indigo" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">Frekwencja</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Jak sprawdzić obecności?</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Usprawiedliwienia nieobecności</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Kalendarz obecności</a>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Statystyki frekwencji</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isTeacher())
        <div class="col-lg-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-soft-orange" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">Nauczyciele</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Wystawianie ocen</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Zarządzanie frekwencją</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Raporty klas</a>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Historia zmian</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isAdmin())
        <div class="col-lg-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-soft-red" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                    <h5 class="card-title text-center mb-3">Administracja</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Zarządzanie użytkownikami</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Konfiguracja klas</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Przypisywanie przedmiotów</a>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <a href="#" class="text-decoration-none">Eksport danych</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        Najczęściej zadawane pytania (FAQ)
                    </h5>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Jak zmienić swoje hasło?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Przejdź do <strong>Profil</strong> i wypełnij sekcję "Zmiana hasła". Wprowadź nowe hasło dwa razy i kliknij "Zapisz zmiany".
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Jak sprawdzić swoją średnią ocen?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    @if(auth()->user()->isStudent())
                                        Przejdź do sekcji <strong>Oceny → Średnie</strong>, gdzie znajdziesz szczegółowe statystyki swoich wyników.
                                    @else
                                        Ta funkcja jest dostępna dla uczniów w sekcji <strong>Oceny → Średnie</strong>.
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Kto może edytować moje dane?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Podstawowe dane możesz edytować sam w swoim profilu. Dane systemowe (rola, przypisanie do klasy) mogą być zmieniane tylko przez administratorów systemu.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Jak skontaktować się z pomocą techniczną?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    W przypadku problemów technicznych skontaktuj się z administratorem systemu lub sekretariatem szkoły.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card glass-card bg-soft-primary">
                <div class="card-body p-4 text-center">
                    <h5 class="mb-2">
                        <i class="fas fa-headset me-2"></i>
                        Potrzebujesz dalszej pomocy?
                    </h5>
                    <p class="mb-3 text-muted">Skontaktuj się z administratorem systemu lub działem IT w swojej szkole.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Powrót do Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('helpSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.glass-card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
