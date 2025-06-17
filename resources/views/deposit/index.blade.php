@extends('layouts.app')

@section('content')
    <h2>Riwayat Deposit</h2>

    <form action="{{ route('deposit.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Deposit</label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Contoh: 10000" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Deposit</button>
    </form>

    <h4>Riwayat Anda</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $item)
                <tr>
                    <td>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
