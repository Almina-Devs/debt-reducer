<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Schedule;
use App\Services\Calculator;

class SchedulesController extends Controller
{

    private $calc;

    public function __construct()
    {
        $this->middleware('auth');
        $this->calc = new Calculator();

    }
    
    public function index(Request $request)
    {
        $schedules = Schedule::where('user_id', Auth::user()->id)->get();
        
        $ams = $this->calc->amortizationSchdule(1000, 0.12);

        return view('schedules.index', 
            [ 
                'schedules' => $schedules,
                'amortizationSchedule' => $ams
            ]
        );
    }

    public function show(Request $request, $loanId)
    {
        $loan = Loan::where('id', $loanId)->first();
        $ams = $this->calc->amortizationSchdule($id, $loan->starting_balance, ($loan->interest_rate / 100));
        $details = [
            "totalNumberPayments" => count($ams),
            "payoffMonth" => $ams[count($ams)-1]["month"]
        ];

        return view('schedules.index', 
            [
                'loan' => $loan,
                'amortizationSchedule' => $ams,
                'details' => $details
            ]
        );
    }

    public function showPaydownSchedule(Request $request)
    {

        $loans = Loan::where('user_id', Auth::user()->id)->get();

        $this->calc->paydownSchedule($loans);

        return view('schedules.paydown',
            [
                'paydownSchedule' => []
            ]
        );

    }
    
}
