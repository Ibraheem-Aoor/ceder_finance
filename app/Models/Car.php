<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory , HasCreatedBy;
    protected $guarded = ['id' ,'_token'];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function brand() : BelongsTo
    {
        return $this->belongsTo(CarBrand::class , 'brand_id');
    }
    public function fuel() : BelongsTo
    {
        return $this->belongsTo(CarFuel::class , 'fuel_id');
    }

    public function walks() : HasMany
    {
        return $this->hasMany(CarWalk::class);
    }

}
