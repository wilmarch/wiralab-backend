<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil data untuk dropdown filter
        $jobCategories = JobCategory::orderBy('name')->get();
        $companies = Company::orderBy('name')->get(); 
        $locations = Location::orderBy('name')->get();

        // 2. Ambil data lowongan, panggil scope filter (kita akan update scope-nya nanti)
        $careers = Career::with(['jobCategory', 'company', 'location'])
                         ->filter($request->only(['search', 'job_category_id', 'company_id', 'location_id', 'is_active'])) 
                         ->latest()
                         ->paginate(15);
        
        // 3. Kirim semua data ke view
        return view('admin.careers.index', compact('careers', 'jobCategories', 'companies', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $minDate = now()->addDay()->format('Y-m-d'); 
        
        return view('admin.careers.create', compact('jobCategories', 'companies', 'locations', 'minDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'company_id' => 'required|exists:companies,id',
            'location_id' => 'required|exists:locations,id',
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

    /**
     * Display the specified resource.
     */
    public function show(Career $karir)
    {
        // Eager load semua relasi
        $karir->load(['jobCategory', 'company', 'location']); 
        return view('admin.careers.show', compact('karir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Career $karir)
    {
        $jobCategories = JobCategory::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        
        $minDate = now()->addDay()->format('Y-m-d');
        if ($karir->closing_date && $karir->closing_date->isAfter(now())) {
             $minDate = now()->addDay()->format('Y-m-d');
        } else {
             $minDate = $karir->closing_date ? $karir->closing_date->format('Y-m-d') : $minDate;
        }
        
        return view('admin.careers.edit', compact('karir', 'jobCategories', 'companies', 'locations', 'minDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $karir)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'company_id' => 'required|exists:companies,id',
            'location_id' => 'required|exists:locations,id',
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