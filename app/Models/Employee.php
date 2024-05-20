<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory , HasCreatedBy;
    protected $guarded = ['id' , 'token'];

    /**
     * Each employee belongs to one company.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function workHours() : HasMany
    {
        return $this->hasMany(EmployeeWorkHours::class , 'employee_id');
    }

}
