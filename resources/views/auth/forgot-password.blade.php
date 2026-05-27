@extends('template.main')
@section('title')
Forgot Password
@endsection
@section('content')
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif

<h1>Forgot Password</h1>

{{-- Success Message --}}
@if (session('status'))
<p style="color: green;">{{ session('status') }}</p>
@endif

{{-- Error Message --}}
@if ($errors->any())
<p style="color: red;">{{ $errors->first('email') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <label for="email">Email Address</label>
    <input
        type="email"
        id="email"
        name="email"
        value="{{ old('email') }}"
        required
        autofocus />

    <button type="submit">Send Reset Link</button>

</form>

<a href="{{ route('login') }}">Back to Login</a>

@endsection