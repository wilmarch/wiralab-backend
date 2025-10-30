<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'body',
        'is_read', 
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Scope a query to only include messages based on filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan Search (Nama, Email, ATAU Subjek)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan Status (Baru/Sudah Dibaca)
        $query->when(isset($filters['is_read']) && $filters['is_read'] !== '', function ($query) use ($filters) {
             return $query->where('is_read', $filters['is_read']);
        });
    }
}