<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request) 
    {
        $categories = Category::filter($request->only(['search', 'category_type'])) 
                                ->orderBy('name')
                                ->paginate(15); 

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('category_type', $request->category_type);
                }),
            ],
            'category_type' => ['required', Rule::in(['product', 'application'])],
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Category::where('slug', $validatedData['slug'])->where('category_type', $validatedData['category_type'])->count() > 0) {
             $validatedData['slug'] = $originalSlug . '-' . uniqid();
        }

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function show(Category $category)
    {
         return view('admin.categories.show', compact('category')); 
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('categories')->ignore($category->id)->where(function ($query) use ($request) {
                    return $query->where('category_type', $request->category_type);
                }),
            ],
            'category_type' => ['required', Rule::in(['product', 'application'])],
        ]);

        if ($validatedData['name'] !== $category->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Category::where('slug', $validatedData['slug'])->where('category_type', $validatedData['category_type'])->where('id', '!=', $category->id)->count() > 0) {
                 $validatedData['slug'] = $originalSlug . '-' . uniqid();
            }
        } else {
             unset($validatedData['slug']);
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}