<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\SiteOption;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TrainingController extends Controller
{
    public function index(Request $request) 
    {
        $pdfSetting = SiteOption::firstOrCreate(
            ['key' => 'pelatihan_pdf_url'],
            ['value' => null] 
        );

        $trainings = Training::filter($request->only(['search', 'is_active'])) // Panggil scope
                             ->latest()
                             ->paginate(10); 

        return view('admin.pelatihan.index', compact('pdfSetting', 'trainings'));
    }

    public function updatePdf(Request $request)
    {
        $request->validate([
            'file_pelatihan' => 'required|file|mimes:pdf|max:5120',
        ]);
        $setting = SiteOption::firstOrCreate(['key' => 'pelatihan_pdf_url']);
        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }
        $path = $request->file('file_pelatihan')->store('pelatihan', 'public');
        $setting->value = $path;
        $setting->save();

        return redirect()->route('admin.pelatihan.index')
                         ->with('success_pdf', 'File PDF Pelatihan berhasil diperbarui!');
    }

    public function create()
    {
        return view('admin.pelatihan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:trainings,name',
            'is_active' => 'nullable|boolean',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Training::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        $validatedData['is_active'] = $request->has('is_active');
        Training::create($validatedData);

        return redirect()->route('admin.pelatihan.index')
                         ->with('success_training', 'Tipe Training baru berhasil ditambahkan!');
    }

    public function show(Training $pelatihan)
    {
        return redirect()->route('admin.pelatihan.edit', $pelatihan);
    }

    public function edit(Training $pelatihan)
    {
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, Training $pelatihan)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('trainings')->ignore($pelatihan->id)],
            'is_active' => 'nullable|boolean',
        ]);

        if ($pelatihan->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Training::where('slug', $validatedData['slug'])->where('id', '!=', $pelatihan->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $validatedData['is_active'] = $request->has('is_active');
        $pelatihan->update($validatedData);

        return redirect()->route('admin.pelatihan.index')
                         ->with('success_training', 'Tipe Training berhasil diperbarui!');
    }

    public function destroy(Training $pelatihan)
    {
        $pelatihan->delete();
        return redirect()->route('admin.pelatihan.index')
                         ->with('success_training', 'Tipe Training berhasil dihapus!');
    }
}