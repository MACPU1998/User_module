<?php
namespace App\Enums;
enum TicketStatus:int
{
    case PENDING=0;
    case REPLIED=1;
    case CLOSED=2;
    case USERREPLY=3;

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
                $array[$case->name] = ["value" => $case->value, "name" => __("enums.ticket_status.".$case->name)];
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
            case self::PENDING->value:
                $result = '<span class="badge bg-label-warning me-1">'.__("enums.ticket_status.PENDING").'</span>';
                break;
            case self::REPLIED->value:
                $result = '<span class="badge bg-label-secondary me-1">'.__("enums.ticket_status.REPLIED").'</span>';
                break;
            case self::CLOSED->value:
                $result = '<span class="badge bg-label-danger me-1">'.__("enums.ticket_status.CLOSED").'</span>';
                break;
            case self::USERREPLY->value:
                $result = '<span class="badge bg-label-success me-1">'.__("enums.ticket_status.USERREPLY").'</span>';
                break;

        }
        return $result;
    }

    public static function getName($value)
    {
        switch ($value) {
            case self::PENDING->value:
                $result = __("enums.ticket_status.PENDING");
                break;
            case self::REPLIED->value:
                $result = __("enums.ticket_status.REPLIED");
                break;
            case self::CLOSED->value:
                $result = __("enums.ticket_status.CLOSED");
                break;
            case self::USERREPLY->value:
                $result = __("enums.ticket_status.USERREPLY");
                break;
        }
        return $result;
    }
}
