<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Item extends Model // Renamed class
{
    use HasFactory;

    // Table name if it's different from the plural model name (optional here)
    // protected $table = 'items';

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'slug',
        'description',
        'image_url',
    ];

    /**
     * Get the category that owns the Item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        // Item belongs to one Category
        return $this->belongsTo(Category::class); // Changed to Category::class
    }

    /**
     * Get the route key for the model (use 'slug' in URLs).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}