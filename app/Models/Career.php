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
        'company_id',    
        'location_id',  
        'title',
        'slug',
        'description',
        'requirements',
        'closing_date',
        'is_active',
    ];

    /**
     * Tipe data atribut yang harus di-casting.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'closing_date' => 'date',
    ];

    /**
     * Mendapatkan kategori pekerjaan untuk lowongan ini.
     */
    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }

    /**
     * Mendapatkan perusahaan (company) untuk lowongan ini.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Mendapatkan lokasi (location) untuk lowongan ini.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFilter(Builder $query, array $filters): void
{
    // Filter berdasarkan Search (Judul Lowongan)
    $query->when($filters['search'] ?? false, function ($query, $search) {
        return $query->where('title', 'like', '%' . $search . '%');
    });

    // Filter berdasarkan Kategori Pekerjaan
    $query->when($filters['job_category_id'] ?? false, function ($query, $job_category_id) {
        return $query->where('job_category_id', $job_category_id);
    });

    // Filter berdasarkan Perusahaan (company_id)
    $query->when($filters['company_id'] ?? false, function ($query, $company_id) {
        return $query->where('company_id', $company_id);
    });

    // Filter berdasarkan Lokasi (location_id)
    $query->when($filters['location_id'] ?? false, function ($query, $location_id) {
        return $query->where('location_id', $location_id);
    });

    // Filter berdasarkan Status
    $query->when(isset($filters['is_active']) && $filters['is_active'] !== '', function ($query) use ($filters) {
         return $query->where('is_active', $filters['is_active']);
    });
}
}