<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($slug)
    {
        $book = Book::with('category', 'images')->where('slug', $slug)->firstOrFail();
        return view('web.book.show', compact('book'));
    }
}