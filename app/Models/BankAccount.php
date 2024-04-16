<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'holder_name',
        'bank_name',
        'account_number',
        'opening_balance',
        'contact_number',
        'bank_address',
        'use_on_invoice',
        'created_by',
    ];



    public function scopeIsForInvoice($query , bool $use_on_invoice)
    {
        return $query->whereUseOnInvoice($use_on_invoice);
    }


}

