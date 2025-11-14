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
                     ->filter($request->only(['search', 'type', 'category_id'])) 
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // --- LOGIKA KOMPRESI (INTERVENTION V3 + GD DRIVER) ---
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = 'items/' . Str::uuid() . '.webp'; // <-- Simpan sebagai .webp

            // 1. Buat manager yang HANYA menggunakan GD
            $manager = new ImageManager(new Driver());
            
            // 2. Baca file dan resize
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200);

            // 3. Encode ke format WebP 80% (Perbaikan untuk 'Could not convert to string')
            $encodedImage = $image->toWebp(80); 

            // 4. Simpan hasil encode (string) ke storage
            Storage::disk('public')->put($filename, (string) $encodedImage);
            
            $validatedData['image_url'] = $filename;
        }

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string', 
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        if ($item->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Item::where('slug', $validatedData['slug'])->where('id', '!=', $item->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        if ($request->hasFile('image_url')) {
            // Hapus file lama
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            
            $file = $request->file('image_url');
            $filename = 'items/' . Str::uuid() . '.webp'; // <-- Simpan sebagai .webp

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200);

            // (Perbaikan untuk 'Could not convert to string')
            $encodedImage = $image->toWebp(80);
            Storage::disk('public')->put($filename, (string) $encodedImage);

            $validatedData['image_url'] = $filename;
        }

        $item->update($validatedData);

        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }
        $item->delete();

        return redirect()->route('admin.items.index')
                         ->with('success', 'Item berhasil dihapus!');
    }
}