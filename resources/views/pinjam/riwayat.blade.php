@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Riwayat Peminjaman Buku</h4>

    @if($pinjaman->isEmpty())
        <div class="alert alert-info">Belum ada riwayat peminjaman.</div>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Kode Salinan</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pinjaman as $p)
                <tr>
                    <td>{{ $p->judul }}</td>
                    <td>{{ $p->kode_salinan }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->isoFormat('D MMM Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->isoFormat('D MMM Y') : '-' }}</td>
                    <td>
                        <span class="badge @if($p->status=='dikembalikan') bg-success
                                            @elseif($p->status=='terlambat')  bg-danger
                                            @else                              bg-warning text-dark @endif">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>Rp{{ number_format($p->denda_kerusakan,0,',','.') }}</td>
                    <td>
                        @if(in_array($p->status,['dipinjam','terlambat']))
                            <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalKembali{{ $p->id }}">
                                Kembalikan
                            </button>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled>Sudah&nbsp;Kembali</button>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="modalKembali{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('pinjam.kembali',$p->id) }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah buku <strong>{{ $p->judul }}</strong> mengalami kerusakan?</p>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Kerusakan</label>
                                    <select name="denda_kerusakan" class="form-select" required>
                                        <option value="0" selected>Tidak ada kerusakan</option>
                                        <option value="5000">Kecil &mdash; Rp5.000</option>
                                        <option value="10000">Sedang &mdash; Rp10.000</option>
                                        <option value="15000">Parah &mdash; Rp15.000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Kembalikan</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
