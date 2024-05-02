<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function employees()
    {
        return view('pages.employees');
    }

    public function schedule()
    {
        $timeSlots1 = [
            'thursday' => [
                'date' => '2024-05-02',
                'slots' => [
                    ['start_time' => '08:00'],
                    ['start_time' => '09:00'],
                    ['start_time' => '10:00'],
                    ['start_time' => '11:00'],
                ]
            ],

        ];
        return view('pages.schedules')->with('slots', $timeSlots1);
    }

    public function confirmation()
    {
        return view('pages.confirmation');
    }
}
