@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                                <th scope="col"></th>
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
                                        <td>
                                            @if($loan->schedule_ready === 1)
                                                <a href="/schedules/{{ $loan->id }}">
                                                    <i class="far fa-calendar-alt"></i>
                                                </a>
                                            @endif
                                        </td>                                        
                                        <td>
                                            <a href="/loans/edit/{{ $loan->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/loans/delete/{{ $loan->id }}" onclick="return confirm('Are you sure?')" >
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                    <tr>
                                        <td>Totals:</td>
                                        <td>${{ number_format($summary['total_begining_balance'], 2, '.', ',') }}</td>
                                        <td>${{ number_format($summary['total_current_balance'], 2, '.', ',') }}</td>
                                        <td>{{ number_format($summary['average_rate'], 2, '.', ',') }}%</td>
                                        <td>${{ number_format($summary['monthly_payment'], 2, '.', ',') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                            </tbody>
                        </table>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>

                    <div style="padding-top: 20px">
                        <a href="/loans/create">
                            <button type="button" class="btn btn-primary">New Loan</button>
                        </a>

                        <a href="/schedules/paydown">
                            <button type="button" class="btn btn-primary">See Paydown Schedule</button>
                        </a>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
