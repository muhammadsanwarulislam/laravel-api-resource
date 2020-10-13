<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Course;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email'
    ];

    public const VALIDATION_RULES = [
        'name' => ['required', 'string', 'max:191', 'min:8']
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

}
