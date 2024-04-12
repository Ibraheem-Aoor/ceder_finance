<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
    protected $fillable = [
        'product_id',
        'invoice_id',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id')->first();
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function tax($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        // foreach($taxArr as $tax)
        // {
        //     $taxes[] = TaxRate::find($tax);
        // }

        return $taxes;
    }


    /**
     * Get the report query for a specific year and quarter.
     *
     * @param int $year The year for the report.
     * @param int $quarter The quarter for the report.
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getReportQuery($year, $quarter)
    {
        // calculating the given quarter start month - end month
        $startMonth = ($quarter - 1) * 3 + 1;
        $endMonth = $startMonth + 2;
        return InvoiceProduct::query()
            ->selectRaw('invoice_products.* ,MONTH(invoice_products.created_at) as month,YEAR(invoice_products.created_at) as year')
            ->leftjoin('product_services', 'invoice_products.product_id', '=', 'product_services.id')
            ->whereRaw('YEAR(invoice_products.created_at) =?', [$year])
            ->whereBetween(\DB::raw('MONTH(invoice_products.created_at)'), [$startMonth, $endMonth])
            ->where('product_services.created_by', '=', \Auth::user()->creatorId());
    }


    public static function getTotalIncome($year, $quarter , $tax_rate)
    {

        $tax = Tax::query()->where('name', 'like', '%NL%')->whereRate($tax_rate)->first(['id', 'name', 'rate']);

        return self::getTotalncomeForGivenTax(year: $year, quarter: $quarter, tax: $tax);
    }

    public static function getTotalncomeForGivenTax($year, $quarter, Tax $tax)
    {
        $nl_invoices = self::getReportQuery(year: $year, quarter: $quarter)
        ->whereTax($tax->id)->get();

        $total_discount = self::getReportQuery(year: $year, quarter: $quarter)
            ->whereTax($tax->id)
            ->whereHas('invoice', function ($invoice) {
                $invoice->where('discount_apply', 1);
            })->sum('discount');
        $total_without_discount = 0;
        foreach($nl_invoices as $invoice)
        {
            $total_without_discount += ($invoice->price * $invoice->quantity);
        }
        $total_tax_value = ($tax->rate / 100) * $total_without_discount;
        $total_without_discount += $total_tax_value;
        // total income with discount "tax must be calculated first"
        $total_with_discount = $total_without_discount - $total_discount;
        // total income with discount but without tax
        $total_income_without_tax = $total_with_discount - $total_tax_value;
        return [
            'total_income_without_tax' => $total_income_without_tax,
            'total_tax' => $total_tax_value,
        ];
    }
}
