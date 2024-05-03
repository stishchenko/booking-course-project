<?php

namespace App\Services;

use App\Dtos\HolidaysDto;
use App\Models\Employee;
use DateInterval;
use DateTime;

class TimeSlotsService
{

    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }


    public function calculateTimeSlots(int $duration): array
    {
        $employee = $this->employee;
        $holidays = HolidaysDto::transformData($employee->schedule->holidays);
        $currentDate = new DateTime();
        //$currentDay = strtolower(now()->englishDayOfWeek);
        //$skipTillToday = true;

        $dates = [];
        $dateNames = [];
        $timeSlots = [];
        $counter = 0;

        while ($counter < 7) {

            if (in_array($currentDate->format('Y-m-d'), $holidays)) {
                $currentDate->add(new DateInterval('P1D'));
                continue;
            }
            $dateName = strtolower($currentDate->format('l'));
            $date = $currentDate->format('Y-m-d');
            $currentDate->add(new DateInterval('P1D'));
            $timeSlots[$date] = [
                'date_name' => $dateName,
                'slots' => [],
            ];
            $counter ++;
        }

        foreach ($timeSlots as $slotDate => $slotInfo) {
            $slotsOfDay = $this->buildTimeSlots(
                $duration,
                DateTime::createFromFormat('H', '9'),
                DateTime::createFromFormat('H', '18')
            );

            $timeSlots[$slotDate]['slots'] = $slotsOfDay;
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
