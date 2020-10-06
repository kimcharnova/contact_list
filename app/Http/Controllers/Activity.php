<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity_Log;

class Activity extends Controller
{
    public function index()
    {
        // return 'Hello World';
        $activity_log = Activity_Log::all();
        return view('contacts.logs', compact('activity_log'));

        // return view('contacts.logs', ['activity_log' => $activity_log]);
    }
}
