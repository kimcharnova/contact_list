<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity_Log;

class Activity extends Controller
{
    public function index()
    {
        $activity_log = Activity_Log::all();
        return view('contacts.logs', compact('activity_log'));
    }
}
