<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; 
class TrainingRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'name',
        'institution',
        'email',
        'phone',
        'is_contacted',
    ];

    protected $casts = [
        'is_contacted' => 'boolean',
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
    
    /**
     * Scope a query to only include registrations based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan Search (Nama Pendaftar ATAU Institusi)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('institution', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan Tipe Training (training_id)
        $query->when($filters['training_id'] ?? false, function ($query, $training_id) {
            return $query->where('training_id', $training_id);
        });
        
        // Filter berdasarkan Status (Baru/Sudah Dihubungi)
        $query->when(isset($filters['is_contacted']) && $filters['is_contacted'] !== '', function ($query) use ($filters) {
             return $query->where('is_contacted', $filters['is_contacted']);
        });
    }
}