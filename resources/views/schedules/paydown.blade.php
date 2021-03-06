@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card">

                    <div class="card-header">
                        Paydown
                    </div>
                    <div class="card-body">
                        <div>
                            Total # of payments : ...
                        </div>
                        <div>
                            Payoff Date : ...
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <p>Paydown</p>
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
                                @foreach ($paydownSchedule as $row)
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

@endsection