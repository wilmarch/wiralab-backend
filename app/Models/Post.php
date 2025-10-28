<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'post_type', // 'artikel' atau 'berita'
        'image_url',
        'is_published',
    ];

    /**
     * Tipe data atribut yang harus di-casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean', // Pastikan kolom ini diperlakukan sebagai true/false
    ];

    /**
     * Menggunakan 'slug' untuk pencarian route, bukan 'id'.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}