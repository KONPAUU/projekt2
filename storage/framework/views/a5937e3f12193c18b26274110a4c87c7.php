<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dziennik Lekcyjny - Nowoczesny System Zarządzania Szkołą</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #f8fafc;
            --accent-color: #06b6d4;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-color) 0%, #0891b2 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 8rem 0 5rem;
            position: relative;
            overflow: hidden;
            margin-top: -76px;
            padding-top: 8rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.05)"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: var(--secondary-color);
        }

        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-card h4 {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .feature-card p {
            color: var(--text-light);
            margin-bottom: 0;
        }

        /* User Types */
        .user-types {
            padding: 5rem 0;
        }

        .user-type-card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }

        .user-type-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .user-type-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: white;
        }

        .admin-icon { background: linear-gradient(135deg, var(--danger-color), #dc2626); }
        .teacher-icon { background: linear-gradient(135deg, var(--success-color), #059669); }
        .student-icon { background: linear-gradient(135deg, var(--accent-color), #0891b2); }

        /* CTA Section */
        .cta {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                Dziennik Lekcyjny
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Funkcjonalności</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#users">Użytkownicy</a>
                    </li>
                </ul>

                <div class="navbar-nav">
                    <?php if(auth()->guard()->check()): ?>
                        <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            Dashboard
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-link btn btn-link">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Wyloguj
                            </button>
                        </form>
                    <?php else: ?>
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Logowanie
                        </a>
                        <a class="btn btn-primary-custom ms-2" href="<?php echo e(route('register')); ?>">
                            <i class="fas fa-user-plus me-1"></i>
                            Rejestracja
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>
                        Nowoczesny Dziennik Lekcyjny
                    </h1>
                    <p>
                        Kompleksowe rozwiązanie do zarządzania szkołą. Zarządzaj ocenami, frekwencją i komunikacją w jednym miejscu.
                    </p>
                    <div>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary-custom btn-lg me-3">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Przejdź do Panelu
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary-custom btn-lg me-3">
                                <i class="fas fa-rocket me-2"></i>
                                Rozpocznij Teraz
                            </a>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Zaloguj się
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-school" style="font-size: 15rem; opacity: 0.1;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 fw-bold mb-3">Główne Funkcjonalności</h2>
                    <p class="lead text-muted">Wszystko czego potrzebujesz do efektywnego zarządzania szkołą</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Zarządzanie Ocenami</h4>
                        <p>Kompleksowy system oceniania z możliwością ważenia ocen, różnymi typami sprawdzianów i szczegółowymi statystykami.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Kontrola Frekwencji</h4>
                        <p>Elektroniczna lista obecności z możliwością usprawiedliwiania nieobecności i generowania raportów frekwencji.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Zarządzanie Użytkownikami</h4>
                        <p>Intuicyjny system zarządzania uczniami, nauczycielami i administratorami z różnymi poziomami dostępu.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Raporty i Statystyki</h4>
                        <p>Szczegółowe raporty postępów uczniów, statystyki klas i analizy wyników w czasie rzeczywistym.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Responsywny Design</h4>
                        <p>Pełna funkcjonalność na każdym urządzeniu - komputer, tablet, smartfon. Dostęp 24/7 z dowolnego miejsca.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Bezpieczeństwo</h4>
                        <p>Najwyższe standardy bezpieczeństwa danych z szyfrowanym połączeniem i zabezpieczonym dostępem.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Types Section -->
    <section class="user-types" id="users">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 fw-bold mb-3">Dla Każdego Użytkownika</h2>
                    <p class="lead text-muted">Dedykowane panele dostosowane do potrzeb różnych ról w szkole</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="user-type-card">
                        <div class="user-type-icon admin-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4>Administrator</h4>
                        <p>Pełna kontrola nad systemem. Zarządzanie użytkownikami, klasami, przedmiotami i ustawieniami systemu.</p>
                        <ul class="list-unstyled text-start mt-3">
                            <li><i class="fas fa-check text-success me-2"></i>Zarządzanie użytkownikami</li>
                            <li><i class="fas fa-check text-success me-2"></i>Konfiguracja systemu</li>
                            <li><i class="fas fa-check text-success me-2"></i>Raporty globalne</li>
                            <li><i class="fas fa-check text-success me-2"></i>Kopie zapasowe</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="user-type-card">
                        <div class="user-type-icon teacher-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h4>Nauczyciel</h4>
                        <p>Narzędzia do efektywnego nauczania. Wystawianie ocen, kontrola frekwencji i śledzenie postępów uczniów.</p>
                        <ul class="list-unstyled text-start mt-3">
                            <li><i class="fas fa-check text-success me-2"></i>Wystawianie ocen</li>
                            <li><i class="fas fa-check text-success me-2"></i>Lista obecności</li>
                            <li><i class="fas fa-check text-success me-2"></i>Raporty klas</li>
                            <li><i class="fas fa-check text-success me-2"></i>Historia zmian</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="user-type-card">
                        <div class="user-type-icon student-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h4>Uczeń</h4>
                        <p>Pełny dostęp do własnych wyników. Przeglądanie ocen, frekwencji i śledzenie postępów w nauce.</p>
                        <ul class="list-unstyled text-start mt-3">
                            <li><i class="fas fa-check text-success me-2"></i>Przeglądanie ocen</li>
                            <li><i class="fas fa-check text-success me-2"></i>Historia frekwencji</li>
                            <li><i class="fas fa-check text-success me-2"></i>Statystyki osobiste</li>
                            <li><i class="fas fa-check text-success me-2"></i>Ranking w klasie</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Gotowy na Modernizację?</h2>
                    <p>Dołącz do tysięcy szkół, które już korzystają z naszego systemu</p>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Przejdź do Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-rocket me-2"></i>
                            Zarejestruj się
                        </a>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Zaloguj się
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(55, 48, 163, 0.95) 100%)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%)';
                navbar.style.backdropFilter = 'none';
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dominik\Desktop\dziennik\dziennik-lekcyjny\resources\views/home.blade.php ENDPATH**/ ?>