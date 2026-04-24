<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        $query->with('country');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        $countries = Country::orderBy('name')->get();

        return response()->view('teacher.index', compact('teachers', 'countries'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return response()->view('teacher.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:teachers,email',
            'password'   => 'required|string|min:6',
            'country_id' => 'nullable|exists:countries,id',
            'mobile'     => 'nullable|string|max:20',
            'date'       => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'gender'     => 'nullable|in:Male,Female',
            'status'     => 'nullable|in:Active,Inactive',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio'        => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $teacher = new Teacher();
        $teacher->name       = $request->get('name');
        $teacher->last_name  = $request->get('last_name');
        $teacher->email      = $request->get('email');
        $teacher->password   = Hash::make($request->get('password'));
        $teacher->country_id = $request->get('country_id');
        $teacher->mobile     = $request->get('mobile');
        $teacher->address    = $request->get('address');
        $teacher->date       = $request->get('date');
        $teacher->gender     = $request->get('gender', 'Male');
        $teacher->status     = $request->get('status', 'Active');
        $teacher->bio        = $request->get('bio');

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $imageName       = time() . '_teacher.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/teacher');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $teacher->image = 'images/teacher/' . $imageName;
        }

        $teacher->save();

        return response()->json([
            'redirect' => route('teachers.index'),
        ], 200);
    }

    public function show($id)
    {
        $teacher = Teacher::withTrashed()->with('country')->findOrFail($id);

        return response()->view('teacher.show', compact('teacher'));
    }

    public function edit($id)
    {
        $teacher   = Teacher::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return response()->view('teacher.edit', compact('teacher', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'country_id' => 'nullable|exists:countries,id',
            'mobile'     => 'nullable|string|max:20',
            'date'       => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'gender'     => 'nullable|in:Male,Female',
            'status'     => 'nullable|in:Active,Inactive',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio'        => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $teacher->name       = $request->input('name');
        $teacher->last_name  = $request->input('last_name');
        $teacher->email      = $request->input('email');
        $teacher->country_id = $request->input('country_id');
        $teacher->mobile     = $request->input('mobile');
        $teacher->date       = $request->input('date');
        $teacher->address    = $request->input('address');
        $teacher->gender     = $request->input('gender', 'Male');
        $teacher->status     = $request->input('status', 'Active');
        $teacher->bio        = $request->input('bio');

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $imageName       = time() . '_teacher.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/teacher');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $teacher->image = 'images/teacher/' . $imageName;
        }

        $teacher->save();

        return response()->json([
            'redirect' => route('teachers.index'),
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        $message = 'تم حذف المدرس بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function trashed()
    {
        $teachers = Teacher::onlyTrashed()
            ->with('country')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return response()->view('teacher.trashed', compact('teachers'));
    }

    public function destroyAll(Request $request)
    {
        Teacher::orderBy('id')->each(fn($t) => $t->delete());

        $message = 'تم حذف كل المدرسين بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('teachers.index')->with('success', $message);
    }

    public function restore(Request $request, $id)
    {
        $teacher = Teacher::onlyTrashed()->findOrFail($id);
        $teacher->restore();

        $message = 'تم استعادة المدرس بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function restoreAll(Request $request)
    {
        Teacher::onlyTrashed()->restore();

        $message = 'تمت استعادة كل المدرسين بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('teachers.trashed')->with('success', $message);
    }

    public function forceDelete(Request $request, $id)
    {
        $teacher = Teacher::onlyTrashed()->findOrFail($id);
        $teacher->forceDelete();

        $message = 'تم حذف المدرس نهائياً بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('teachers.trashed')->with('success', $message);
    }
}
