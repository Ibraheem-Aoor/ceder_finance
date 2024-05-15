<?php
namespace App\Enums;

enum CompanyTypeEnum: string
{
    case PROPRIETORSHIP = "Proprietorship";
    case GENERAL_PARTNERSHIP = "General partnership (partnership)";
    case BV = "Private company (bv)";
    case CV = "Partnership Foundation Association Limited Partnership (CV)";
    case NV = "Public limited company (NV)";
    case CO = "Cooperative";

    public static function getValues()
    {
        return array_column(self::cases(), 'value');
    }
}
