<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Matematyka',
                'description' => 'Przedmiot matematyczny obejmujący algebrę, geometrię i analizę matematyczną.',
            ],
            [
                'name' => 'Język Polski',
                'description' => 'Nauka języka polskiego, literatury i kultury polskiej.',
            ],
            [
                'name' => 'Język Angielski',
                'description' => 'Nauka języka angielskiego, gramatyki i konwersacji.',
            ],
            [
                'name' => 'Historia',
                'description' => 'Historia Polski i świata od czasów starożytnych do współczesności.',
            ],
            [
                'name' => 'Geografia',
                'description' => 'Geografia fizyczna i społeczno-ekonomiczna Polski i świata.',
            ],
            [
                'name' => 'Biologia',
                'description' => 'Podstawy biologii, anatomii i fizjologii człowieka.',
            ],
            [
                'name' => 'Chemia',
                'description' => 'Podstawy chemii ogólnej, nieorganicznej i organicznej.',
            ],
            [
                'name' => 'Fizyka',
                'description' => 'Podstawy fizyki mechanicznej, optyki i elektrotechniki.',
            ],
            [
                'name' => 'Informatyka',
                'description' => 'Podstawy programowania, technologii informacyjnych i obsługi komputera.',
            ],
            [
                'name' => 'Wychowanie Fizyczne',
                'description' => 'Zajęcia sportowe i rekreacyjne mające na celu rozwój fizyczny uczniów.',
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['name' => $subject['name']],
                $subject
            );
        }
    }
}