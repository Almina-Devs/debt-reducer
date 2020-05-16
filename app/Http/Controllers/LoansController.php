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
        ]);

        Loan::create([
            'name' => $request->input('name'),
            'starting_balance' => $request->input('starting_balance'),
            'current_balance' => $request->input('current_balance'),
            'interest_rate' => $request->input('interest_rate'),
            'min_payment' => $request->input('interest_rate'),
        ]);
    }
}
