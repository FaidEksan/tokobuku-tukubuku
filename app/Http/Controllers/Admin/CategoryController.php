<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ImageHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ImageHandlerTrait;

    /**
     * Menampilkan daftar kategori yang diurutkan dari terbaru dan dipaginate 10 per halaman.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menampilkan kategori terbaru, dengan semua produk terkait pada tiap kategori
        $categories = Category::with(['books' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Mengurutkan buku dari yang terbaru
        }])
        ->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc') // Mengurutkan kategori dari yang terbaru
        ->paginate(10); // Paginasi 10 per halaman


        return view('admin.category.index', compact('categories', 'search')); //category
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(CategoryRequest $request)
    {
        // Mengupload gambar menggunakan trait
        $imageName = $this->uploadImage($request->file('image'), 'categories');

        // Menyimpan data kategori
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageName,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // Mengecek apakah ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            $category->image = $this->updateImage($category->image, $request->file('image'), 'categories');
        }

        // Memperbarui data kategori
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Menghapus gambar kategori menggunakan trait
        $this->deleteImage($category->image, 'categories');
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}