<?php
namespace App\Enums;

enum EmployeSalarayPaymentPhaseEnum: string
{
    case MONTHLY = "Monthly";
    case WEEKLY = "Weekly";
    case DAILY = "Daily";

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
