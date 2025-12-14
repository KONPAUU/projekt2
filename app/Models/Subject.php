<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'category',
        'icon',
        'color',
        'hours_per_week',
        'is_mandatory',
        'has_final_exam',
    ];

    /**
     * Relacja z ocenami
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Relacja z frekwencją
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relacja z klasami które mają ten przedmiot
     */
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject_teacher', 'subject_id', 'class_id')
                    ->withPivot('teacher_id')
                    ->withTimestamps();
    }

    /**
     * Relacja z nauczycielami prowadzącymi ten przedmiot
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_subject_teacher', 'subject_id', 'teacher_id')
                    ->withPivot('class_id')
                    ->withTimestamps();
    }

    /**
     * Pobiera nauczyciela prowadzącego przedmiot w określonej klasie
     */
    public function getTeacherForClass($classId)
    {
        return $this->teachers()
                    ->wherePivot('class_id', $classId)
                    ->first();
    }

    /**
     * Pobiera klasy w których prowadzony jest przedmiot przez określonego nauczyciela
     */
    public function getClassesForTeacher($teacherId)
    {
        return $this->classes()
                    ->wherePivot('teacher_id', $teacherId)
                    ->get();
    }

    /**
     * Sprawdza czy przedmiot jest prowadzony przez nauczyciela w określonej klasie
     */
    public function isTaughtByTeacherInClass($teacherId, $classId)
    {
        return $this->teachers()
                    ->wherePivot('teacher_id', $teacherId)
                    ->wherePivot('class_id', $classId)
                    ->exists();
    }

    /**
     * Relacja z tabelą pivot class_subject_teacher
     */
    public function classSubjectTeachers()
    {
        return $this->hasMany(\App\Models\ClassSubjectTeacher::class, 'subject_id');
    }
}