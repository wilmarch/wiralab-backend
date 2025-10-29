<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\JobCategory; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::with('jobCategory')
                         ->latest()
                         ->paginate(15);
        return view('admin.careers.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        // Kirim tanggal 'besok' ke view untuk batasan 'min'
        $minDate = now()->addDay()->format('Y-m-d'); 
        return view('admin.careers.create', compact('jobCategories', 'minDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Input (requirements sekarang required)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string', // WAJIB
            'closing_date' => 'required|date|after:today', // WAJIB & setelah hari ini
            'is_active' => 'nullable|boolean',
        ]);

        // Generate Slug
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Career::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        $validatedData['is_active'] = $request->has('is_active');
        Career::create($validatedData);

        return redirect()->route('admin.careers.index')
                         ->with('success', 'Lowongan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $karir) // Menggunakan $karir agar cocok dengan route
    {
        $karir->load('jobCategory'); 
        return view('admin.careers.show', compact('karir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $karir) // Menggunakan $karir
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        
        $minDate = now()->addDay()->format('Y-m-d');
        // Logika min date untuk form edit
        if ($karir->closing_date && $karir->closing_date->isAfter(now())) {
             $minDate = now()->addDay()->format('Y-m-d');
        } else {
             // Jika sudah lewat, biarkan tanggal lama sebagai min (atau 'besok' jika ingin paksa perbarui)
             $minDate = $karir->closing_date ? $karir->closing_date->format('Y-m-d') : $minDate;
        }
        
        return view('admin.careers.edit', compact('karir', 'jobCategories', 'minDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $karir) // Menggunakan $karir
    {
        // Validasi Input (requirements sekarang required)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string', // WAJIB
            'closing_date' => 'required|date|after:today', // WAJIB & setelah hari ini
            'is_active' => 'nullable|boolean',
        ]);

        // Penanganan Slug
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $karir) 
    {
        $karir->delete();
        return redirect()->route('admin.careers.index')
                         ->with('success', 'Lowongan berhasil dihapus!');
    }
}