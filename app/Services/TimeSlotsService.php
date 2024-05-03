<?php

namespace App\Services;

use App\Models\Employee;
use DateInterval;
use DateTime;

class TimeSlotsService
{

    private Employee $employee;

    /*public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }*/

    public function calculateTimeSlots(int $duration): array
    {
        //$employee = $this->employee;
        //$schedules = $worker->getActiveSchedule();
        $currentDate = new DateTime();
        //$currentDay = strtolower(now()->englishDayOfWeek);
        //$skipTillToday = true;

        $dates = [];
        $timeSlots = [];

        for ($i = 0; $i < 7; $i ++) {
            $dayName = strtolower($currentDate->format('l'));
            $dates[$i] = $currentDate->format('Y-m-d');
            $currentDate->add(new DateInterval('P1D'));
            $timeSlots[$dayName] = [
                'date' => $dates[$i],
                'slots' => [],
            ];
        }

        foreach ($timeSlots as $dayOfWeek => $slotInfo) {
            $slotsOfDay = $this->buildTimeSlots(
                $duration,
                DateTime::createFromFormat('H', '9'),
                DateTime::createFromFormat('H', '18')
            );

            $timeSlots[$dayOfWeek]['slots'] = $slotsOfDay;
        }

        return $timeSlots;
    }

    protected function buildTimeSlots(int $interval, DateTime $start, DateTime $end): array
    {
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $timeSlots = [];

        while (strtotime($startTime) <= strtotime($endTime)) {
            $start = $startTime;
            $followingTime = strtotime('+' . $interval . 'minutes', strtotime($startTime));
            $end = date('H:i', $followingTime);
            $startTime = date('H:i', $followingTime);

            if (strtotime($startTime) <= strtotime($endTime)) {

                $timeSlots[] = [
                    'start_time' => $start
                ];
            }
        }

        return $timeSlots;
    }
}
