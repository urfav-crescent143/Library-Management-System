<?php

namespace App\Http\Controllers;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
// Because we're using Author and Category, we also need to import them at the top.

use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->search;

        $books = Book::with(['author', 'category'])  //Get ALL books, and also bring their author and category information.
            ->when($search, function ($query) use ($search) {
                $query->where('book_id', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('author_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('books.index', compact('books'));  //for when you add book its create and store
    }  
  
    public function create()
    {
        $authors = Author::all();    //Get all authors from the database.
        $categories = Category::all();  //Get all categories from the database.

        return view('books.create', compact('authors', 'categories'));  //sends both sets of data to books create.blade
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required',
            'category_id' => 'required',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0|lte:total_copies',
        ]);

        // Get the latest book
        $lastBook = Book::orderBy('id', 'desc')->first();

        // Generate the next Book ID
        if ($lastBook) {
            $number = (int) substr($lastBook->book_id, 1);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $validated['book_id'] = 'B' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);  //puts the generated ID into the data before it's saved to the database.

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book added successfully.');
    }
//for edit actions
    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'authors', 'categories'));  //sends everything to: edit.blade.php of books
    }
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'book_id' => 'required|string|max:20|unique:books,book_id,' . $book->id,
            'title' => 'required|string|max:255',
            'author_id' => 'required',
            'category_id' => 'required|integer',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0|lte:total_copies',
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book updated successfully.');
    }
}
