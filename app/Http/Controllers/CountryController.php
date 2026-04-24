<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::query();

        $query->withCount('cities');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . strtoupper($request->code) . '%');
        }

        $countries = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        return view('country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:2|max:100',
        'code' => 'required|string|max:10',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $country = new Country();
    $country->name = $request->get('name');
    $country->code = strtoupper($request->get('code'));
    $isSaved = $country->save();

    return response()->json([
        'icon'  => $isSaved ? 'success' : 'error',
        'title' => $isSaved ? 'تم إضافة الدولة بنجاح!' : 'فشل في إضافة الدولة!',
    ]);
}

    public function show($id)
    {
        $countries = Country::withTrashed()->findOrFail($id);
        return response()->view('country.show', compact('countries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $countries = Country::findOrFail($id);
        return response()->view('country.edit', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:2|max:100',
        'code' => 'required|string|max:10',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $country = Country::findOrFail($id);
    $country->name = $request->input('name');
    $country->code = strtoupper($request->input('code'));
    $country->save();

    return response()->json([
        'redirect' => route('countries.index'),
    ], 200);
}

     public function trashed()
    {

        $countries = Country::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return response()->view('country.trashed', compact('countries'));

    }
    public function destroy(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        $message = 'تم حذف الدولة بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon'  => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroyAll(Request $request)
    {
        $countries = Country::orderBy('id')->get();

        foreach ($countries as $country) {
            $country->delete();
        }

        $message = 'تم حذف كل الدول بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('countries.index')->with('success', $message);
    }

     public function restore(Request $request, $id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->restore();

        $message = 'تم استعادة الدولة بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon'  => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->back()->with('success', $message);
    }

    public function restoreAll(Request $request)
    {
        Country::onlyTrashed()->restore();

        $message = 'تمت استعادة كل الدول بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('countries.trashed')->with('success', $message);
    }

    public function forceDelete(Request $request, $id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->forceDelete();

        $message = 'تم حذف الدولة نهائيا بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('countries.trashed')->with('success', $message);
    }
 }
