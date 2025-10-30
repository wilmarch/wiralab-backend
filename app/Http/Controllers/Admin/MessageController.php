<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request; 

class MessageController extends Controller
{
    public function index(Request $request) 
    {
        $messages = Message::filter($request->only(['search', 'is_read'])) // Panggil scope
                             ->latest()
                             ->paginate(20); 

        return view('admin.kontak.index', compact('messages'));
    }

    public function create()
    {
        // Tidak digunakan
    }

    public function store(Request $request)
    {
        // (Nanti digunakan oleh API Frontend)
    }

    public function show(Message $kontak) 
    {
        if (!$kontak->is_read) {
            $kontak->is_read = true;
            $kontak->save();
        }
        
        return view('admin.kontak.show', compact('kontak'));
    }


    public function edit(Message $kontak) 
    {
        // Tidak digunakan
    }

    public function update(Request $request, Message $kontak) 
    {
        // (Nanti bisa digunakan untuk toggle 'is_read' dari daftar index)
    }


    public function destroy(Message $kontak) 
    {
        // Tidak digunakan
    }
}