<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Services\TimeSlotsService;
use Database\Seeders\DatabaseSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimeSlotsServiceTest extends TestCase
{
    use RefreshDatabase;

    private TimeSlotsService $slotsService;
    private array $dayNames = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->slotsService = new TimeSlotsService(Employee::find(1));
    }

    public function test_slots_service()
    {
        $slots = $this->slotsService->calculateTimeSlots(60);
        $this->assertNotEmpty($slots);
        foreach ($slots as $key => $data) {
            $this->assertIsString($key);
            $this->assertCount(2, $data);
            $this->assertArrayHasKey('date_name', $data);
            $this->assertTrue(in_array($data['date_name'], $this->dayNames));
            $this->assertArrayHasKey('slots', $data);
            $this->assertIsArray($data['slots']);
            foreach ($data['slots'] as $slot) {
                $interval = date_diff(new DateTime($slot['start_time']), new DateTime($slot['end_time']));
                $this->assertEquals(1, $interval->h);
            }
        }
    }
}
