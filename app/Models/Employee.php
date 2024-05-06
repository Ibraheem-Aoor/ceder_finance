<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile',
        'created_by',
    ];


    /**
     * Each employee belongs to one company.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
