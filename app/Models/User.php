<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'class_id',
        'pesel',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relacja z rolą użytkownika
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relacja z klasą szkolną (dla uczniów)
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relacja z ocenami jako uczeń
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    /**
     * Relacja z ocenami jako nauczyciel
     */
    public function gradesAsTeacher()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    /**
     * Relacja z frekwencją
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * Klasy które prowadzi jako wychowawca
     */
    public function tutoredClasses()
    {
        return $this->hasMany(SchoolClass::class, 'tutor_id');
    }

    /**
     * Przedmioty które uczy nauczyciel
     */
    public function teachingSubjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'teacher_id', 'subject_id')
                    ->withPivot('class_id')
                    ->withTimestamps();
    }

    /**
     * Sprawdza czy użytkownik ma określoną rolę
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Sprawdza czy użytkownik jest administratorem
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Sprawdza czy użytkownik jest nauczycielem
     */
    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    /**
     * Sprawdza czy użytkownik jest uczniem
     */
    public function isStudent()
    {
        return $this->hasRole('student');
    }

    /**
     * Pobiera średnią ważoną ucznia z wszystkich przedmiotów
     */
    public function getWeightedAverage()
    {
        $grades = $this->grades;

        if ($grades->isEmpty()) {
            return 0;
        }

        $totalWeightedSum = 0;
        $totalWeight = 0;

        foreach ($grades as $grade) {
            $totalWeightedSum += $grade->grade * $grade->weight;
            $totalWeight += $grade->weight;
        }

        return $totalWeight > 0 ? round($totalWeightedSum / $totalWeight, 2) : 0;
    }

    /**
     * Pobiera średnią ważoną ucznia z określonego przedmiotu
     */
    public function getSubjectAverage($subjectId)
    {
        $grades = $this->grades()->where('subject_id', $subjectId)->get();

        if ($grades->isEmpty()) {
            return 0;
        }

        $totalWeightedSum = 0;
        $totalWeight = 0;

        foreach ($grades as $grade) {
            $totalWeightedSum += $grade->grade * $grade->weight;
            $totalWeight += $grade->weight;
        }

        return $totalWeight > 0 ? round($totalWeightedSum / $totalWeight, 2) : 0;
    }
}