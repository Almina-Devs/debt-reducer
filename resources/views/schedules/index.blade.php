@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">
                <div class="card-header">{{ $loan->name }} | Starting Balance: ${{ number_format($loan->starting_balance, 2, '.', ',') }} | Rate: {{ $loan->interest_rate }} </div>
    
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
                                            <td>{{ $row["month"] }}</td>
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