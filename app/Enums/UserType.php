<?php
namespace App\Enums;

enum UserType:int
{
    case BOTH = 0;
    case USER = 1;
    case SALEPARTNER = 2;
    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["id" => $case->value, "name" => __("enums.status.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }
}
