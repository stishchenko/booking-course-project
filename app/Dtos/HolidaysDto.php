<?php

namespace App\Dtos;

use DateInterval;
use DateTime;

class HolidaysDto
{

    public static function transformData($holidays)
    {
        if (empty($holidays)) {
            return [];
        }

        $holidaysArray = [];
        foreach ($holidays as $holiday) {
            $start_date = new DateTime($holiday->start_date);
            $end_date = new DateTime($holiday->end_date);
            while ($start_date <= $end_date) {
                $holidaysArray[] = $start_date->format('Y-m-d');
                $start_date->add(new DateInterval('P1D'));
            }
        }

        return $holidaysArray;
    }
}
