<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'file_path',
        'description',
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(
            Inspection::class
        );
    }
}