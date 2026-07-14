@extends('layouts.app')

@section('content')
<div class="grid-2">
    <div class="glass-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="margin: 0;">Master Aplikasi</h2>
            <button class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">+ Tambah</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aplikasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aplikasis as $app)
                <tr>
                    <td>{{ $app->aplikasi_id }}</td>
                    <td>
                        <strong>{{ $app->nama_aplikasi }}</strong><br>
                        <small style="color: var(--text-muted);">{{ $app->deskripsi }}</small>
                    </td>
                    <td>
                        <span class="badge {{ $app->is_active ? 'badge-proses' : 'badge-done' }}">
                            {{ $app->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="glass-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="margin: 0;">Master Kategori</h2>
            <button class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">+ Tambah</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->kategori_id }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
