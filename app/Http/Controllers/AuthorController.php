<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $authors = Author::withCount('books')
        ->when($search, function ($query) use ($search) {
            $query->where('author_id', 'like', '%' . $search . '%')
                ->orWhere('author_name', 'like', '%' . $search . '%');
        })
        ->get();

        return view('authors.index', compact('authors'));
    }
    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:255',
        ]);

        // Get the latest author
        $lastAuthor = Author::orderBy('id', 'desc')->first();

        // Generate the next Author ID
        if ($lastAuthor) {
            $number = (int) substr($lastAuthor->author_id, 1);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $validated['author_id'] = 'A' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Author::create($validated);

        return redirect()
            ->route('authors.index')
            ->with('success', 'Author added successfully.');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'author_id' => 'required|string|max:20|unique:authors,author_id,' . $author->id,
            'author_name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
        ]);

        $author->update($validated);

        return redirect()
            ->route('authors.index')
            ->with('success', 'Author updated successfully.');
    }
}

