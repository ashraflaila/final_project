<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        $query->withCount('courses');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->orderBy('id', 'desc')
            ->withoutTrashed()
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:Active,Inactive',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:Active,Inactive',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'تم حذف القسم بنجاح');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()
            ->withCount('courses')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('categories.trashed', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->back()->with('success', 'تم استعادة القسم بنجاح');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->back()->with('success', 'تم حذف القسم نهائياً بنجاح');
    }
}
