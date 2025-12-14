<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'teacher_id',
        'subject_id',
        'grade',
        'weight',
        'type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'grade' => 'decimal:1',
        'weight' => 'integer',
    ];

    /**
     * Relacja z uczniem
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relacja z nauczycielem
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relacja z przedmiotem
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relacja z historią zmian oceny
     */
    public function histories()
    {
        return $this->hasMany(GradeHistory::class);
    }

    /**
     * Pobiera klasę CSS dla oceny (kolorowanie)
     */
    public function getGradeClassAttribute()
    {
        if ($this->grade >= 5) {
            return 'text-success'; // zielony dla 5-6
        } elseif ($this->grade >= 4) {
            return 'text-primary'; // niebieski dla 4
        } elseif ($this->grade >= 3) {
            return 'text-warning'; // żółty dla 3
        } else {
            return 'text-danger'; // czerwony dla 1-2
        }
    }

    /**
     * Pobiera ikonę dla typu oceny
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'sprawdzian' => 'fas fa-file-alt',
            'kartkówka' => 'fas fa-clipboard-check',
            'odpowiedź' => 'fas fa-comments',
            'zadanie' => 'fas fa-tasks',
            default => 'fas fa-star'
        };
    }

    /**
     * Typy ocen dostępne w systemie
     */
    public static function getGradeTypes()
    {
        return [
            'sprawdzian' => 'Sprawdzian',
            'kartkówka' => 'Kartkówka',
            'odpowiedź' => 'Odpowiedź ustna',
            'zadanie' => 'Zadanie domowe'
        ];
    }

    /**
     * Boot method dla modelu
     */
    protected static function boot()
    {
        parent::boot();

        // Automatyczne tworzenie historii przy aktualizacji oceny
        static::updating(function ($grade) {
            if ($grade->isDirty('grade')) {
                GradeHistory::create([
                    'grade_id' => $grade->id,
                    'old_grade' => $grade->getOriginal('grade'),
                    'new_grade' => $grade->grade,
                    'changed_by' => auth()->id(),
                    'reason' => 'Aktualizacja oceny'
                ]);
            }
        });
    }
}