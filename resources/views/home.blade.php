@extends('template.main')
@section('title')
Home
@endsection
@section('content')
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif

<div>
    <h2>
        Car Dealership
    </h2>
</div>


<div>

    <div class="container mt-5">
        <div class="row">

            <div class="col-md-3">
                <a href="{{ route('users.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('cars.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Cars</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('customers.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Customers</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('mechanics.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Mechanics</h5>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <br>
        <div class="row">

            <div class="col-md-3">
                <a href="{{ route('salespersons.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Sales Person</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('service-records.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Service Record</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('service-tickets.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Service Ticket</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('parts.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Parts</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-3">

            </div>

            <div class="col-md-3">
                <a href="{{ route('invoices.index') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Invoice</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('logs') }}" class="text-decoration-none">
                    <div class="card text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title">Audit Logs</h5>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>



</div>
@endsection