<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);
        $validatedData['slug'] = Str::slug($validatedData['name']);
        
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Location::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }
        
        Location::create($validatedData);
        
        return redirect()->route('admin.locations.index')
                         ->with('success', 'Lokasi karir baru berhasil ditambahkan.');
    }

    public function show(Location $lokasi)
    {
        return redirect()->route('admin.locations.edit', $lokasi);
    }

    public function edit(Location $lokasi)
    {
        return view('admin.locations.edit', compact('lokasi'));
    }

    public function update(Request $request, Location $lokasi)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('locations')->ignore($lokasi->id)],
        ]);

        if ($lokasi->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Location::where('slug', $validatedData['slug'])->where('id', '!=', $lokasi->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        }

        $lokasi->update($validatedData);

        return redirect()->route('admin.locations.index')
                         ->with('success', 'Lokasi karir berhasil diperbarui.');
    }

    public function destroy(Location $lokasi)
    {
        $lokasi->delete();
        
        return redirect()->route('admin.locations.index')
                         ->with('success', 'Lokasi karir berhasil dihapus.');
    }
}