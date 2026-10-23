<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::withCount('books')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Get the latest category
        $lastCategory = Category::orderBy('id', 'desc')->first();

        // Generate the next Category ID
        if ($lastCategory) {
            $number = (int) substr($lastCategory->category_id, 1);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $validated['category_id'] = 'C' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
        'name' => 'required',
        'description' => 'nullable',
    ]);

    $category->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

    return redirect()->route('categories.index');
    }
}
