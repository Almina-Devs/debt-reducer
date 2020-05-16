@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Loan</div>

                <div class="card-body">
                    <form action="/loans" method="POST">
                        @csrf
                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">Nick Name</label>
                          <div class="col-sm-10">
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Loan Nick Name"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="starting_balance" class="col-sm-2 col-form-label">Balance</label>
                          <div class="col-sm-4">
                            <input type="number" 
                                   name="starting_balance" 
                                   class="form-control @error('starting_balance') is-invalid @enderror" 
                                   placeholder="Initial Balance"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="interest_rate" class="col-sm-2 col-form-label">Rate</label>
                          <div class="col-sm-4">
                            <input type="number" 
                                   name="interest_rate" 
                                   class="form-control @error('interest_rate') is-invalid @enderror" 
                                   placeholder="Interest Rate"
                            >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="min_payment" class="col-sm-2 col-form-label">Minimum Payment</label>
                          <div class="col-sm-4">
                            <input type="number" 
                                   name="min_payment" 
                                   class="form-control @error('min_payment') is-invalid @enderror" 
                                   placeholder="Minimum Payment"
                            >
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add Loan</button>
                          </div>
                        </div>
                      </form>                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection