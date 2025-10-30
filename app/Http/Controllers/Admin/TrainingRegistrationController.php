<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingRegistration;
use App\Models\Training; 
use Illuminate\Http\Request; 

class TrainingRegistrationController extends Controller
{
    public function index(Request $request) 
    {
        $trainings = Training::where('is_active', true)->orderBy('name')->get();

        $registrations = TrainingRegistration::with('training')
                                            ->filter($request->only(['search', 'training_id', 'is_contacted'])) 
                                            ->latest()
                                            ->paginate(15);

        return view('admin.pendaftar-pelatihan.index', compact('registrations', 'trainings'));
    }

    public function show(TrainingRegistration $pendaftar_pelatihan)
    {
        if (!$pendaftar_pelatihan->is_contacted) {
            $pendaftar_pelatihan->is_contacted = true;
            $pendaftar_pelatihan->save();
        }
        
        $pendaftar_pelatihan->load('training');
        return view('admin.pendaftar-pelatihan.show', compact('pendaftar_pelatihan'));
    }

    public function destroy(TrainingRegistration $pendaftar_pelatihan)
    {
        $pendaftar_pelatihan->delete();

        return redirect()->route('admin.pendaftar-pelatihan.index')
                         ->with('success', 'Data pendaftar berhasil dihapus.');
    }
}