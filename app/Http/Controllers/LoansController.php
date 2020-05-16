<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoansController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::where('user_id', Auth::user()->id)->get();
        return view('loans.index', [ 'loans' => $loans ]);
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
}
