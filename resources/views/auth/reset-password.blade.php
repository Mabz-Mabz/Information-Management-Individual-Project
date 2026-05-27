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

<h1>Reset Password</h1>

{{-- Error Messages --}}
@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color: red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    {{-- Hidden fields passed from the reset link --}}
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <label for="password">New Password</label>
    <input
        type="password"
        id="password"
        name="password"
        required
        autofocus />

    <label for="password_confirmation">Confirm New Password</label>
    <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        required />

    <button type="submit">Reset Password</button>

</form>

@endsection