<?php
namespace App\Enums;

enum BtwTimeEnum: string
{
    case MONTHLY = "montly";
    case YEARLY = "yearly";
    case QUARTER = "quarter";
    case FINE = "fine";

    public static function getValues()
    {
        return array_column(self::cases(), 'value');
    }
}
