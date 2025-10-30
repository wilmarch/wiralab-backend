<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_category_id',
        'title',
        'slug',
        'description',
        'requirements',
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

    /**
     * Scope a query to only include careers based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan Search (Judul Lowongan)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        // Filter berdasarkan Kategori Pekerjaan (job_category_id)
        $query->when($filters['job_category_id'] ?? false, function ($query, $job_category_id) {
            return $query->where('job_category_id', $job_category_id);
        });
        
        // Filter berdasarkan Status (Aktif/Non-Aktif)
        $query->when(isset($filters['is_active']) && $filters['is_active'] !== '', function ($query) use ($filters) {
             return $query->where('is_active', $filters['is_active']);
        });
    }
}