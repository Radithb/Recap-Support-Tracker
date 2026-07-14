@extends('layouts.app')

@section('content')
<div class="grid-2">
    <!-- Form Buat Tiket -->
    <div class="glass-panel">
        <h2>Buat Tiket Baru</h2>
        <p style="margin-bottom: 1.5rem;">Laporkan kendala pada aplikasi Anda.</p>
        <form action="{{ route('pelapor.tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Aplikasi Bermasalah</label>
                <select name="aplikasi_id" required>
                    <option value="">-- Pilih Aplikasi --</option>
                    @foreach($aplikasis as $app)
                        <option value="{{ $app->aplikasi_id }}">{{ $app->nama_aplikasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi Permasalahan</label>
                <textarea name="permasalahan" rows="5" required placeholder="Jelaskan detail kendala secara lengkap..."></textarea>
            </div>
            <div class="form-group">
                <label>Lampiran / Bukti Error (Opsional, Maks 5MB)</label>
                <input type="file" name="lampiran" accept="image/*,.pdf,.zip" style="background: transparent; border: none; padding: 0;">
            </div>
            <button type="submit" class="btn btn-primary">Kirim Tiket</button>
        </form>
    </div>

    <!-- Riwayat Tiket -->
    <div class="glass-panel">
        <h2>Riwayat Tiket Saya</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Aplikasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $t)
                        <tr>
                            <td><strong>{{ $t->ticket_id }}</strong></td>
                            <td>{{ $t->aplikasi->nama_aplikasi }}</td>
                            <td><span class="badge badge-{{ strtolower($t->status) }}">{{ $t->status }}</span></td>
                            <td>{{ $t->tanggal_input->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Belum ada tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
