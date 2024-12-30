<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show($slug)
    {
        // Ambil kategori beserta buku-bukunya
        $category = Category::with('books.images')->where('slug', $slug)->firstOrFail();

        return view('web.category.show', compact('category'));
    }

}
