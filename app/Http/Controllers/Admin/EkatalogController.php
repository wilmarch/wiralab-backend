<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteOption; // <-- PASTIKAN MENGGUNAKAN MODEL YANG BENAR

class EkatalogController extends Controller
{
    /**
     * Menampilkan form pengaturan E-Katalog.
     * Mengambil data dari tabel site_options.
     * (GET /admin/e-katalog)
     */
    public function index()
    {
        // Ambil data link e-katalog dari database.
        // 'firstOrCreate' akan membuat data baru jika 'ekatalog_url' belum ada.
        $setting = SiteOption::firstOrCreate(
            ['key' => 'ekatalog_url'],
            ['value' => 'https://www.wiralab.com/default-katalog'] // Link default
        );

        // Kirim data ke view
        return view('admin.ekatalog.index', compact('setting'));
    }

    /**
     * Menyimpan/Update link E-Katalog.
     * Menyimpan data ke tabel site_options.
     * (POST /admin/e-katalog/update)
     */
    public function update(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'url' => 'required|url|max:255', // Pastikan input adalah URL yang valid
        ]);

        // 2. Simpan/Update ke database
        // 'updateOrCreate' akan mencari 'ekatalog_url', lalu memperbarui 'value'-nya
        SiteOption::updateOrCreate(
            ['key' => 'ekatalog_url'],
            ['value' => $validated['url']]
        );

        // 3. Redirect kembali ke halaman index e-katalog dengan pesan sukses
        return redirect()->route('admin.ekatalog.index')
                         ->with('success', 'Link E-Katalog berhasil diperbarui!');
    }
}