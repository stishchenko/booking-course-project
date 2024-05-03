<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function saveProgress(Request $request)
    {
        echo "Thanks for reservation! " . $request->data . PHP_EOL;
    }
}
