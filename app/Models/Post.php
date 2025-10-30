<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'post_type', 
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include posts based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters (Contoh: ['search' => 'judul', 'post_type' => 'artikel', 'is_published' => '1'])
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan Search (Judul Postingan)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        // Filter berdasarkan Tipe Postingan (artikel/berita)
        $query->when($filters['post_type'] ?? false, function ($query, $type) {
            return $query->where('post_type', $type);
        });
        
        // Filter berdasarkan Status (Published/Draft)
        $query->when(isset($filters['is_published']) && $filters['is_published'] !== '', function ($query) use ($filters) {
             // Cek '0' (Draft) atau '1' (Published)
             return $query->where('is_published', $filters['is_published']);
        });
    }
}