@extends('layouts.app')
@section('content')
<div class="container" style="max-width:520px">
    <h4 class="mb-3">Register</h4>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        @error('register') <div class="alert alert-danger">{{ $message }}</div> @enderror

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Daftar</button>
        <a href="{{ route('login') }}" class="d-block text-center mt-2">Sudah punya akun? Login</a>
    </form>
</div>
@endsection
