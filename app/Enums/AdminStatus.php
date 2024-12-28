<?php
namespace App\Enums;

enum AdminStatus:int
{
    case ACTIVE = 1;
    case PENDING = 2;
    case BAN = 3;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["value" => $case->value, "name" => __("enums.admin_status.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }

    public static function getHtmlStyle($value)
    {
        $result = "";
        switch ($value) {
            case self::ACTIVE:
                $result = '<span class="badge bg-label-success me-1">'.__("enums.admin_status.ACTIVE").'</span>';
                break;
            case self::PENDING:
                $result = '<span class="badge bg-label-warning me-1">'.__("enums.admin_status.PENDING").'</span>';
                break;
            case self::BAN:
                $result = '<span class="badge bg-label-danger me-1">'.__("enums.admin_status.BAN").'</span>';
                break;

        }
        return $result;
    }
}
