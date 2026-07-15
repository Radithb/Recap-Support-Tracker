@extends('layouts.app')

@section('page_title', 'Profil Instansi')
@section('page_subtitle', 'Recap Support Tracker')

@section('sidebar_menu')
    @if(Auth::user()->role === 'support')
        <a href="{{ route('support.dashboard') }}">
            <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> Beranda Support
        </a>
        <a href="{{ route('support.recap') }}">
            <span class="ic">📊</span> Rekapitulasi
        </a>
        <a href="{{ route('support.master-data.index') }}">
            <span class="ic">🗄️</span> Master Data
        </a>
    @else
        <a href="{{ route('pelapor.dashboard') }}">
            <span class="ic"><img src="{{ asset('analysis.png') }}" alt=""></span> Dashboard
        </a>
        <a href="{{ route('pelapor.riwayat') }}">
            <span class="ic"><img src="{{ asset('file.png') }}" alt=""></span> Riwayat Lengkap
        </a>
    @endif
@endsection

@section('content')
<div class="pelapor-panel">
    <div class="content-wrap fade-up" style="animation-delay: 0.1s;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ Auth::user()->role === 'support' ? route('support.dashboard') : route('pelapor.dashboard') }}" class="btn btn-ghost" style="padding: 8px 16px; border: 1px solid var(--line); background: white;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline-block; margin-right: 6px; vertical-align:-2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
        
        <div class="panel" style="padding: 30px; max-width: 100%;" id="instansi-panel">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom: 24px;">
                <div>
                    <h3 style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size: 24px;">🏢</span> Profil Instansi
                    </h3>
                    <p class="sub" style="margin-bottom:0;">Data INSTANSI · terhubung ke akun Anda</p>
                </div>
            </div>
            
            @if(session('success'))
                <div id="success-alert" class="alert-dismiss" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: 13.5px; font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: 18px; font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                </div>
            @endif

            <!-- VIEW MODE -->
            <div id="view-mode">
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Nama Instansi</label>
                    <h4 style="font-size: 16px; color: var(--ink); margin: 0;">{{ Auth::user()->instansi->nama_instansi ?? '-' }}</h4>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Alamat Lengkap</label>
                    <p style="color: var(--ink); line-height: 1.6; margin: 0; font-size: 14.5px;">{{ Auth::user()->instansi->alamat ?? '-' }}</p>
                </div>
                <div style="margin-bottom: 32px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Nomor Telepon</label>
                    <div class="mono" style="color: var(--ink); font-size: 14.5px;">{{ Auth::user()->instansi->no_telp ?? '-' }}</div>
                </div>
                
                <div style="border-top: 1px solid var(--line); padding-top: 20px;">
                    <button type="button" class="btn btn-ghost" onclick="toggleEditMode(true)" style="padding: 9px 18px;">
                        <span class="ic">✏️</span> Edit Data Instansi
                    </button>
                </div>
            </div>

            <!-- EDIT MODE -->
            <div id="edit-mode" style="display: none;">
                <form action="{{ route('profil.instansi.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="field">
                        <label>Nama Instansi</label>
                        <input type="text" value="{{ Auth::user()->instansi->nama_instansi ?? '-' }}" readonly style="background: var(--paper-sunken); color: var(--ink-soft); cursor: not-allowed;" title="Nama Instansi tidak dapat diubah">
                        <div class="helper">Nama instansi telah ditetapkan saat registrasi. Hubungi Support jika ingin mengubahnya.</div>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap instansi..." required>{{ Auth::user()->instansi->alamat ?? '' }}</textarea>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Nomor Telepon</label>
                        <input type="text" name="no_telp" value="{{ Auth::user()->instansi->no_telp ?? '' }}" placeholder="Contoh: 081234567890" required>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line);">
                        <button type="button" class="btn btn-ghost" onclick="toggleEditMode(false)" style="padding: 10px 20px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function toggleEditMode(showEdit) {
                document.getElementById('view-mode').style.display = showEdit ? 'none' : 'block';
                document.getElementById('edit-mode').style.display = showEdit ? 'block' : 'none';
            }
        </script>
        
    </div>
</div>
@endsection
