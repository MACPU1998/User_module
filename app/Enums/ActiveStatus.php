<?php
namespace App\Enums;
enum ActiveStatus:int
{
    case ACTIVE=1;
    case DEACTIVE=0;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["value" => $case->value, "name" => __("enums.active_status.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }

    public static function getHtmlStyle($value)
    {
        switch ($value) {
            case self::ACTIVE->value:
                $result = '<span class="badge bg-label-success me-1">'.__("enums.active_status.ACTIVE").'</span>';
                break;
            case self::DEACTIVE->value:
                $result = '<span class="badge bg-label-danger me-1">'.__("enums.active_status.DEACTIVE").'</span>';
                break;

        }
        return $result;
    }
}
