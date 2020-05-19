<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Schedule;

class SchedulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $schedules = Schedule::where('user_id', Auth::user()->id)->get();

        return view('schedules.index', [ 'schedules' => $schedules ]);
    }

}
