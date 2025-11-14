<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; 

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'type',
        'name',
        'slug',
        'description',
        'image_url',
        'is_featured',   
        'inaproc_url',  
        'brosur_url',    
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean', 
        'is_featured' => 'boolean', 
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

        // Filter berdasarkan Status Unggulan (0 atau 1)
        $query->when(isset($filters['is_featured']) && $filters['is_featured'] !== '', function ($query) use ($filters) {
             return $query->where('is_featured', $filters['is_featured']);
        });
    }
}