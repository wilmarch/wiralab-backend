<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'application_link', 
        'closing_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'closing_date' => 'date', 
    ];


    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}