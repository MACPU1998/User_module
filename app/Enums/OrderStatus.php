<?php
namespace App\Enums;
enum OrderStatus:int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case READY = 3;
    case SENT = 4;
    case DELIVERED = 5;
    case REJECTED = 0;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["value" => $case->value, "name" => __("enums.order_status.".$case->name)];
        }
        return $array;
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }
}
