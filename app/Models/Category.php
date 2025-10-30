<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder; 

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_type',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include categories based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters (Contoh: ['search' => 'nama', 'type' => 'product'])
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // 1. Filter berdasarkan Search (Nama Kategori)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });

        // 2. Filter berdasarkan Tipe Kategori
        $query->when($filters['category_type'] ?? false, function ($query, $type) {
            return $query->where('category_type', $type);
        });
    }
}