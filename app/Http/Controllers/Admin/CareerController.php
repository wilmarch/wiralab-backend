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
    public function index(Request $request)
    {
        $jobCategories = JobCategory::orderBy('name')->get();

        $careers = Career::with('jobCategory')
                         ->filter($request->only(['search', 'job_category_id', 'is_active'])) // Panggil scope
                         ->latest()
                         ->paginate(15);
        
        return view('admin.careers.index', compact('careers', 'jobCategories'));
    }

    public function create()
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        $minDate = now()->addDay()->format('Y-m-d'); 
        return view('admin.careers.create', compact('jobCategories', 'minDate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string', 
            'closing_date' => 'required|date|after:today', 
            'is_active' => 'nullable|boolean',
        ]);

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

    public function show(Career $karir) 
    {
        $karir->load('jobCategory'); 
        return view('admin.careers.show', compact('karir'));
    }

    public function edit(Career $karir)
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        
        $minDate = now()->addDay()->format('Y-m-d');
        if ($karir->closing_date && $karir->closing_date->isAfter(now())) {
             $minDate = now()->addDay()->format('Y-m-d');
        } else {
             $minDate = $karir->closing_date ? $karir->closing_date->format('Y-m-d') : $minDate;
        }
        
        return view('admin.careers.edit', compact('karir', 'jobCategories', 'minDate'));
    }


    public function update(Request $request, Career $karir)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'closing_date' => 'required|date|after:today', 
            'is_active' => 'nullable|boolean',
        ]);

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