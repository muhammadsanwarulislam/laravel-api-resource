<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Models\Api\Course;
use App\Models\Api\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCourseController extends Controller
{

    public function index(Student $student)
    {
        return new StudentResource($student);
    }

    public function addStudentCourse(Course $course)
    {
        $student = Student::find(1);


        $course->students()->sync($student);

        return new CourseResource($course);
    }

    public function deleteStudentCourse(Course $course)
    {
//        $student = Student::find(Auth::user())

        $course->students()->detach($student);

    }
}
