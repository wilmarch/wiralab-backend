<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        // --- LOGIKA KOMPRESI (INTERVENTION V3 + GD DRIVER) ---
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'companies/' . Str::uuid() . '.webp'; // Simpan sebagai .webp

            // 1. Buat manager yang HANYA menggunakan GD
            $manager = new ImageManager(new Driver());
            
            // 2. Baca file, resize, dan encode
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(400, 400); // Logo lebih kecil (Max 400px)

            // 3. Encode ke format WebP 80% (INI PERBAIKANNYA)
            $encodedImage = $image->toWebp(80); 

            // 4. Simpan hasil encode (string) ke storage
            Storage::disk('public')->put($filename, (string) $encodedImage);
            
            $validatedData['logo_url'] = $filename; // Simpan path ke database
        }

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Company::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        Company::create($validatedData);

        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan baru berhasil ditambahkan.');
    }

    public function show(Company $perusahaan) 
    {
        return redirect()->route('admin.companies.edit', $perusahaan);
    }

    public function edit(Company $perusahaan)
    {
        return view('admin.companies.edit', compact('perusahaan'));
    }

    public function update(Request $request, Company $perusahaan)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('companies')->ignore($perusahaan->id)],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($perusahaan->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Company::where('slug', $validatedData['slug'])->where('id', '!=', $perusahaan->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }
        
        if ($request->hasFile('logo')) {
            // Hapus file lama
            if ($perusahaan->logo_url && Storage::disk('public')->exists($perusahaan->logo_url)) {
                Storage::disk('public')->delete($perusahaan->logo_url);
            }
            
            $file = $request->file('logo');
            $filename = 'companies/' . Str::uuid() . '.webp'; // Simpan sebagai .webp

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->resizeDown(400, 400);

            // (INI PERBAIKANNYA)
            $encodedImage = $image->toWebp(80);
            Storage::disk('public')->put($filename, (string) $encodedImage);

            $validatedData['logo_url'] = $filename;
        }


        $perusahaan->update($validatedData);

        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $perusahaan) 
    {
        if ($perusahaan->logo_url && Storage::disk('public')->exists($perusahaan->logo_url)) {
            Storage::disk('public')->delete($perusahaan->logo_url);
        }
        
        $perusahaan->delete();
        
        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil dihapus.');
    }
}