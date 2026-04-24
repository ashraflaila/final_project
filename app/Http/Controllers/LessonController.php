<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::query();

        $query->with('course');

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $lessons = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $courses = Course::orderBy('title')->get();

        return view('lessons.index', compact('lessons', 'courses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:1000',
            'duration' => 'nullable|integer|min:0',
            'course_id' => 'required|exists:courses,id',
        ]);

        Lesson::create($data);
        return redirect()->route('lessons.index')->with('success', 'تم إضافة الدرس بنجاح');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::all();
        return view('lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:1000',
            'duration' => 'nullable|integer|min:0',
            'course_id' => 'required|exists:courses,id',
        ]);

        $lesson->update($data);
        return redirect()->route('lessons.index')->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'تم حذف الدرس بنجاح');
    }

    public function show(Lesson $lesson)
    {
        return view('lessons.show', compact('lesson'));
    }

    public function trashed()
    {
        $lessons = Lesson::onlyTrashed()
            ->with('course')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('lessons.trashed', compact('lessons'));
    }

    public function restore($id)
    {
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->restore();
        return redirect()->back()->with('success', 'تم استعادة الدرس بنجاح');
    }

    public function forceDelete($id)
    {
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->forceDelete();
        return redirect()->back()->with('success', 'تم حذف الدرس نهائياً بنجاح');
    }
}
