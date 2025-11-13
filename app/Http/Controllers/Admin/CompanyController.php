<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str untuk membuat slug
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * (GET /admin/perusahaan)
     */
    public function index()
    {
        $companies = Company::latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     * (GET /admin/perusahaan/create)
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     * (POST /admin/perusahaan)
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
        ]);

        // 2. Generate Slug
        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        // 3. Cek keunikan Slug (jika ada nama yg sama, slug-nya ditambahi unik)
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Company::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }

        // 4. Simpan ke Database
        Company::create($validatedData);

        // 5. Redirect
        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (GET /admin/perusahaan/{perusahaan})
     */
    public function show(Company $perusahaan) // Variabel $perusahaan
    {
        // Redirect ke halaman edit
        return redirect()->route('admin.companies.edit', $perusahaan);
    }

    /**
     * Show the form for editing the specified resource.
     * (GET /admin/perusahaan/{perusahaan}/edit)
     */
    public function edit(Company $perusahaan) // Variabel $perusahaan
    {
        return view('admin.companies.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     * (PATCH /admin/perusahaan/{perusahaan})
     */
    public function update(Request $request, Company $perusahaan) // Variabel $perusahaan
    {
        // 1. Validasi (abaikan unique check untuk dirinya sendiri)
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('companies')->ignore($perusahaan->id)],
        ]);

        // 2. Update Slug jika nama berubah
        if ($perusahaan->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            // Cek keunikan slug lagi
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Company::where('slug', $validatedData['slug'])->where('id', '!=', $perusahaan->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // 3. Update Database
        $perusahaan->update($validatedData);

        // 4. Redirect
        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * (DELETE /admin/perusahaan/{perusahaan})
     */
    public function destroy(Company $perusahaan) // Variabel $perusahaan
    {
        // (PERINGATAN: Lowongan (Careers) terkait akan terhapus jika Anda menambahkan onDelete('cascade') di migrasi `careers`)
        
        $perusahaan->delete();
        
        return redirect()->route('admin.companies.index')
                         ->with('success', 'Perusahaan berhasil dihapus.');
    }
}