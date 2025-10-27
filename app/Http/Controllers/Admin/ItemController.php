<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Untuk penanganan file

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * (GET /admin/items)
     */
    public function index()
    {
        // Eager load 'category'
        $items = Item::with('category')
                     ->latest()
                     ->paginate(15);

        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * (GET /admin/items/create)
     */
    public function create()
    {
        // Mengirim daftar kategori untuk dropdown
        $categories = Category::orderBy('name')->get();
        return view('admin.items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * (POST /admin/items)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // 2. Penanganan File Upload
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('items', 'public');
            $validatedData['image_url'] = $path;
        }

        // 3. Generate Slug (Pastikan unik)
        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Item::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        // 4. Simpan ke Database
        Item::create($validatedData);

        // 5. Redirect
        return redirect()->route('admin.items.index')
                         ->with('success', 'Item baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * (GET /admin/items/{item})
     */
    public function show(Item $item)
    {
        // --- PERUBAHAN UTAMA: Menampilkan View Detail ---
        // Pastikan relasi kategori dimuat
        $item->load('category'); 
        
        // Mengarahkan ke view detail: resources/views/admin/items/show.blade.php
        return view('admin.items.show', compact('item')); 
        // ------------------------------------------------
    }

    /**
     * Show the form for editing the specified resource.
     * (GET /admin/items/{item}/edit)
     */
    public function edit(Item $item)
    {
        // Mengirim data item dan daftar kategori ke form edit
        $categories = Category::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * (PUT/PATCH /admin/items/{item})
     */
    public function update(Request $request, Item $item)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // 2. Penanganan Slug
        if ($item->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Item::where('slug', $validatedData['slug'])->where('id', '!=', $item->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        // 3. Penanganan File Upload
        if ($request->hasFile('image_url')) {
            // Hapus gambar lama
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            
            // Simpan file baru
            $path = $request->file('image_url')->store('items', 'public');
            $validatedData['image_url'] = $path;
        }

        // 4. Update ke Database
        $item->update($validatedData);

        // 5. Redirect
        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * (DELETE /admin/items/{item})
     */
    public function destroy(Item $item)
    {
        // 1. Hapus gambar terkait
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        // 2. Hapus Item
        $item->delete();

        // 3. Redirect
        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil dihapus!');
    }
}