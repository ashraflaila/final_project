<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = City::query();

        $query->with('country');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        $cities = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        $countries = Country::orderBy('name')->get();

        return response()->view('city.index', compact('cities', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $countries = Country::all();

    return response()->view('city.create', compact('countries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'street'     => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        if (! $validator->fails()) {
            $city = new City();
            $city->name       = $request->name;
            $city->street     = $request->street;
            $city->country_id = $request->country_id;
            $city->save();

            return response()->json([
                'icon'  => 'success',
                'title' => 'تم إضافة المدينة بنجاح!',
            ] , 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $city = City::withTrashed()->with('country')->findOrFail($id);

        return response()->view('city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $countries = Country::all();
        $cities = City::FindOrFail($id);

        return response()->view('city.edit', compact('cities', 'countries'));



    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name'       => 'required|string|max:255',
        'street'     => 'required|string|max:255',
        'country_id' => 'required|exists:countries,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $city = City::findOrFail($id);
    $city->name       = $request->input('name');
    $city->street     = $request->input('street');
    $city->country_id = $request->input('country_id');
    $city->save();

    return response()->json([
        'redirect' => route('cities.index'),
    ], 200);
}

    public function destroy(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        $message = 'تم حذف المدينة بنجاح!';

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
        $cities = City::onlyTrashed()->with('country')->orderBy('deleted_at', 'desc')->paginate(10);

        return response()->view('city.trashed', compact('cities'));
    }

    public function destroyAll(Request $request)
    {
        $cities = City::orderBy('id')->get();

        foreach ($cities as $city) {
            $city->delete();
        }

        $message = 'تم حذف كل المدن بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('cities.index')->with('success', $message);
    }

    public function restore(Request $request, $id)
    {
        $city = City::onlyTrashed()->findOrFail($id);
        $city->restore();

        $message = 'تم استعادة المدينة بنجاح!';

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
        City::onlyTrashed()->restore();

        $message = 'تمت استعادة كل المدن بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('cities.trashed')->with('success', $message);
    }

    public function forceDelete(Request $request, $id)
    {
        $city = City::onlyTrashed()->findOrFail($id);
        $city->forceDelete();

        $message = 'تم حذف المدينة نهائيا بنجاح!';

        if ($request->expectsJson()) {
            return response()->json([
                'icon' => 'success',
                'title' => $message,
            ], 200);
        }

        return redirect()->route('cities.trashed')->with('success', $message);
    }

}
