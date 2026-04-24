<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

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

        $students = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        $countries = Country::orderBy('name')->get();

        return response()->view('student.index', compact('students', 'countries'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return response()->view('student.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:students,email',
            'password'   => 'required|string|min:6',
            'country_id' => 'nullable|exists:countries,id',
            'mobile'     => 'nullable|string|max:20',
            'date'       => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'gender'     => 'nullable|in:Male,Female',
            'status'     => 'nullable|in:Active,Inactive',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = new Student();
        $student->name       = $request->get('name');
        $student->last_name  = $request->get('last_name');
        $student->email      = $request->get('email');
        $student->password   = Hash::make($request->get('password'));
        $student->country_id = $request->get('country_id');
        $student->mobile     = $request->get('mobile');
        $student->address    = $request->get('address');
        $student->date       = $request->get('date');
        $student->gender     = $request->get('gender', 'Male');
        $student->status     = $request->get('status', 'Active');

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $imageName       = time() . '_student.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/student');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $student->image = 'images/student/' . $imageName;
        }

        $student->save();

        return response()->json([
            'redirect' => route('students.index'),
        ], 200);
    }

    public function show($id)
    {
        $student = Student::withTrashed()->with('country')->findOrFail($id);

        return response()->view('student.show', compact('student'));
    }

    public function edit($id)
    {
        $student   = Student::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return response()->view('student.edit', compact('student', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:students,email,' . $student->id,
            'country_id' => 'nullable|exists:countries,id',
            'mobile'     => 'nullable|string|max:20',
            'date'       => 'nullable|date',
            'address'    => 'nullable|string|max:255',
            'gender'     => 'nullable|in:Male,Female',
            'status'     => 'nullable|in:Active,Inactive',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student->name       = $request->input('name');
        $student->last_name  = $request->input('last_name');
        $student->email      = $request->input('email');
        $student->country_id = $request->input('country_id');
        $student->mobile     = $request->input('mobile');
        $student->date       = $request->input('date');
        $student->address    = $request->input('address');
        $student->gender     = $request->input('gender', 'Male');
        $student->status     = $request->input('status', 'Active');

        if ($request->filled('password')) {
            $student->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $imageName       = time() . '_student.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/student');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $student->image = 'images/student/' . $imageName;
        }

        $student->save();

        return response()->json([
            'redirect' => route('students.index'),
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        $message = 'تم حذف الطالب بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function trashed()
    {
        $students = Student::onlyTrashed()
            ->with('country')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return response()->view('student.trashed', compact('students'));
    }

    public function destroyAll(Request $request)
    {
        Student::orderBy('id')->each(fn($s) => $s->delete());

        $message = 'تم حذف كل الطلاب بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('students.index')->with('success', $message);
    }

    public function restore(Request $request, $id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();

        $message = 'تم استعادة الطالب بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function restoreAll(Request $request)
    {
        Student::onlyTrashed()->restore();

        $message = 'تمت استعادة كل الطلاب بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('students.trashed')->with('success', $message);
    }

    public function forceDelete(Request $request, $id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->forceDelete();

        $message = 'تم حذف الطالب نهائياً بنجاح!';

        if ($request->expectsJson()) {
            return response()->json(['icon' => 'success', 'title' => $message], 200);
        }

        return redirect()->route('students.trashed')->with('success', $message);
    }
}
