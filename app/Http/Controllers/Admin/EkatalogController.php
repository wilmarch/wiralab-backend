<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteOption; 

class EkatalogController extends Controller
{
    public function index()
    {
        $setting = SiteOption::firstOrCreate(
            ['key' => 'ekatalog_url'],
            ['value' => 'https://www.wiralab.com/default-katalog'] 
        );

        return view('admin.ekatalog.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:255', 
        ]);

        SiteOption::updateOrCreate(
            ['key' => 'ekatalog_url'],
            ['value' => $validated['url']]
        );

        return redirect()->route('admin.ekatalog.index')
                         ->with('success', 'Link E-Katalog berhasil diperbarui!');
    }
}