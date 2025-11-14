<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class BlogCategory extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Mendapatkan semua postingan (posts) untuk kategori ini.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'blog_category_id');
    }
    
    /**
     * Menggunakan 'slug' untuk pencarian route.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}