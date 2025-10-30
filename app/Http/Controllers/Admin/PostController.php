<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post; 
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index(Request $request) 
    {
        $posts = Post::filter($request->only(['search', 'post_type', 'is_published']))
                       ->latest()
                       ->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => ['required', Rule::in(['artikel', 'berita'])],
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
            $path = $request->file('image_url')->store('posts', 'public');
            $validatedData['image_url'] = $path;
        }

        $validatedData['is_published'] = $request->has('is_published');
        Post::create($validatedData);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Postingan baru berhasil ditambahkan!');
    }

    public function show(Post $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    public function edit(Post $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Post $blog)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => ['required', Rule::in(['artikel', 'berita'])],
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
            $path = $request->file('image_url')->store('posts', 'public');
            $validatedData['image_url'] = $path;
        }

        $validatedData['is_published'] = $request->has('is_published');
        $blog->update($validatedData);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Postingan berhasil diperbarui!');
    }

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