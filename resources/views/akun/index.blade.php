@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Profil Pengguna</h4>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $peminjam->nama }}</p>
            <p><strong>Email:</strong> {{ $peminjam->email }}</p>
            <p><strong>Alamat:</strong> {{ $peminjam->alamat ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $peminjam->telepon ?? '-' }}</p>
            <p><strong>Deposit:</strong> Rp. {{ number_format($peminjam->deposit, 0, ',', '.') }}</p>
            <p><strong>Status Blacklist:</strong> 
                {{ $peminjam->status_blacklist == 1 ? 'Ya' : 'Tidak' }}
            </p>
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
