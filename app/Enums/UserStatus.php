<?php
namespace App\Enums;

enum UserStatus:int
{
    case PENDING = 0;
    case ACCEPTED = 1;
    case REJECTED = 2;
    case BANNED = 3;

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
