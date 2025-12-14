<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'date',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relacja z uczniem
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relacja z przedmiotem
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relacja z nauczycielem
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Statusy frekwencji
     */
    public static function getStatuses()
    {
        return [
            'present' => 'Obecny',
            'absent' => 'Nieobecny',
            'late' => 'Spóźniony',
            'excused' => 'Usprawiedliwiony'
        ];
    }

    /**
     * Pobiera klasę CSS dla statusu
     */
    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'present' => 'text-success',
            'absent' => 'text-danger',
            'late' => 'text-warning',
            'excused' => 'text-info',
            default => 'text-muted'
        };
    }

    /**
     * Pobiera ikonę dla statusu
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'present' => 'fas fa-check-circle',
            'absent' => 'fas fa-times-circle',
            'late' => 'fas fa-clock',
            'excused' => 'fas fa-info-circle',
            default => 'fas fa-question-circle'
        };
    }

    /**
     * Pobiera czytelną nazwę statusu
     */
    public function getStatusNameAttribute()
    {
        return self::getStatuses()[$this->status] ?? 'Nieznany';
    }

    /**
     * Sprawdza czy nieobecność jest nieusprawiedliwiona
     */
    public function isUnexcused()
    {
        return $this->status === 'absent';
    }

    /**
     * Sprawdza czy uczeń był obecny (włączając spóźnienia)
     */
    public function wasPresent()
    {
        return in_array($this->status, ['present', 'late']);
    }
}