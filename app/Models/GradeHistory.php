<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grade_id',
        'old_grade',
        'new_grade',
        'changed_by',
        'reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old_grade' => 'decimal:1',
        'new_grade' => 'decimal:1',
        'created_at' => 'datetime',
    ];

    /**
     * Wyłączenie updated_at
     */
    public $timestamps = false;

    /**
     * Relacja z ocena
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Relacja z użytkownikiem który zmienił ocenę
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Automatyczne ustawianie created_at przy tworzeniu
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
        });
    }

    /**
     * Pobiera różnicę między starą a nową oceną
     */
    public function getGradeDifferenceAttribute()
    {
        $diff = $this->new_grade - $this->old_grade;

        if ($diff > 0) {
            return '+' . $diff;
        }

        return (string) $diff;
    }

    /**
     * Pobiera klasę CSS dla różnicy ocen
     */
    public function getDifferenceClassAttribute()
    {
        $diff = $this->new_grade - $this->old_grade;

        if ($diff > 0) {
            return 'text-success';
        } elseif ($diff < 0) {
            return 'text-danger';
        }

        return 'text-muted';
    }
}