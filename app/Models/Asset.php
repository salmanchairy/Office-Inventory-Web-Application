<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'category_id',
        'location_id',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'acquisition_year',
        'condition',
        'status',
        'description',
        'photo',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'acquisition_year' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(AssetMovement::class);
    }
}