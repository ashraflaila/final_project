<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Admin::query();

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

        $admins = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        $countries = Country::orderBy('name')->get();

        return response()->view('admin.index', compact('admins', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return response()->view('admin.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'country_id' => 'nullable|exists:countries,id',
            'mobile' => 'nullable|string|max:20',
            'date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female',
            'status' => 'nullable|in:Active,Inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin = new Admin();
        $admin->name = $request->get('name');
        $admin->last_name = $request->get('last_name');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));
        $admin->country_id = $request->get('country_id');
        $admin->mobile = $request->get('mobile');
        $admin->address = $request->get('address');
        $admin->date = $request->get('date');
        $admin->gender = $request->get('gender', 'Male');
        $admin->status = $request->get('status', 'Active');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_admin.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/admin');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $admin->image = 'images/admin/' . $imageName;
        }

        $admin->save();

        return response()->json([
            'redirect' => route('admins.index'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = Admin::withTrashed()->with('country')->findOrFail($id);

        return response()->view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $countries = Country::orderBy('name')->get();

        return response()->view('admin.edit', compact('admin', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'country_id' => 'nullable|exists:countries,id',
            'mobile' => 'nullable|string|max:20',
            'date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female',
            'status' => 'nullable|in:Active,Inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin->name = $request->input('name');
        $admin->last_name = $request->input('last_name');
        $admin->email = $request->input('email');
        $admin->country_id = $request->input('country_id');
        $admin->mobile = $request->input('mobile');
        $admin->date = $request->input('date');
        $admin->address = $request->input('address');
        $admin->gender = $request->input('gender', 'Male');
        $admin->status = $request->input('status', 'Active');

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_admin.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/admin');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $admin->image = 'images/admin/' . $imageName;
        }

        $admin->save();

        return response()->json([
            'redirect' => route('admins.index'),
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        $message = 'تم حذف الأدمن بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function trashed()
    {
        $admins = Admin::onlyTrashed()
            ->with('country')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return response()->view('admin.trashed', compact('admins'));
    }

    public function destroyAll(Request $request)
    {
        $admins = Admin::orderBy('id')->get();

        foreach ($admins as $admin) {
            $admin->delete();
        }

        $message = 'تم حذف كل الأدمنز بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('admins.index')->with('success', $message);
    }

    public function restore(Request $request, $id)
    {
        $admin = Admin::onlyTrashed()->findOrFail($id);
        $admin->restore();

        $message = 'تم استعادة الأدمن بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function restoreAll(Request $request)
    {
        Admin::onlyTrashed()->restore();

        $message = 'تمت استعادة كل الأدمنز بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('admins.trashed')->with('success', $message);
    }

    public function forceDelete(Request $request, $id)
    {
        $admin = Admin::onlyTrashed()->findOrFail($id);
        $admin->forceDelete();

        $message = 'تم حذف الأدمن نهائيا بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('admins.trashed')->with('success', $message);
    }
}
