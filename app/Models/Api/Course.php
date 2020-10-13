<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code'
    ];

    public const VALIDATION_RULES = [
        'course_name' => ['required', 'string', 'max:191', 'min:3']
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
