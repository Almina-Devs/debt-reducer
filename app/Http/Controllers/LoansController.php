<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $loans = Loan::where('user_id', Auth::user()->id)->get();

        $summary = [
            'total_begining_balance' => $loans->sum('starting_balance'),
            'total_current_balance' => $loans->sum('current_balance'),
            'average_rate' => $loans->avg('interest_rate'),
            'monthly_payment' => $loans->sum('min_payment')
        ];

        return view('loans.index', [ 'loans' => $loans, 'summary' => $summary ]);
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'starting_balance' => 'required|string',
            'interest_rate' => 'required',
            'min_payment' => 'required'
        ]);

        Loan::create([
            'name' => $request->input('name'),
            'starting_balance' => $request->input('starting_balance'),
            'current_balance' => $request->input('starting_balance'),
            'interest_rate' => $request->input('interest_rate'),
            'min_payment' => $request->input('min_payment'),
            'fixed_payment' => 0,
            'user_id' => Auth::user()->id
        ]);

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
            'interest_rate' => 'required',
            'min_payment' => 'required'
        ]);

        $loan = Loan::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->first();

        $loan->name = $request->input('name');
        $loan->starting_balance = $request->input('starting_balance');
        $loan->current_balance = $request->input('starting_balance');
        $loan->interest_rate = $request->input('interest_rate');
        $loan->min_payment = $request->input('min_payment');
        $loan->save();

        return redirect()->route('loans');

    }

    public function delete(Request $request, $id)
    {
        $loan = Loan::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->delete();

        return redirect()->route('loans');                    
    }
}
