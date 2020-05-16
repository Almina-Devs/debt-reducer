@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Loans</div>

                <div class="card-body">
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Initial Balance</th>
                                <th scope="col">Current Balance</th>
                                <th scope="col">Interest Rate</th>
                                <th scope="col">Min. Payment</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->name }}</td>
                                        <td>${{ number_format($loan->starting_balance, 2, '.', ',') }}</td>
                                        <td>${{ number_format($loan->current_balance, 2, '.', ',') }}</td>
                                        <td>{{ number_format($loan->interest_rate, 2, '.', ',') }}%</td>
                                        <td>${{ number_format($loan->min_payment, 2, '.', ',') }}</td>
                                        <td><i class="fas fa-pencil-alt"></i></td>
                                        <td><i class="fas fa-trash-alt"></i></td>
                                    </tr>
                                @endforeach

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>${{ number_format($summary['total_balance'], 2, '.', ',') }}</td>
                                        <td>{{ number_format($summary['average_rate'], 2, '.', ',') }}%</td>
                                        <td>${{ number_format($summary['monthly_payment'], 2, '.', ',') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                            </tbody>
                        </table>
                    </div>

                    <div style="padding-top: 20px">
                        <a href="/loans/create">
                            <button type="button" class="btn btn-primary">New Loan</button>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection