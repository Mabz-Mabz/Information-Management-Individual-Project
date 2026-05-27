@extends('template.main')
@section('title')
Login
@endsection
@section('content')
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif


<div>
    <h2>Form</h2>
    <form method="POST" action="{{route('user.submit')}}">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="John Doe">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>

        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword">
            </div>
        </div>

        <div class="col text-center">
            <button type="submit" class="btn btn-secondary">Submit</button>
        </div>

        <div>
            <a href="{{ route('password.request') }}">
                <button type="button">Forgot Password?</button>
            </a>
        </div>
    </form>
</div>

@endsection