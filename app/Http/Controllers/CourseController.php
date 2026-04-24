<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Course::class);

        $query = Course::query();

        $query->with(['teacher', 'category'])
            ->withCount('lessons');

        if (request('name')) {
            $query->where('title', 'like', '%' . request('name') . '%');
        }

        if (request('teacher_id')) {
            $query->where('teacher_id', request('teacher_id'));
        }

        $courses = $query->latest()->paginate(10)->withQueryString();
        $teachers = Teacher::orderBy('name')->get();

        return view('courses.index', compact('courses', 'teachers'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        $teachers = Teacher::all();
        $categories = Category::all();
        return view('courses.create', compact('teachers', 'categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'teacher_id' => 'required|exists:teachers,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Course::create($data);
        return redirect()->route('courses.index')->with('success', 'تم إضافة المساق بنجاح');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $teachers = Teacher::all();
        $categories = Category::all();
        return view('courses.edit', compact('course', 'teachers', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'teacher_id' => 'required|exists:teachers,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'تم تحديث المساق بنجاح');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'تم حذف المساق بنجاح');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);

        return view('courses.show', compact('course'));
    }

    public function trashed()
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::onlyTrashed()
            ->with(['teacher', 'category'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('courses.trashed', compact('courses'));
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();
        return redirect()->back()->with('success', 'تم استعادة المساق بنجاح');
    }

    public function forceDelete($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();
        return redirect()->back()->with('success', 'تم حذف المساق نهائياً بنجاح');
    }
}
