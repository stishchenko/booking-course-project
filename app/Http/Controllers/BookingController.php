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
        return view('pages.schedule');
    }

    public function confirmation()
    {
        return view('pages.confirmation');
    }
}
