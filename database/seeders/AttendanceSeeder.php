<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Subject;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
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

        // Get subjects
        $subjects = Subject::all();

        if ($students->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('Brak uczniów lub przedmiotów do tworzenia frekwencji.');
            return;
        }

        $statuses = ['present', 'absent', 'late', 'excused'];
        $weights = [80, 10, 5, 5]; // 80% present, 10% absent, 5% late, 5% excused

        foreach ($students as $student) {
            // Create attendance for last 30 days
            for ($i = 30; $i >= 1; $i--) {
                $date = Carbon::now()->subDays($i);

                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                // 3-5 subjects per day
                $subjectsToday = $subjects->random(rand(3, 5));

                foreach ($subjectsToday as $subject) {
                    // Choose status based on weights
                    $rand = rand(1, 100);
                    if ($rand <= 80) {
                        $status = 'present';
                    } elseif ($rand <= 90) {
                        $status = 'absent';
                    } elseif ($rand <= 95) {
                        $status = 'late';
                    } else {
                        $status = 'excused';
                    }

                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'date' => $date->format('Y-m-d'),
                        'status' => $status,
                        'notes' => $status === 'excused' ? 'Usprawiedliwione' : null,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                }
            }
        }

        $this->command->info('Frekwencja została utworzona.');
    }
}