@extends('layouts.app')

@section('content')
<div class="glass-panel" style="margin-bottom: 2rem;">
    <h2>Ticket Board (Antrean)</h2>
    <form method="GET" style="display: flex; gap: 1rem; margin-top: 1rem;">
        <select name="status" style="width: 200px;">
            <option value="">Semua Status</option>
            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
            <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
        </select>
        <input type="text" name="search" placeholder="Cari ID/Deskripsi..." value="{{ request('search') }}" style="width: 300px;">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

@foreach($tickets as $t)
<div class="glass-panel" style="margin-bottom: 1.5rem; display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <h3>{{ $t->ticket_id }} - {{ $t->aplikasi->nama_aplikasi }}</h3>
            <span class="badge badge-{{ strtolower($t->status) }}">{{ $t->status }}</span>
        </div>
        <p><strong>Pelapor:</strong> {{ $t->pelapor->nama }} ({{ $t->pelapor->instansi->nama_instansi ?? 'N/A' }})</p>
        <p><strong>Waktu Masuk:</strong> {{ $t->tanggal_input->format('d M Y H:i') }}</p>
        
        <div style="margin-top: 1rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <p><strong>Permasalahan:</strong><br/>{{ $t->permasalahan }}</p>
        </div>
        @if($t->lampiran)
            <div style="margin-top: 1rem;">
                <a href="{{ asset('storage/' . $t->lampiran) }}" target="_blank" style="color: var(--primary);">Lihat Lampiran</a>
            </div>
        @endif
        
        @if($t->penyelesaian)
            <div style="margin-top: 1rem; padding: 1rem; border-left: 4px solid var(--success); background: rgba(16, 185, 129, 0.05);">
                <p><strong>Penyelesaian:</strong> {{ $t->penyelesaian }}</p>
                @if($t->pencegahan)<p><strong>Pencegahan:</strong> {{ $t->pencegahan }}</p>@endif
            </div>
        @endif
    </div>

    <div style="border-left: 1px solid var(--border); padding-left: 2rem;">
        <h4>Update Status</h4>
        <form action="{{ route('support.tickets.update', $t) }}" method="POST" style="margin-top: 1rem;">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Status Tiket</label>
                <select name="status" onchange="toggleDoneFields(this, '{{ $t->ticket_id }}')">
                    <option value="Open" {{ $t->status == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="Pending" {{ $t->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Proses" {{ $t->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Done" {{ $t->status == 'Done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>
            
            <div id="done-fields-{{ $t->ticket_id }}" style="display: {{ $t->status == 'Done' ? 'block' : 'none' }};">
                <div class="form-group">
                    <label>Kategori Resolusi</label>
                    <select name="kategori_id">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->kategori_id }}" {{ $t->kategori_id == $k->kategori_id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Solusi / Penyelesaian</label>
                    <textarea name="penyelesaian" rows="3">{{ $t->penyelesaian }}</textarea>
                </div>
                <div class="form-group">
                    <label>Tindakan Pencegahan</label>
                    <textarea name="pencegahan" rows="2">{{ $t->pencegahan }}</textarea>
                </div>
                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_faq" value="1" {{ $t->is_faq ? 'checked' : '' }} style="width: auto;">
                    <label style="margin:0;">Jadikan FAQ / Knowledge Base</label>
                </div>
            </div>

            <div class="form-group">
                <label>Link Eskalasi Eksternal (Jira/Trello)</label>
                <input type="text" name="link_ticket" value="{{ $t->link_ticket }}">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Update Tiket</button>
        </form>
    </div>
</div>
@endforeach

<div style="margin-top: 2rem;">
    {{ $tickets->links('pagination::bootstrap-5') }}
</div>

<script>
function toggleDoneFields(selectElement, ticketId) {
    const fields = document.getElementById('done-fields-' + ticketId);
    if (selectElement.value === 'Done') {
        fields.style.display = 'block';
    } else {
        fields.style.display = 'none';
    }
}
</script>
@endsection
