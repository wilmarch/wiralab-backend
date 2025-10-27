<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Ensure Controller is imported
use App\Models\Category;             // Import the Category model
use Illuminate\Http\Request;         // Import Request
use Illuminate\Support\Str;          // Import Str for slug generation
use Illuminate\Validation\Rule;      // Import Rule for unique validation

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * (GET /admin/categories)
     */
    public function index()
    {
        // Fetch all categories, ordered by name, paginate
        $categories = Category::orderBy('name')->paginate(15);

        // Return the index view, passing the categories data
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * (GET /admin/categories/create)
     */
    public function create()
    {
        // Return the create form view
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * (POST /admin/categories)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                 // Ensure name is unique for the same category_type
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('category_type', $request->category_type);
                }),
            ],
            'category_type' => ['required', Rule::in(['product', 'application'])], // Validate type
        ]);

        // 2. Create Slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Ensure slug is unique within the same type
        $count = Category::where('slug', $validatedData['slug'])
                         ->where('category_type', $validatedData['category_type'])
                         ->count();
        if ($count > 0) {
             // Append a unique ID if slug already exists for the type
             $validatedData['slug'] = $validatedData['slug'] . '-' . uniqid();
        }

        // 3. Save to Database
        Category::create($validatedData);

        // 4. Redirect back to index with a success message
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * (GET /admin/categories/{category})
     */
    public function show(Category $category)
    {
        // --- PERUBAHAN: Menampilkan View Detail Kategori ---
        // Mengarahkan ke view detail: resources/views/admin/categories/show.blade.php
        return view('admin.categories.show', compact('category')); 
    }

    /**
     * Show the form for editing the specified resource.
     * (GET /admin/categories/{category}/edit)
     */
    public function edit(Category $category)
    {
        // Mengirim data kategori yang akan diedit ke view form
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * (PUT/PATCH /admin/categories/{category})
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                 // Aturan unik, tapi abaikan kategori yang sedang diedit
                Rule::unique('categories')->ignore($category->id)->where(function ($query) use ($request) {
                    return $query->where('category_type', $request->category_type);
                }),
            ],
            'category_type' => ['required', Rule::in(['product', 'application'])],
        ]);

        // 2. Buat Ulang Slug (jika nama berubah)
        if ($validatedData['name'] !== $category->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            
            // Tambahkan pengecekan unik pada slug baru
            $count = Category::where('slug', $validatedData['slug'])
                             ->where('category_type', $validatedData['category_type'])
                             ->where('id', '!=', $category->id)
                             ->count();
            if ($count > 0) {
                 $validatedData['slug'] = $validatedData['slug'] . '-' . uniqid();
            }
        } else {
             // Jika nama tidak berubah, slug tidak perlu diubah
             unset($validatedData['slug']);
        }

        // 3. Update ke Database
        $category->update($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * (DELETE /admin/categories/{category})
     */
    public function destroy(Category $category)
    {
        // Hapus kategori. Karena item terhubung dengan onDelete('cascade'), item terkait akan ikut terhapus.
        $category->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}