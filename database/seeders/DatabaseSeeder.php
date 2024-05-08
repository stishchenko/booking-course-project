<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $services = Service::factory()->count(10)->create();
        $company = Company::create(['name' => 'Company Name', 'address' => 'Company Address']);
        $company->services()->attach($services->pluck('id'));

        $employees = Employee::factory()->count(5)->create();
        foreach ($employees as $employee) {
            $employee->services()->attach($services->random(rand(4, 8))->pluck('id'));
            $employee->schedule()->create();
        }

    }
}
