# Dziennik Lekcyjny - System Zarządzania Ocenami Szkolnymi

## Opis Projektu

Kompleksowy system dziennika lekcyjnego stworzony w Laravel 10.x z wykorzystaniem wzorca MVC. System obsługuje trzy poziomy uprawnień: Administrator, Nauczyciel i Uczeń, zapewniając wszystkie funkcjonalności wymagane do zarządzania procesem edukacyjnym.

## 🚀 Funkcjonalności

### Administrator
- ✅ Pełne zarządzanie użytkownikami (CRUD)
- ✅ Zarządzanie klasami szkolnymi
- ✅ Zarządzanie przedmiotami
- ✅ Przypisywanie nauczycieli do klas i przedmiotów
- ✅ Generowanie raportów i statystyk
- ✅ Ustawienia systemowe
- ✅ Podgląd wszystkich ocen w systemie

### Nauczyciel
- ✅ Wpisywanie ocen uczniom w przypisanych klasach
- ✅ Określanie wagi ocen (1-10)
- ✅ Różne typy ocen (sprawdzian, kartkówka, odpowiedź, zadanie)
- ✅ Edycja wcześniej wpisanych ocen z zapisem historii
- ✅ Usuwanie ocen
- ✅ Przeglądanie listy uczniów w klasach
- ✅ Zarządzanie frekwencją
- ✅ Historia zmian ocen

### Uczeń
- ✅ Przeglądanie swoich ocen pogrupowanych po przedmiotach
- ✅ Wyświetlanie średniej ważonej z każdego przedmiotu
- ✅ Historia zmian ocen (kto i kiedy zmienił)
- ✅ Przeglądanie frekwencji
- ✅ Statystyki i wykresy ocen
- ✅ Eksport ocen do PDF

## 🔧 Wymagania Techniczne

### Minimalne wymagania na ocenę dostateczną:
- [x] Funkcjonalność zgodna z przeznaczeniem projektu
- [x] Trzy poziomy uprawnień (Admin, Nauczyciel, Uczeń)
- [x] Różne strony po zalogowaniu w zależności od uprawnień
- [x] Zarządzanie użytkownikami w panelu administracyjnym (CRUD)
- [x] Walidacja danych w formularzach
- [x] Zastosowany wzorzec MVC
- [x] Możliwość wpisywania ocen dla uczniów
- [x] Wyświetlanie ocen (uczeń)
- [x] Historia modyfikacji ocen

### Funkcjonalności na wyższą ocenę:
- [x] **Wyrażenia regularne w walidacji:**
  - PESEL: `/^[0-9]{11}$/`
  - Telefon: `/^[0-9]{9}$/`
  - Email: walidacja Laravel + regex
  - Wyszukiwanie użytkowników

- [x] **Paginacja:**
  - Lista użytkowników (20 na stronę)
  - Historia ocen (15 na stronę)
  - Lista klas (10 na stronę)

- [x] **Wyszukiwarka:**
  - Szukanie użytkowników po imieniu/email/PESEL
  - Filtrowanie ocen po przedmiocie i typie
  - Filtrowanie po dacie

- [x] **Dodatkowe funkcjonalności:**
  - Eksport ocen do PDF
  - Średnia klasy z przedmiotu
  - System powiadomień o nowych ocenach
  - Komentarze do ocen
  - Statystyki (najlepsza/najgorsza ocena, trendy)

## 🗄️ Struktura Bazy Danych

### Główne tabele:
- `users` - użytkownicy systemu
- `roles` - role (admin, teacher, student)
- `school_classes` - klasy szkolne
- `subjects` - przedmioty
- `grades` - oceny
- `grade_histories` - historia zmian ocen
- `attendances` - frekwencja
- `class_subject_teacher` - przypisania nauczycieli do klas i przedmiotów

## 📋 Instalacja

### 1. Przygotowanie środowiska
```bash
# Zainstaluj XAMPP/WAMP z PHP 8.x i MariaDB
# Zainstaluj Composer
# Zainstaluj Node.js i NPM
```

### 2. Klonowanie projektu
```bash
git clone <repository-url>
cd dziennik-lekcyjny
```

### 3. Instalacja zależności
```bash
composer install
npm install
```

### 4. Konfiguracja środowiska
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfiguracja bazy danych
Edytuj plik `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dziennik_lekcyjny
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Uruchomienie migracji i seedów

**WAŻNE:** Sama komenda `migrate` tworzy tylko puste tabele. Aby aplikacja działała poprawnie, musisz również uruchomić seeder, który dodaje testowych użytkowników i dane.

```bash
# Opcja 1: Migracja + seed osobno
php artisan migrate
php artisan db:seed

# Opcja 2: Wszystko w jednej komendzie (zalecane dla nowej instalacji)
php artisan migrate:fresh --seed
```

> **Uwaga:** `migrate:fresh` usuwa wszystkie tabele i tworzy je od nowa. Używaj tylko przy pierwszej instalacji lub gdy chcesz zresetować bazę danych.

### 7. Uruchomienie serwera
```bash
php artisan serve
```

Aplikacja będzie dostępna pod adresem: http://localhost:8000

## 👥 Dane Testowe

### Administrator:
- **Email:** admin@szkola.pl
- **Hasło:** password

### Nauczyciel:
- **Email:** nauczyciel1@szkola.pl
- **Hasło:** password

### Uczeń:
- **Email:** uczen1A1@szkola.pl
- **Hasło:** password

## 🏗️ Architektura Projektu

### Wzorzec MVC:
- **Models:** `app/Models/` - logika biznesowa i relacje
- **Views:** `resources/views/` - szablony Blade
- **Controllers:** `app/Http/Controllers/` - logika kontrolerów

### Middleware:
- `CheckRole` - uniwersalne sprawdzanie ról
- `AdminAccess` - dostęp dla administratorów
- `TeacherAccess` - dostęp dla nauczycieli
- `StudentAccess` - dostęp dla uczniów

### Walidacja:
- `StoreGradeRequest` - walidacja dodawania ocen
- `UpdateGradeRequest` - walidacja edycji ocen
- `StoreUserRequest` - walidacja dodawania użytkowników
- `UpdateUserRequest` - walidacja edycji użytkowników

## 🔐 Bezpieczeństwo

- Middleware sprawdzające uprawnienia użytkowników
- Walidacja CSRF na wszystkich formularzach
- Walidacja danych wejściowych z wyrażeniami regularnymi
- Hashowanie haseł z użyciem bcrypt
- Zabezpieczenia przed SQL injection (Eloquent ORM)

## 🎨 Interfejs Użytkownika

- **Framework CSS:** Bootstrap 5
- **Ikony:** Font Awesome 6
- **Responsywność:** Pełne wsparcie urządzeń mobilnych
- **Wykresy:** Chart.js dla statystyk
- **Kolorowanie ocen:**
  - 1-2: czerwony
  - 3: żółty
  - 4: niebieski
  - 5-6: zielony

## 📊 Funkcjonalności Zaawansowane

### Statystyki i Raporty:
- Średnie ocen uczniów i klas
- Statystyki frekwencji
- Wykresy postępów w nauce
- Trendy ocen w czasie

### Eksport i Import:
- Eksport ocen do PDF
- Eksport list uczniów
- Generowanie świadectw

### Powiadomienia:
- Email o nowych ocenach
- Powiadomienia o zmianach w systemie
- Alerty o niskiej frekwencji

## 🛠️ Technologie

- **Backend:** PHP 8.x, Laravel 10.x
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Baza danych:** MariaDB/MySQL
- **Dodatkowe:** Chart.js, Font Awesome, jQuery

## 📝 Licencja

Ten projekt został stworzony w celach edukacyjnych i może być używany zgodnie z licencją MIT.

## 🤝 Wsparcie

W przypadku problemów z instalacją lub używaniem systemu, skontaktuj się z administratorem lub sprawdź dokumentację Laravel.

---

**Dziennik Lekcyjny v1.0** - Nowoczesne rozwiązanie dla szkół w Polsce

testtest
