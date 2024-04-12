<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillProduct extends Model
{
    protected $fillable = [
        'product_id',
        'bill_id',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id')->first();
    }

    public static function getReportQuery($year, $quarter)
    {
        // calculating the given quarter start month - end month
        $startMonth = ($quarter - 1) * 3 + 1;
        $endMonth = $startMonth + 2;
        return self::selectRaw('bill_products.* ,MONTH(bill_products.created_at) as month,YEAR(bill_products.created_at) as year')
            ->leftjoin('product_services', 'bill_products.product_id', '=', 'product_services.id')
            ->whereRaw('YEAR(bill_products.created_at) =?', [$year])
            ->whereBetween(\DB::raw('MONTH(bill_products.created_at)'), [$startMonth, $endMonth])
            ->where('product_services.created_by', '=', \Auth::user()->creatorId());
    }



    public static function getTotalExpenseTax($year, $quarter)
    {
        $bill_total_expense = 0;
        BillProduct::getReportQuery($year, $quarter)->chunkById(10 , function($bills)use(&$bill_total_expense){
            foreach($bills as $bill)
            {
                $bill_taxes = Utility::tax($bill->tax);
                foreach($bill_taxes as $bill_tax)
                {
                    $bill_total_expense += ($bill_tax->rate/100) * ($bill->price * $bill->quantity);
                }
            }
        });
        return $bill_total_expense;
    }
}
