<?php

namespace App\Services;

use App\Models\Employee;
use DateInterval;
use DateTime;

class HolidayService
{
    public function addHoliday($employeeId, $startDate, $duration): string|bool
    {
        if (!$this->checkDuration($duration)) {
            return 'Current holidays duration is not allowed';
        }
        if (!$this->checkStartDate($startDate)) {
            return 'Start date should be in the future';
        }

        $endDate = new DateTime($startDate);
        if ($duration > 1) {
            $endDate->add(new DateInterval('P' . $duration . 'D'));
        }

        $employee = Employee::find($employeeId);
        $employee->schedule->holidays()->create([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return true;
    }

    private function checkDuration(int $duration)
    {
        return in_array($duration, [1, 2, 3, 5, 14]);
    }

    private function checkStartDate($startDate)
    {
        return new DateTime($startDate) > new DateTime();
    }

}
