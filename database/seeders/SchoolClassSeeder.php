<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Pobierz nauczycieli
        $teachers = User::where('role_id', $teacherRole->id)->get();

        $classes = [
            [
                'name' => '1A',
                'year' => '2024/2025',
                'tutor_id' => $teachers->first()->id ?? null,
            ],
            [
                'name' => '1B',
                'year' => '2024/2025',
                'tutor_id' => $teachers->get(1)->id ?? null,
            ],
            [
                'name' => '2A',
                'year' => '2024/2025',
                'tutor_id' => $teachers->get(2)->id ?? null,
            ],
        ];

        foreach ($classes as $classData) {
            $class = SchoolClass::firstOrCreate(
                ['name' => $classData['name'], 'year' => $classData['year']],
                $classData
            );

            // Dodaj uczniów do klasy
            $this->createStudentsForClass($class, $studentRole->id);
        }
    }

    /**
     * Utwórz uczniów dla danej klasy.
     */
    private function createStudentsForClass(SchoolClass $class, int $studentRoleId): void
    {
        $studentNames = [
            'Aleksandra Kowalczyk',
            'Bartosz Nowak',
            'Zuzanna Wiśniewska',
            'Jakub Wójcik',
            'Natalia Kowalska',
            'Michał Kamiński',
            'Julia Lewandowska',
            'Szymon Zieliński',
            'Oliwia Szymańska',
            'Kacper Dąbrowski',
            'Maja Kozłowska',
            'Filip Jankowski',
            'Zoe Mazur',
            'Adrian Krawczyk',
            'Emilia Piotrowski',
        ];

        // Wybierz 10 losowych imion dla klasy
        $selectedNames = array_slice($studentNames, 0, 10);

        foreach ($selectedNames as $index => $name) {
            $email = 'uczen' . $class->name . ($index + 1) . '@szkola.pl';
            $pesel = $this->generatePesel(2006 + rand(0, 2)); // Uczniowie urodzeni w latach 2006-2008

            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role_id' => $studentRoleId,
                    'class_id' => $class->id,
                    'pesel' => $pesel,
                    'phone' => null, // Uczniowie mogą nie mieć telefonu
                    'address' => 'ul. Uczniowska ' . rand(1, 50) . ', 00-0' . rand(10, 99) . ' Warszawa',
                ]
            );
        }
    }

    /**
     * Generuj losowy PESEL dla danego roku urodzenia.
     */
    private function generatePesel(int $year): string
    {
        $shortYear = $year % 100;
        $month = rand(1, 12);
        $day = rand(1, 28); // Używamy 28 aby uniknąć problemów z luty

        // Dla lat 2000-2099 dodajemy 20 do miesiąca
        if ($year >= 2000 && $year <= 2099) {
            $month += 20;
        }

        // Buduj pierwszą część PESEL (6 cyfr + 3 cyfry seryjne = 9 cyfr)
        $pesel = sprintf('%02d%02d%02d', $shortYear, $month, $day);
        $pesel .= sprintf('%03d', rand(100, 999)); // Numer seryjny

        // Dodaj ostatnią cyfrę płci (0-9)
        $pesel .= rand(0, 9);

        // Teraz mamy pełne 10 cyfr, możemy obliczyć cyfrę kontrolną
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += (int)$pesel[$i] * $weights[$i];
        }

        $checksum = (10 - ($sum % 10)) % 10;
        $pesel .= $checksum;

        return $pesel;
    }
}