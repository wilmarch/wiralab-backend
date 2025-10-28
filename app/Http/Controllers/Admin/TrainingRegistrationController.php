<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingRegistration;
use Illuminate\Http\Request;

class TrainingRegistrationController extends Controller
{
    /**
     * Display a listing of the resource (Daftar Pendaftar).
     * (GET /admin/pendaftar-pelatihan)
     */
    public function index()
    {
        // Ambil pendaftar, eager load tipe training yang dipilih, dan paginate
        $registrations = TrainingRegistration::with('training')
                                            ->latest() // Tampilkan yang terbaru dulu
                                            ->paginate(15);

        // Kirim data ke view index
        // Pastikan view ini ada: resources/views/admin/pendaftar-pelatihan/index.blade.php
        return view('admin.pendaftar-pelatihan.index', compact('registrations'));
    }

    /**
     * Display the specified resource (Detail 1 Pendaftar).
     * (GET /admin/pendaftar-pelatihan/{pendaftar-pelatihan})
     */
    public function show(TrainingRegistration $pendaftar_pelatihan)
    {
        // Tandai sebagai sudah dihubungi (is_contacted) saat admin melihat detail
        if (!$pendaftar_pelatihan->is_contacted) {
            $pendaftar_pelatihan->is_contacted = true;
            $pendaftar_pelatihan->save();
        }
        
        // Load training relationship
        $pendaftar_pelatihan->load('training');

        // Kirim data ke view detail
        // Pastikan view ini ada: resources/views/admin/pendaftar-pelatihan/show.blade.php
        return view('admin.pendaftar-pelatihan.show', compact('pendaftar_pelatihan'));
    }

    /**
     * Remove the specified resource from storage (Hapus Pendaftar).
     */
    public function destroy(TrainingRegistration $pendaftar_pelatihan)
    {
        $pendaftar_pelatihan->delete();

        return redirect()->route('admin.pendaftar-pelatihan.index')
                         ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    // Metode create, store, edit, update tidak digunakan (dibiarkan kosong)
}