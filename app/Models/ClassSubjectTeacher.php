<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_subject_teacher';

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
    ];

    /**
     * Relacja z klasą
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relacja z przedmiotem
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relacja z nauczycielem
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
