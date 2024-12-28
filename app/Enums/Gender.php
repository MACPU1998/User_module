<?php
namespace App\Enums;

enum Gender:int
{
    case FEMALE = 0;
    case MALE = 1;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["id" => $case->value, "name" => __("enums.gender.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }
}
