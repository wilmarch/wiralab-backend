<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\SiteOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobCategoryController extends Controller
{
    public function index()
    {
        $gformSetting = SiteOption::firstOrCreate(
            ['key' => 'karir_gform_url'],
            ['value' => null] 
        );
        $jobCategories = JobCategory::latest()->paginate(10);
        return view('admin.job-categories.index', compact('gformSetting', 'jobCategories'));
    }

    public function updateGform(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:255', 
        ]);
        SiteOption::updateOrCreate(
            ['key' => 'karir_gform_url'],
            ['value' => $validated['url']]
        );
        return redirect()->route('admin.job-categories.index')
                         ->with('success_gform', 'Link Google Form Karir berhasil diperbarui!');
    }

    public function create()
    {
        return view('admin.job-categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name',
        ]);
        $validatedData['slug'] = Str::slug($validatedData['name']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (JobCategory::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }
        JobCategory::create($validatedData);
        return redirect()->route('admin.job-categories.index')
                         ->with('success_category', 'Kategori Pekerjaan baru berhasil ditambahkan!');
    }

    public function show(JobCategory $pengaturan_karir)
    {
        return redirect()->route('admin.job-categories.edit', $pengaturan_karir);
    }

    public function edit(JobCategory $pengaturan_karir)
    {
        return view('admin.job-categories.edit', ['jobCategory' => $pengaturan_karir]);
    }

    public function update(Request $request, JobCategory $pengaturan_karir)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('job_categories')->ignore($pengaturan_karir->id)],
        ]);

        if ($pengaturan_karir->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (JobCategory::where('slug', $validatedData['slug'])->where('id', '!=', $pengaturan_karir->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $pengaturan_karir->update($validatedData); 

        return redirect()->route('admin.job-categories.index')
                         ->with('success_category', 'Kategori Pekerjaan berhasil diperbarui!');
    }

    public function destroy(JobCategory $pengaturan_karir)
    {
        $pengaturan_karir->delete(); 
        return redirect()->route('admin.job-categories.index')
                         ->with('success_category', 'Kategori Pekerjaan berhasil dihapus!');
    }
}