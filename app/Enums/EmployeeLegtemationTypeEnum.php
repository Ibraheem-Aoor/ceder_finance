<?php
namespace App\Enums;

enum EmployeeLegtemationTypeEnum: string
{
    case PASSPORT = "Passport";
    case ID = "ID";
    case FOREIN_ID = "Dutch alien document";
    case ID_EEA = "ID_OR_EEA_PASSPORT";
    case INTERNATIONAL = "International";

    public static function getValues()
    {
        return array_column(self::cases(), 'value');
    }
}
