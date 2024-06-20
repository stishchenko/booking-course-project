<?php

namespace Tests\Feature;

use App\Dtos\HolidaysDto;
use App\Models\Employee;
use Database\Seeders\DatabaseSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HolidayDtoTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_empty_holiday()
    {
        $this->assertEmpty(HolidaysDto::transformData([]));
    }

    public function test_null_holiday()
    {
        $this->assertEmpty(HolidaysDto::transformData(null));
    }

    public function test_holiday_dto()
    {
        $employee = Employee::find(1);
        $holidays = $employee->schedule->holidays;
        $holidaysArray = HolidaysDto::transformData($holidays);
        $this->assertNotEmpty($holidaysArray);
        foreach ($holidays as $holiday) {
            $this->assertEquals(explode(' ', $holiday->start_date)[0], $holidaysArray[0]);
            $this->assertEquals(explode(' ', $holiday->end_date)[0], end($holidaysArray));
            $interval = date_diff(new DateTime($holiday->start_date), new DateTime($holiday->end_date));
            $this->assertCount($interval->days + 1, $holidaysArray);
        }
    }
}
