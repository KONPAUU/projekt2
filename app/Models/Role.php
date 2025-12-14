<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
    ];

    /**
     * Relacja z użytkownikami
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Pobiera rolę administratora
     */
    public static function admin()
    {
        return static::where('name', 'admin')->first();
    }

    /**
     * Pobiera rolę nauczyciela
     */
    public static function teacher()
    {
        return static::where('name', 'teacher')->first();
    }

    /**
     * Pobiera rolę ucznia
     */
    public static function student()
    {
        return static::where('name', 'student')->first();
    }
}