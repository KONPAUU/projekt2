<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * Nazwa tabeli
     */
    protected $table = 'school_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'year',
        'tutor_id',
        'description',
        'level',
        'max_students',
        'classroom',
    ];

    /**
     * Relacja z uczniami w klasie
     */
    public function students()
    {
        return $this->hasMany(User::class, 'class_id')
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'student');
                    });
    }

    /**
     * Relacja z wychowawcą klasy
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Relacja z przedmiotami prowadzonymi w klasie
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'class_id', 'subject_id')
                    ->withPivot('teacher_id')
                    ->withTimestamps();
    }

    /**
     * Relacja z nauczycielami prowadzącymi przedmioty w klasie
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_subject_teacher', 'class_id', 'teacher_id')
                    ->withPivot('subject_id')
                    ->withTimestamps();
    }

    /**
     * Pobiera liczbę uczniów w klasie
     */
    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    /**
     * Pobiera średnią klasy z określonego przedmiotu
     */
    public function getClassAverage($subjectId)
    {
        $students = $this->students;
        $totalAverage = 0;
        $studentsWithGrades = 0;

        foreach ($students as $student) {
            $average = $student->getSubjectAverage($subjectId);
            if ($average > 0) {
                $totalAverage += $average;
                $studentsWithGrades++;
            }
        }

        return $studentsWithGrades > 0 ? round($totalAverage / $studentsWithGrades, 2) : 0;
    }

    /**
     * Pobiera pełną nazwę klasy (nazwa + rok szkolny)
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->year . ')';
    }
}