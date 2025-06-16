@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Form Peminjaman Buku</h4>
    <div class="card">
        <div class="card-body">
            <p><strong>Judul : </strong> {{ $buku->judul }}</p>
            <p><strong>Kode Salinan : </strong> {{ $salinan->kode_salinan }}</p>
            <p><strong>Deposit : </strong>Rp. {{ number_format($peminjam->deposit, 0, ',', '.') }}</p>
            @if ($peminjam->status_blacklist == 1)
                <div class="alert alert-danger">
                    Anda tidak dapat meminjam buku karena masuk daftar blacklist.
                </div>
            @else
                <form method="POST" action="{{ route('pinjam.store') }}">
                    @csrf
                    <input type="hidden" name="id_salinan" value="{{ $salinan->id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjam" class="form-label fw-bold">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" required
                                value="{{ now()->toDateString() }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kembali" class="form-label fw-bold">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required
                                value="{{ now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biaya Sewa : </label>
                        <span>Rp. {{ number_format($buku->biaya_sewa, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="btn btn-success">Konfirmasi Pinjam</button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
