@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Buku</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr class="">
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Biaya Sewa</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bukus as $buku)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->kategori->nama}}</td>
                        <td>Rp {{ number_format($buku->biaya_sewa, 0, ',', '.') }}</td>
                        <td>
                            @for ($i = 0; $i < $buku->rating_bintang; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenulis{{ $buku->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('modals')
@foreach($bukus as $buku)
        <div class="modal fade" id="modalPenulis{{ $buku->id }}" tabindex="-1" aria-labelledby="modalTitle{{ $buku->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-semibold" id="modalTitle{{ $buku->id }}">
                            Detail Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Judul:</strong> {{ $buku->judul }}</p>
                        <p><strong>Jumlah Salinan:</strong> {{ $buku->salinanTersedia->count() }}</p>
                        <p class="mb-1"><strong>Penulis:</strong></p>
                        <ul class="list-group list-group-flush">
                            @forelse($buku->penulis as $penulis)
                                <li class="list-group-item">
                                    <i class="bi bi-person-fill me-1"></i> {{ $penulis->nama }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted fst-italic">Belum ada penulis</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="modal-footer">
                        @if($buku->salinanTersedia->count() > 0)
                            <a href="{{ route('pinjam.create', ['buku' => $buku->id]) }}" class="btn btn-primary">
                                Pinjam
                            </a>
                        @else
                            <button class="btn btn-outline-secondary" disabled>
                                Tidak Tersedia
                            </button>
                        @endif
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endpush
@endsection
