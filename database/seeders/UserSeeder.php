<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $teacherRole = Role::where('name', 'teacher')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Administrator
        User::firstOrCreate(
            ['email' => 'admin@szkola.pl'],
            [
                'name' => 'Jan Kowalski',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'pesel' => '80010112345',
                'phone' => '123456789',
                'address' => 'ul. Szkolna 1, 00-001 Warszawa',
            ]
        );

        // Nauczyciele
        $teachers = [
            [
                'name' => 'Anna Nowak',
                'email' => 'nauczyciel1@szkola.pl',
                'pesel' => '75052234567',
                'phone' => '234567890',
                'address' => 'ul. Długa 15, 00-002 Warszawa',
            ],
            [
                'name' => 'Piotr Wiśniewski',
                'email' => 'nauczyciel2@szkola.pl',
                'pesel' => '82111245678',
                'phone' => '345678901',
                'address' => 'ul. Krótka 8, 00-003 Warszawa',
            ],
            [
                'name' => 'Maria Dąbrowska',
                'email' => 'nauczyciel3@szkola.pl',
                'pesel' => '78030356789',
                'phone' => '456789012',
                'address' => 'ul. Miła 22, 00-004 Warszawa',
            ],
        ];

        foreach ($teachers as $teacher) {
            User::firstOrCreate(
                ['email' => $teacher['email']],
                [
                    'name' => $teacher['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $teacherRole->id,
                    'pesel' => $teacher['pesel'],
                    'phone' => $teacher['phone'],
                    'address' => $teacher['address'],
                ]
            );
        }

        // Uczniowie będą dodani przez SchoolClassSeeder
    }
}