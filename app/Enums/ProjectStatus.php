<?php
namespace App\Enums;
enum ProjectStatus:int
{
    case PENDING=1;
    case ACCEPTED=2;
    case REJECTED=3;
    case REVIEW=4;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["value" => $case->value, "name" => __("enums.project_status.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }
}
