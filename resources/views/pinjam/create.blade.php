@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px;">
    <h4 class="mb-3">Form Peminjaman Buku</h4>
    <form method="POST" action="{{ route('pinjam.proses') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Peminjam</label>
            <select name="id_peminjam" class="form-select">
                @foreach($peminjams as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <select name="id_buku" class="form-select">
                @foreach($bukus as $b)
                    <option value="{{ $b->id }}">{{ $b->judul }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Pinjam</button>
        <a href="{{ route('pinjam.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
