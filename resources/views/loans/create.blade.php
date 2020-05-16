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
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Nick Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Loan Nick Name">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                          <div class="col-sm-10">
                            <input type="number" name="starting_balance" class="form-control @error('starting_balance') is-invalid @enderror" placeholder="Initial Balance">
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