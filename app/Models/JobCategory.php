<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];


    public function careers(): HasMany
    {
        return $this->hasMany(Career::class);
    }
    
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}