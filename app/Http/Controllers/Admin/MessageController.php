<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::latest()->paginate(20);
        return view('admin.kontak.index', compact('messages'));
    }

    /* ... method create() dan store() ... */

    /**
     * Display the specified resource.
     * (GET /admin/kontak/{kontak})
     */
    // PERBAIKAN: Ganti $message menjadi $kontak
    public function show(Message $kontak)
    {
        // 1. Tandai sebagai sudah dibaca
        if (!$kontak->is_read) {
            $kontak->is_read = true;
            $kontak->save();
        }
        
        // 2. Tampilkan view detail
        return view('admin.kontak.show', compact('kontak'));
    }

    /* ... method edit() ... */

    /**
     * Update the specified resource in storage.
     * (PUT/PATCH /admin/kontak/{kontak})
     */
    // PERBAIKAN: Ganti $message menjadi $kontak
    public function update(Request $request, Message $kontak)
    {
        // (Nanti bisa digunakan untuk toggle 'is_read' dari daftar index)
    }

    /**
     * Remove the specified resource from storage.
     * (DELETE /admin/kontak/{kontak})
     */
    // PERBAIKAN: Ganti $message menjadi $kontak
    public function destroy(Message $kontak)
    {
        
    }
}