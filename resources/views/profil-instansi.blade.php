@extends('layouts.app')

@section('page_title', 'Profil Koperasi')
@section('page_subtitle', 'Recap Support Tracker')


@section('content')
<div class="pelapor-panel">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="width: 180px; height: 36px; border-radius: 8px; margin-bottom: 24px;"></div>
        <div class="skel-panel" style="padding: 30px; max-width: 100%;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom: 24px;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <div class="skel" style="width: 28px; height: 28px; border-radius: 6px;"></div>
                        <div class="skel" style="width: 180px; height: 24px; border-radius: 4px;"></div>
                    </div>
                    <div class="skel" style="width: 280px; height: 14px; border-radius: 4px;"></div>
                </div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 240px; height: 18px; border-radius: 4px;"></div>
            </div>
            <div style="margin-bottom: 24px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 400px; height: 16px; border-radius: 4px; margin-bottom: 4px;"></div>
                <div class="skel" style="width: 320px; height: 16px; border-radius: 4px;"></div>
            </div>
            <div style="margin-bottom: 32px;">
                <div class="skel" style="width: 100px; height: 12px; margin-bottom:6px; border-radius: 4px;"></div>
                <div class="skel" style="width: 180px; height: 16px; border-radius: 4px;"></div>
            </div>
            
            <div style="border-top: 1px solid var(--line); padding-top: 20px;">
                <div class="skel" style="width: 160px; height: 36px; border-radius: 8px;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="display: none;">
        
        <div class="fade-up" style="margin-bottom: 24px; animation-delay: 0.1s;">
            <a href="{{ Auth::user()->role === 'support' ? route('support.dashboard') : route('pelapor.dashboard') }}" class="btn btn-ghost" style="padding: 8px 16px; border: 1px solid var(--line); background: var(--paper-raised);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline-block; margin-right: 6px; vertical-align:-2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
        
        <div class="panel fade-up" style="padding: 30px; max-width: 100%; animation-delay: 0.15s;" id="instansi-panel">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom: 24px;">
                <div>
                    <h3 style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size: calc(24px * var(--text-scale, 1));"><img src="{{ asset('company.png') }}" alt="Company" style="width: 28px; height: 28px; object-fit: contain; vertical-align: middle;"></span> Profil Koperasi
                    </h3>
                    <p class="sub" style="margin-bottom:0;">Data KOPERASI · terhubung ke akun Anda</p>
                </div>
            </div>
            
            @if(session('success'))
                <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.2s; display: flex; justify-content: space-between; align-items: center; padding: 12px 14px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(13.5px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                </div>
            @endif

            <!-- VIEW MODE -->
            <div id="view-mode" class="fade-up" style="animation-delay: 0.25s;">
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Nama Koperasi</label>
                    <h4 style="font-size: calc(16px * var(--text-scale, 1)); color: var(--ink); margin: 0;">{{ Auth::user()->instansi->nama_instansi ?? '-' }}</h4>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Alamat Lengkap</label>
                    <p style="color: var(--ink); line-height: 1.6; margin: 0; font-size: calc(14.5px * var(--text-scale, 1));">{{ Auth::user()->instansi->alamat ?? '-' }}</p>
                </div>
                <div style="margin-bottom: 32px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:6px;">Nomor Telepon</label>
                    <div class="mono" style="color: var(--ink); font-size: calc(14.5px * var(--text-scale, 1));">{{ Auth::user()->instansi->no_telp ?? '-' }}</div>
                </div>

                <div style="margin-bottom: 32px;">
                    <label style="display:block; font-size: calc(12px * var(--text-scale, 1)); font-weight:600; color:var(--ink-soft); margin-bottom:8px;">Aplikasi yang Digunakan</label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        @if(Auth::user()->instansi && Auth::user()->instansi->aplikasis->count() > 0)
                            @foreach(Auth::user()->instansi->aplikasis as $app)
                                <span style="background: #e0f2fe; color: #0284c7; padding: 6px 12px; border-radius: 20px; font-size: calc(13px * var(--text-scale, 1)); font-weight: 600;">{{ $app->nama_aplikasi }}</span>
                            @endforeach
                        @else
                            <span style="color: var(--text-muted); font-size: calc(14px * var(--text-scale, 1));">Belum ada aplikasi yang dipilih.</span>
                        @endif
                    </div>
                </div>
                
                <div style="border-top: 1px solid var(--line); padding-top: 20px;">
                    <button type="button" class="btn btn-ghost" onclick="toggleEditMode(true)" style="padding: 9px 18px;">
                        <span class="ic"><img src="{{ asset('edit.png') }}" alt="Edit" style="width: 14px; height: 14px; object-fit: contain; vertical-align: middle; margin-right: 4px; margin-top: -2px;"></span> Edit Data Koperasi
                    </button>
                </div>
            </div>

            <!-- EDIT MODE -->
            <div id="edit-mode" style="display: none;">
                <form action="{{ route('profil.instansi.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="field">
                        <label>Nama Koperasi</label>
                        <input type="text" value="{{ Auth::user()->instansi->nama_instansi ?? '-' }}" readonly style="background: var(--paper-sunken); color: var(--ink-soft); cursor: not-allowed;" title="Nama Koperasi tidak dapat diubah">
                        <div class="helper">Nama koperasi telah ditetapkan saat registrasi. Hubungi Support jika ingin mengubahnya.</div>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap koperasi..." required>{{ Auth::user()->instansi->alamat ?? '' }}</textarea>
                    </div>
                    
                    <div class="field" style="margin-top: 18px;">
                        <label>Nomor Telepon</label>
                        <input type="text" name="no_telp" value="{{ Auth::user()->instansi->no_telp ?? '' }}" placeholder="Contoh: 081234567890" required>
                    </div>

                    <div class="field" style="margin-top: 18px;">
                        <label>Aplikasi yang Digunakan</label>
                        <div style="background: var(--paper-sunken); padding: 16px; border-radius: 8px; border: 1px solid var(--line); display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                            @php
                                $selectedAplikasi = Auth::user()->instansi ? Auth::user()->instansi->aplikasis->pluck('aplikasi_id')->toArray() : [];
                            @endphp
                            @forelse($aplikasis ?? [] as $app)
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; color: var(--ink);">
                                    <input type="checkbox" name="aplikasis[]" value="{{ $app->aplikasi_id }}" {{ in_array($app->aplikasi_id, $selectedAplikasi) ? 'checked' : '' }} style="width: 16px; height: 16px; cursor: pointer;">
                                    {{ $app->nama_aplikasi }}
                                </label>
                            @empty
                                <div style="color: var(--text-muted); font-size: calc(13px * var(--text-scale, 1));">Belum ada master aplikasi tersedia.</div>
                            @endforelse
                        </div>
                        <div class="helper">Pilih aplikasi yang digunakan oleh Koperasi Anda.</div>
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

            document.addEventListener('DOMContentLoaded', function () {
                const skeleton = document.getElementById('skeleton-loading');
                const content  = document.getElementById('actual-content');
                if(skeleton && content) {
                    setTimeout(function () {
                        skeleton.style.display = 'none';
                        content.style.display = 'block';
                        content.classList.add('loaded');
                    }, 800);
                }
            });
        </script>
        
    </div>
</div>
@endsection
