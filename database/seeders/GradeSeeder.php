<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Carbon\Carbon;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get students
        $students = User::whereHas('role', function($query) {
            $query->where('name', 'student');
        })->get();

        // Get teachers
        $teachers = User::whereHas('role', function($query) {
            $query->where('name', 'teacher');
        })->get();

        // Get subjects
        $subjects = Subject::all();

        if ($students->isEmpty() || $teachers->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('Brak uczniów, nauczycieli lub przedmiotów do tworzenia ocen.');
            return;
        }

        $gradeTypes = ['sprawdzian', 'kartkówka', 'odpowiedź ustna', 'projekt', 'aktywność'];
        $gradeWeights = [5, 4, 2, 3, 1];

        foreach ($students as $student) {
            // Each student gets 5-10 random grades
            $numGrades = rand(5, 10);

            for ($i = 0; $i < $numGrades; $i++) {
                $subject = $subjects->random();
                $teacher = $teachers->random();
                $gradeValue = rand(2, 6); // Grades from 2 to 6
                $weight = $gradeWeights[array_rand($gradeWeights)];
                $type = $gradeTypes[array_rand($gradeTypes)];

                Grade::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'grade' => $gradeValue,
                    'weight' => $weight,
                    'type' => $type,
                    'description' => ucfirst($type) . ' z ' . $subject->name,
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Oceny zostały utworzone.');
    }
}