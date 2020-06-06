<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\BuildAmortizationSchedule;
use App\Models\Loan;
use App\Services\Calculator;


class LoansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->calc = new Calculator();
    }

    public function index(Request $request)
    {
        $loans = Loan::where('user_id', Auth::user()->id)->get();

        $summary = [
            'total_begining_balance' => $loans->sum('starting_balance'),
            'total_current_balance' => $loans->sum('current_balance'),
            'average_rate' => $loans->avg('interest_rate'),
            'monthly_payment' => $loans->sum('min_payment'),
            'total_payments' => $this->calc->getTotalMonthlyPayments()
        ];

        return view('loans.index', [ 'loans' => $loans, 'summary' => $summary ]);
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'starting_balance' => 'required|string',
            'interest_rate' => 'required',
            'due_date' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('loans/create')
                        ->withErrors($validator)
                        ->withInput();
        }        

        $minPayment = $this->calc->getMinimumPayment(
            $request->input('starting_balance'),
            ($request->input('interest_rate') / 100)
        );

        $dueDate = Carbon::parse($request->input('due_date'));

        $loan =Loan::create([
            'name' => $request->input('name'),
            'starting_balance' => $request->input('starting_balance'),
            'current_balance' => $request->input('starting_balance'),
            'interest_rate' => $request->input('interest_rate'),
            'min_payment' => $minPayment,
            'fixed_payment' => 0,
            'due_date' => $dueDate,
            'user_id' => Auth::user()->id
        ]);

        event(new BuildAmortizationSchedule($loan->id));

        return redirect()->route('loans');
    }

    public function edit(Request $request, $id)
    {
        $loan = Loan::where('user_id', Auth::user()->id)
                    ->where('id', $id)   
                    ->first();
        
        return view('loans.edit', [ 'loan' => $loan ]);                     
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'starting_balance' => 'required|string',
            'interest_rate' => 'required'
        ]);

        $loan = Loan::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->first();

        $loan->name = $request->input('name');
        $loan->starting_balance = $request->input('starting_balance');
        $loan->current_balance = $request->input('starting_balance');
        $loan->interest_rate = $request->input('interest_rate');
        $loan->schedule_ready = 0;
        $loan->save();

        event(new BuildAmortizationSchedule($id));

        return redirect()->route('loans')->with('status', $loan->name . ' updated!');

    }

    public function delete(Request $request, $id)
    {
        $loan = Loan::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->first();

        $name = $loan->name;                    

        $loan->delete();

        return redirect()->route('loans')->with('status', $name . ' deleted!');                    
    }
}
