<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; 

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'slug',
        'description',
        'image_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include items based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters (Contoh: ['search' => 'nama', 'type' => 'product', 'category_id' => 1])
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan Search (Nama Item)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });

        // Filter berdasarkan Tipe Item (product/application)
        $query->when($filters['type'] ?? false, function ($query, $type) {
            return $query->where('type', $type);
        });
        
        // Filter berdasarkan Kategori ID
        $query->when($filters['category_id'] ?? false, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        });
    }
}