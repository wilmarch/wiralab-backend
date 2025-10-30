<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{

    public function index(Request $request) 
    {
        //Ambil data untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        //Ambil data item, panggil scope filter()
        $items = Item::with('category')
                     ->filter($request->only(['search', 'type', 'category_id'])) // Panggil scope
                     ->latest()
                     ->paginate(15);

        // Kirim items DAN categories ke view
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
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['product', 'application'])],
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('items', 'public');
            $validatedData['image_url'] = $path;
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
            'description' => 'nullable|string',
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
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            
            $path = $request->file('image_url')->store('items', 'public');
            $validatedData['image_url'] = $path;
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