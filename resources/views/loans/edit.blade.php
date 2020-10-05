@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Loan</div>

                <div class="card-body">
                    <form action="/loans/{{ $loan->id }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">Nick Name</label>
                          <div class="col-sm-10">
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Loan Nick Name"
                                   value="{{ $loan->name }}"
                            />
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="starting_balance" class="col-sm-2 col-form-label">Balance</label>
                          <div class="col-sm-4">
                            <input type="number"
                                   min="1" 
                                   step="any"                            
                                   name="starting_balance" 
                                   class="form-control @error('starting_balance') is-invalid @enderror" 
                                   placeholder="Current Balance"
                                   value="{{ $loan->current_balance }}"
                            />
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="interest_rate" class="col-sm-2 col-form-label">Rate</label>
                          <div class="col-sm-4">
                            <input type="number"
                                   min="1"
                                   step="any"
                                   name="interest_rate" 
                                   class="form-control @error('interest_rate') is-invalid @enderror" 
                                   placeholder="Interest Rate"
                                   value="{{ $loan->interest_rate }}"
                            />
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </form>                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection