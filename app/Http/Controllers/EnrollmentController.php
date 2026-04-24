<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        $student = Auth::guard('student')->user();
        abort_unless($student instanceof Student, 403);

        if (! $student->courses()->where('courses.id', $course->id)->exists()) {
            $student->courses()->attach($course->id);
        }

        return back()->with('success', 'تم تسجيلك في الكورس بنجاح');
    }

    public function unenroll(Course $course)
    {
        $student = Auth::guard('student')->user();
        abort_unless($student instanceof Student, 403);

        $student->courses()->detach($course->id);

        return back()->with('success', 'تم إلغاء تسجيلك من الكورس بنجاح');
    }

    public function manage(Course $course)
    {
        $teacher = Auth::guard('teacher')->user();
        abort_unless($teacher && $course->teacher_id === $teacher->id, 403);

        $course->load('students');

        return view('dashboard.teacher-course-students', compact('course', 'teacher'));
    }

    public function removeStudent(Request $request, Course $course, Student $student)
    {
        $teacher = Auth::guard('teacher')->user();
        abort_unless($teacher && $course->teacher_id === $teacher->id, 403);

        $course->students()->detach($student->id);

        return back()->with('success', 'تم حذف الطالب من الكورس بنجاح');
    }
}
