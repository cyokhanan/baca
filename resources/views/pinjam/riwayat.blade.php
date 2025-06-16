@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Riwayat Peminjaman Buku</h4>

    @if($pinjaman->isEmpty())
        <div class="alert alert-info">Belum ada buku yang sedang dipinjam.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Kode Salinan</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pinjaman as $p)
                    <tr>
                        <td>{{ $p->judul }}</td>
                        <td>{{ $p->kode_salinan }}</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>{{ $p->tanggal_jatuh_tempo }}</td>
                        <td>
                            <button class="btn btn-warning">Kembalikan</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
