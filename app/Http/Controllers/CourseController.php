<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * عرض قائمة الدورات.
     */
    public function index()
    {
        $courses = Course::latest()->paginate(12);

        return view('courses.index', compact('courses'));
    }

    /**
     * عرض دورة محددة.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }
}
