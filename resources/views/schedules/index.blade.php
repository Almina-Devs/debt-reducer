@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Details
                    </div>
                    <div class="card-body">
                        <div>
                            Total # of payments : {{ $details["totalNumberPayments"] }}
                        </div>
                        <div>
                            Payoff Date : {{ $details["payoffMonth"] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                <div class="card-header">{{ $loan->name }} 
                    | Starting Balance: ${{ number_format($loan->starting_balance, 2, '.', ',') }} 
                    | Rate: {{ $loan->interest_rate }} 
                    | <a href="/loans">
                          <i class="fas fa-long-arrow-alt-left"></i>
                      </a> 
                </div>
    
                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Month</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($amortizationSchedule as $row)
                                <tr>
                                    <td>{{ $row["payment_date"] }}</td>
                                    <td>${{ $row["payment"] }}</td>
                                    <td>${{ $row["balance"] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection