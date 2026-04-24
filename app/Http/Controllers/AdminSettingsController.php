<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();
        $countries = Country::orderBy('name')->get();

        return view('settings.admin-profile', compact('admin', 'countries'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_admin.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/admin');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $image->move($destinationPath, $imageName);
            $data['image'] = 'images/admin/' . $imageName;
        }

        $admin->update($data);

        return redirect()->route('settings.profile.edit')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function editPassword()
    {
        return view('settings.admin-password');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors([
                'current_password' => 'كلمة المرور الحالية غير صحيحة.',
            ])->withInput();
        }

        $admin->password = $data['password'];
        $admin->save();

        return redirect()->route('settings.password.edit')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
