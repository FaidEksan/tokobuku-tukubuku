<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 5 item terbaru tanpa pagination
        $sliders = Slider::latest()->take(5)->get(); // Ambil 5 slider terbaru
        $categories = Category::latest()->take(5)->get(); // Ambil 5 kategori terbaru
        $books = Book::latest()->take(5)->get(); // Ambil 5 buku terbaru

        return view('web.home', compact('sliders', 'categories', 'books'));
    }
}