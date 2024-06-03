<?php

namespace App\Dtos;

use DateTime;

class SlotsDto
{
    public static function transformData($slots)
    {
        if (empty($slots)) {
            return [];
        }
        $slotsArray = [];
        foreach ($slots as $slot) {
            $slotsArray[] = [
                'start_time' => DateTime::createFromFormat("H:i:s", $slot->start_time),
                'end_time' => DateTime::createFromFormat("H:i:s", $slot->end_time)
            ];
        }
        return $slotsArray;
    }
}
