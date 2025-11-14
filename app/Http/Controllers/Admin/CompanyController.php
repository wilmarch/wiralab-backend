<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; 

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
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        // 3. Cek keunikan Slug (jika ada nama yg sama, slug-nya ditambahi unik)
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
        ]);

        if ($perusahaan->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);

            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Company::where('slug', $validatedData['slug'])->where('id', '!=', $perusahaan->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $perusahaan->update($validatedData);

        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $perusahaan) // Variabel $perusahaan
    {
        // (PERINGATAN: Lowongan (Careers) terkait akan terhapus jika Anda menambahkan onDelete('cascade') di migrasi `careers`)
        
        $perusahaan->delete();
        
        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil dihapus.');
    }
}