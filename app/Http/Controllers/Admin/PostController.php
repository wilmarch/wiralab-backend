<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post; 
use App\Models\BlogCategory; // Import BlogCategory
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 2. Ambil data untuk dropdown filter
        $categories = BlogCategory::orderBy('name')->get();

        // 3. Tambahkan 'blog_category_id' ke filter
        $posts = Post::with('blogCategory') 
                       ->filter($request->only(['search', 'post_type', 'is_published', 'blog_category_id'])) // <-- TAMBAHKAN INI
                       ->latest()
                       ->paginate(15);

        // 4. Kirim 'posts' DAN 'categories' ke view
        return view('admin.blog.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // UBAH VALIDASI DI SINI
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => ['required', Rule::in(['artikel', 'berita'])],
            'blog_category_id' => 'required|exists:blog_categories,id', // <-- REVISI (Wajib)
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Post::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }
        
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = 'posts/' . Str::uuid() . '.webp'; 
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200)->toWebp(80); 
            $encodedImage = $image->toWebp(80); 
            Storage::disk('public')->put($filename, (string) $encodedImage);
            $validatedData['image_url'] = $filename;
        }

        $validatedData['is_published'] = $request->has('is_published');
        Post::create($validatedData); 

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Postingan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $blog)
    {
        $blog->load('blogCategory'); 
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $blog)
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $blog)
    {
        // UBAH VALIDASI DI SINI
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => ['required', Rule::in(['artikel', 'berita'])],
            'blog_category_id' => 'required|exists:blog_categories,id', // <-- REVISI (Wajib)
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        if ($blog->title !== $validatedData['title']) { 
            $validatedData['slug'] = Str::slug($validatedData['title']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Post::where('slug', $validatedData['slug'])->where('id', '!=', $blog->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        if ($request->hasFile('image_url')) {
            if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
                Storage::disk('public')->delete($blog->image_url);
            }
            $file = $request->file('image_url');
            $filename = 'posts/' . Str::uuid() . '.webp';
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(1200, 1200)->toWebp(80);
            $encodedImage = $image->toWebp(80);
            Storage::disk('public')->put($filename, (string) $encodedImage);
            $validatedData['image_url'] = $filename;
        }

        $validatedData['is_published'] = $request->has('is_published');
        $blog->update($validatedData);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $blog)
    {
        if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
            Storage::disk('public')->delete($blog->image_url);
        }
        $blog->delete();
        return redirect()->route('admin.blog.index')
                         ->with('success', 'Postingan berhasil dihapus!');
    }
}