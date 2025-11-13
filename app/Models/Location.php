<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Mendapatkan semua lowongan (careers) untuk lokasi ini.
     */
    public function careers(): HasMany
    {
        return $this->hasMany(Career::class);
    }
    
    /**
     * Menggunakan 'slug' untuk pencarian route.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}