@extends('layouts.app')
@section('content')
<div class="container" style="max-width:420px">
    <h4 class="mb-3">Login</h4>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        @error('login') <div class="alert alert-danger">{{ $message }}</div> @enderror

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
        <a href="{{ route('register') }}" class="d-block text-center mt-2">Register</a>
    </form>
</div>
@endsection
