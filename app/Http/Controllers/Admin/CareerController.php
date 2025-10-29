<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::with('jobCategory')
                         ->latest()
                         ->paginate(15);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        // Kirim tanggal 'besok' ke view untuk batasan 'min'
        $minDate = now()->addDay()->format('Y-m-d'); 
        return view('admin.careers.create', compact('jobCategories', 'minDate'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            // PERUBAHAN DI SINI: 'after_or_equal:today' -> 'after:today'
            'closing_date' => 'required|date|after:today',
            'is_active' => 'nullable|boolean',
        ]);

        // 2. Generate Slug
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Career::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        // 3. Penanganan Checkbox
        $validatedData['is_active'] = $request->has('is_active');
        Career::create($validatedData);

        return redirect()->route('admin.careers.index')
                         ->with('success', 'Lowongan baru berhasil ditambahkan!');
    }

    public function show(Career $karir)
    {
        $karir->load('jobCategory'); 
        return view('admin.careers.show', compact('karir'));
    }

    public function edit(Career $karir)
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        // Tentukan tanggal 'min' untuk edit
        // Jika tanggal lamaran lama sudah lewat, min adalah tanggal lama
        // Jika belum, min adalah besok
        $minDate = now()->addDay()->format('Y-m-d');
        if ($karir->closing_date && $karir->closing_date->isPast()) {
            $minDate = $karir->closing_date->format('Y-m-d');
        }
        
        return view('admin.careers.edit', compact('karir', 'jobCategories', 'minDate'));
    }

    public function update(Request $request, Career $karir)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            // PERUBAHAN DI SINI: 'after_or_equal:today' -> 'after:today'
            // (Catatan: Ini akan memaksa admin memilih tanggal baru jika lowongan lama sudah kedaluwarsa)
            'closing_date' => 'required|date|after:today', 
            'is_active' => 'nullable|boolean',
        ]);

        // 2. Penanganan Slug
        if ($karir->title !== $validatedData['title']) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Career::where('slug', $validatedData['slug'])->where('id', '!=', $karir->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        $validatedData['is_active'] = $request->has('is_active');
        $karir->update($validatedData);

        return redirect()->route('admin.careers.index')
                         ->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy(Career $karir)
    {
        $karir->delete();
        return redirect()->route('admin.careers.index')
                         ->with('success', 'Lowongan berhasil dihapus!');
    }
}