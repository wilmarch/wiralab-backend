<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str
use Illuminate\Validation\Rule; // Import Rule

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * (GET /admin/blog-categories)
     */
    public function index()
    {
        $categories = BlogCategory::latest()->paginate(15);
        return view('admin.blog-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * (GET /admin/blog-categories/create)
     */
    public function create()
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * (POST /admin/blog-categories)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (BlogCategory::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        BlogCategory::create($validatedData);

        return redirect()->route('admin.blog-categories.index')
                         ->with('success', 'Kategori blog baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blog_category) // Menggunakan $blog_category
    {
        return redirect()->route('admin.blog-categories.edit', $blog_category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blog_category) // Menggunakan $blog_category
    {
        return view('admin.blog-categories.edit', compact('blog_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blog_category) // Menggunakan $blog_category
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('blog_categories')->ignore($blog_category->id)],
        ]);

        if ($blog_category->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (BlogCategory::where('slug', $validatedData['slug'])->where('id', '!=', $blog_category->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $blog_category->update($validatedData);

        return redirect()->route('admin.blog-categories.index')
                         ->with('success', 'Kategori blog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blog_category) // Menggunakan $blog_category
    {
        // Peringatan: Relasi di 'posts' akan di-set ke NULL (onDelete('set null'))
        $blog_category->delete();
        
        return redirect()->route('admin.blog-categories.index')
                         ->with('success', 'Kategori blog berhasil dihapus.');
    }
}