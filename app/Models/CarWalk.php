<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarWalk extends Model
{
    use HasFactory;

    protected $guarded = ['id' , '_token'];

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class , 'car_id');
    }
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class , 'customer_id');
    }
    public function employee() : BelongsTo
    {
        return $this->belongsTo(Employee::class , 'employee_id');
    }
}
