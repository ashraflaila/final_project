<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $actor = $user?->actor;

        if ($actor instanceof \App\Models\Teacher) {
            return redirect()->route('teacher.dashboard');
        }

        if ($actor instanceof \App\Models\Student) {
            return redirect()->route('student.dashboard');
        }

        return view('dashboard.user', [
            'user' => $user,
        ]);
    }

    public function teacher()
    {
        $teacher = Auth::guard('teacher')->user();
        abort_unless($teacher instanceof \App\Models\Teacher, 403);

        $coursesCount = $teacher->courses()->count();
        $activeCoursesCount = $teacher->courses()->where('status', 'Active')->count();
        $lessonsCount = Lesson::whereHas('course', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->count();
        $latestCourses = $teacher->courses()->latest()->take(5)->get();
        $managedCourses = $teacher->courses()->withCount('students')->latest()->take(10)->get();

        return view('dashboard.teacher', compact(
            'teacher',
            'coursesCount',
            'activeCoursesCount',
            'lessonsCount',
            'latestCourses',
            'managedCourses'
        ));
    }

    public function student()
    {
        $student = Auth::guard('student')->user();
        abort_unless($student instanceof \App\Models\Student, 403);

        $coursesCount = $student->courses()->count();
        $activeCoursesCount = $student->courses()->where('status', 'Active')->count();
        $lessonsCount = Lesson::whereHas('course.students', function ($query) use ($student) {
            $query->where('students.id', $student->id);
        })->count();
        $latestCourses = $student->courses()->latest()->take(5)->get();
        $availableCourses = Course::with('teacher')
            ->where('status', 'Active')
            ->whereDoesntHave('students', function ($query) use ($student) {
                $query->where('students.id', $student->id);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.student', compact(
            'student',
            'coursesCount',
            'activeCoursesCount',
            'lessonsCount',
            'latestCourses',
            'availableCourses'
        ));
    }
}
