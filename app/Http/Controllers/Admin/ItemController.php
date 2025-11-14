<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ItemController extends Controller
{

    public function index(Request $request) 
    {
        $categories = Category::orderBy('name')->get();

        $items = Item::with('category')
                     ->filter($request->only(['search', 'type', 'category_id', 'is_featured'])) 
                     ->latest()
                     ->paginate(15);

        return view('admin.items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Menambahkan 3 field baru)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean', // <-- BARU
            'inaproc_url' => 'nullable|url|max:1000', // <-- BARU
            'brosur_url' => 'nullable|file|mimes:pdf|max:5120', // <-- BARU (PDF maks 5MB)
        ]);
        
        // --- LOGIKA KOMPRESI GAMBAR ---
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = 'items/' . Str::uuid() . '.webp'; 
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200);
            $encodedImage = $image->toWebp(80); 
            Storage::disk('public')->put($filename, (string) $encodedImage);
            $validatedData['image_url'] = $filename;
        }

        // --- LOGIKA SIMPAN BROSUR (PDF) ---
        if ($request->hasFile('brosur_url')) {
            // PDF tidak dikompres, langsung simpan
            $path = $request->file('brosur_url')->store('brosurs', 'public');
            $validatedData['brosur_url'] = $path;
        }

        // Handle Checkbox
        $validatedData['is_featured'] = $request->has('is_featured');

        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Item::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        Item::create($validatedData);

        return redirect()->route('admin.items.index')
                         ->with('success', 'Item baru berhasil ditambahkan!');
    }

    public function show(Item $item)
    {
        $item->load('category'); 
        return view('admin.items.show', compact('item')); 
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        // 1. Validasi Input (Menambahkan 3 field baru)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean', // <-- BARU
            'inaproc_url' => 'nullable|url|max:1000', // <-- BARU
            'brosur_url' => 'nullable|file|mimes:pdf|max:5120', // <-- BARU
        ]);
        
        if ($item->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            // ... (logic slug)
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Item::where('slug', $validatedData['slug'])->where('id', '!=', $item->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        // --- LOGIKA KOMPRESI GAMBAR ---
        if ($request->hasFile('image_url')) {
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            $file = $request->file('image_url');
            $filename = 'items/' . Str::uuid() . '.webp';
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200);
            $encodedImage = $image->toWebp(80);
            Storage::disk('public')->put($filename, (string) $encodedImage);
            $validatedData['image_url'] = $filename;
        }

        // --- LOGIKA SIMPAN BROSUR (PDF) ---
        if ($request->hasFile('brosur_url')) {
            // Hapus brosur lama jika ada
            if ($item->brosur_url && Storage::disk('public')->exists($item->brosur_url)) {
                Storage::disk('public')->delete($item->brosur_url);
            }
            // Simpan brosur baru
            $path = $request->file('brosur_url')->store('brosurs', 'public');
            $validatedData['brosur_url'] = $path;
        }

        // Handle Checkbox
        $validatedData['is_featured'] = $request->has('is_featured');

        $item->update($validatedData);

        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        // Hapus gambar
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }
        
        // Hapus brosur (BARU)
        if ($item->brosur_url && Storage::disk('public')->exists($item->brosur_url)) {
            Storage::disk('public')->delete($item->brosur_url);
        }
        
        $item->delete();

        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil dihapus!');
    }
}