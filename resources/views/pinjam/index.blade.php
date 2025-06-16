@extends('layouts.app')

@section('content')
    <h2>Form Peminjaman</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    @if(session()->has('peminjam_id'))
        <form action="{{ route('pinjam.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="buku" class="form-label">Cari Buku</label>
                <input class="form-control" list="daftarBuku" id="buku" name="id_buku" placeholder="Ketik judul buku...">
                <datalist id="daftarBuku">
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                    @endforeach
                </datalist>
            </div>
            <button type="submit" class="btn btn-primary">Pinjam Buku</button>
        </form>
    @else
        <div class="alert alert-warning">
            Anda harus <a href="{{ route('login') }}">login</a> untuk meminjam buku.
        </div>
    @endif
@endsection
