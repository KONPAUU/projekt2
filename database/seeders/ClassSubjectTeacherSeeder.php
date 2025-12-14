<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class ClassSubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get teachers
        $teachers = User::whereHas('role', function($query) {
            $query->where('name', 'teacher');
        })->get();

        // Get classes and subjects
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        if ($teachers->isEmpty() || $classes->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('Brak nauczycieli, klas lub przedmiotów do przypisania.');
            return;
        }

        // Assign teachers to subjects and classes
        $assignments = [
            // Teacher 1 (Anna Nowak) - Matematyka i Fizyka
            [
                'teacher_email' => 'nauczyciel1@szkola.pl',
                'subjects' => ['Matematyka', 'Fizyka'],
                'classes' => ['1A', '1B', '2A']
            ],
            // Teacher 2 - Język Polski i Historia
            [
                'teacher_email' => 'nauczyciel2@szkola.pl',
                'subjects' => ['Język Polski', 'Historia'],
                'classes' => ['1A', '1B', '2A', '2B']
            ],
            // Teacher 3 - Język Angielski
            [
                'teacher_email' => 'nauczyciel3@szkola.pl',
                'subjects' => ['Język Angielski'],
                'classes' => ['1A', '1B', '2A', '2B', '3A']
            ]
        ];

        foreach ($assignments as $assignment) {
            $teacher = User::where('email', $assignment['teacher_email'])->first();

            if (!$teacher) {
                $this->command->warn("Nie znaleziono nauczyciela: {$assignment['teacher_email']}");
                continue;
            }

            foreach ($assignment['subjects'] as $subjectName) {
                $subject = Subject::where('name', $subjectName)->first();

                if (!$subject) {
                    $this->command->warn("Nie znaleziono przedmiotu: {$subjectName}");
                    continue;
                }

                foreach ($assignment['classes'] as $className) {
                    $class = SchoolClass::where('name', $className)->first();

                    if (!$class) {
                        $this->command->warn("Nie znaleziono klasy: {$className}");
                        continue;
                    }

                    // Check if assignment already exists
                    $exists = DB::table('class_subject_teacher')
                               ->where('class_id', $class->id)
                               ->where('subject_id', $subject->id)
                               ->where('teacher_id', $teacher->id)
                               ->exists();

                    if (!$exists) {
                        DB::table('class_subject_teacher')->insert([
                            'class_id' => $class->id,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $this->command->info("Przypisano: {$teacher->name} -> {$subjectName} -> {$className}");
                    }
                }
            }
        }

        $this->command->info('Przypisania nauczycieli zostały utworzone.');
    }
}