<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

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
}