<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\Category;
use App\Traits\ImageHandlerTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ImageHandlerTrait {
        ImageHandlerTrait::deleteImage as removeImageFile; // Alias untuk metode trait
    }

    /**
     * Display a listing of the books.
     */
    public function index(Request $request)
    {
        // Pencarian berdasarkan judul atau deskripsi
        $search = $request->input('search');
        $books = Book::with('category')
                    ->when($search, function ($query, $search) {
                        return $query->where('title', 'LIKE', "%{$search}%")
                                     ->orWhere('description', 'LIKE', "%{$search}%");
                    })
                    ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(BookRequest $request)
    {
        // Simpan data buku
        $book = Book::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        // Update data buku
        $book->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'price' => $request->price,
            'description' => $request->description,
        ]);


        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        // Menghapus semua gambar terkait dengan buku ini
        foreach ($book->images as $image) {
            $this->removeImageFile($image->image, 'books'); // Hapus file gambar dari server
            $image->delete(); // Hapus data gambar dari database
        }

        // Hapus buku dari database
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }


        /**
     * Show the form for adding images to a book.
     */
    public function addImages(Book $book)
    {
        return view('admin.books.add-images', compact('book'));
    }

    /**
     * Store the newly uploaded images for the book.
     */
    public function storeImages(Request $request, Book $book)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $this->uploadImage($image, 'books');
                BookImage::create([
                    'book_id' => $book->id,
                    'image' => $imageName,
                ]);
            }
        }

        return redirect()->route('admin.books.add-images', $book->id)->with('success', 'Images added successfully.');
    }

    /**
     * Delete a specific image from the book.
     */
    public function removeBookImage(BookImage $image)
    {
        $this->deleteImage($image->image, 'books');

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }


}