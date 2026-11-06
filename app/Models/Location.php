<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'regional',
        'site',
        'building',
        'room',
        'description',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function movementsFrom(): HasMany
    {
        return $this->hasMany(
            AssetMovement::class,
            'from_location_id'
        );
    }

    public function movementsTo(): HasMany
    {
        return $this->hasMany(
            AssetMovement::class,
            'to_location_id'
        );
    }
}
