@extends('layouts.app')

@section('page_title', 'Master Data')
@section('page_subtitle', 'internal.ptskk.id')

@section('content')
<div class="pelapor-panel active">
    
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel-page-head" style="margin-bottom: 2.5rem;">
            <div>
                <div class="skel skel-page-head-eyebrow"></div>
                <div class="skel skel-page-head-title"></div>
                <div class="skel skel-panel-sub" style="margin-top: 0.5rem; width: 600px; height: 14px;"></div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start;">
            <div class="skel-panel" style="padding: 0; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="skel" style="width: 140px; height: 16px; border-radius: 4px; margin-bottom: 8px;"></div>
                        <div class="skel" style="width: 280px; height: 12px; border-radius: 4px;"></div>
                    </div>
                    <div class="skel" style="width: 80px; height: 32px; border-radius: 6px;"></div>
                </div>
                <div class="skel-table" style="margin: 0; border: none; padding: 0;">
                    <div class="skel-table-head" style="padding: 0.75rem 1.5rem;">
                        <div class="skel skel-table-head-cell" style="width:120px;"></div>
                        <div class="skel skel-table-head-cell" style="width:180px;"></div>
                        <div class="skel skel-table-head-cell" style="width:60px;"></div>
                    </div>
                    @for($i = 0; $i < 3; $i++)
                    <div class="skel-table-row" style="padding: 1rem 1.5rem;">
                        <div class="skel skel-table-cell" style="width:120px;"></div>
                        <div class="skel skel-table-cell" style="width:180px;"></div>
                        <div class="skel skel-table-cell" style="width:60px; border-radius: 100px;"></div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="skel-panel" style="padding: 0; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="skel" style="width: 140px; height: 16px; border-radius: 4px; margin-bottom: 8px;"></div>
                        <div class="skel" style="width: 280px; height: 12px; border-radius: 4px;"></div>
                    </div>
                    <div class="skel" style="width: 80px; height: 32px; border-radius: 6px;"></div>
                </div>
                <div class="skel-table" style="margin: 0; border: none; padding: 0;">
                    <div class="skel-table-head" style="padding: 0.75rem 1.5rem;">
                        <div class="skel skel-table-head-cell" style="width:120px;"></div>
                        <div class="skel skel-table-head-cell" style="flex:1;"></div>
                        <div class="skel skel-table-head-cell" style="width:60px;"></div>
                    </div>
                    @for($i = 0; $i < 3; $i++)
                    <div class="skel-table-row" style="padding: 1rem 1.5rem;">
                        <div class="skel skel-table-cell" style="width:120px;"></div>
                        <div class="skel skel-table-cell" style="flex:1;"></div>
                        <div class="skel skel-table-cell" style="width:60px; border-radius: 100px;"></div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="display: none;">
        {{-- Page Header --}}
        <div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom: 2.5rem;">
            <div>
                <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600;">{{ __('messages.d2_master_data') }}</p>
                <h1 style="margin: 0; font-size: 2rem; color: var(--ink);">{{ __('messages.kelola_master_data') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.5rem; max-width: 600px; line-height: 1.5;">{{ __('messages.referensi_dipakai') }}</p>
            </div>
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start;">
            <div class="glass-panel fade-up" style="animation-delay: 0.15s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">{{ __('messages.master_aplikasi') }}</h3>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">{{ __('messages.divalidasi_proses_1') }}</p>
                    </div>
                    <button type="button" onclick="openModal('modal-add-aplikasi')" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--line); border-radius: 6px; background: transparent; color: var(--ink); white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">+ {{ __('messages.tambah') }}</button>
                </div>
                <div style="max-height: 350px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: var(--paper-sunken); position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">{{ __('messages.nama_aplikasi') }}</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">{{ __('messages.deskripsi') }}</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: right; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">{{ __('messages.status') }}</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($aplikasis as $app)
                        <tr style="border-bottom: 1px solid var(--line);">
                            <td style="padding: 1rem 1.5rem; color: var(--ink); font-size: 0.9rem;">{{ $app->nama_aplikasi }}</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; max-width: 350px; line-height: 1.5;">
                                @if(strlen($app->deskripsi) > 45)
                                    <span id="desc-short-{{ $app->aplikasi_id }}">
                                        {{ Str::limit($app->deskripsi, 45) }}
                                        <a href="javascript:void(0)" onclick="toggleDesc({{ $app->aplikasi_id }})" style="color: var(--indigo); font-weight: 600; font-size: 0.8rem; text-decoration: none; margin-left: 4px;">{{ __('messages.lebih_banyak') }}</a>
                                    </span>
                                    <span id="desc-full-{{ $app->aplikasi_id }}" style="display: none;">
                                        {{ $app->deskripsi }}
                                        <a href="javascript:void(0)" onclick="toggleDesc({{ $app->aplikasi_id }})" style="color: var(--indigo); font-weight: 600; font-size: 0.8rem; text-decoration: none; margin-left: 4px;">{{ __('messages.lebih_sedikit') }}</a>
                                    </span>
                                @else
                                    {{ $app->deskripsi }}
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $app->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="glass-panel fade-up" style="animation-delay: 0.2s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">{{ __('messages.master_kategori') }}</h3>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">{{ __('messages.dipakai_proses_3') }}</p>
                    </div>
                    <button type="button" onclick="openModal('modal-add-kategori')" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--line); border-radius: 6px; background: transparent; color: var(--ink); white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">+ {{ __('messages.tambah') }}</button>
                </div>
                <div style="max-height: 350px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: var(--paper-sunken); position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">{{ __('messages.nama_kategori') }}</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: right; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">{{ __('messages.jumlah_tiket') }}</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($kategoris as $kategori)
                        <tr style="border-bottom: 1px solid var(--line);">
                            <td style="padding: 1rem 1.5rem; color: var(--ink); font-size: 0.9rem;">{{ $kategori->nama_kategori }}</td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $kategori->tickets->count() ?? 0 }} {{ __('messages.tiket') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Aplikasi -->
    <div class="overlay" id="modal-add-aplikasi">
        <div class="modal w-sm">
            <div class="modal-head">
                <div>
                    <h3>Tambah {{ __('messages.master_aplikasi') }}</h3>
                    <p>{{ __('messages.aplikasi_muncul_pelapor') }}</p>
                </div>
                <button type="button" class="modal-x" onclick="closeModal('modal-add-aplikasi')">✕</button>
            </div>
            <form action="{{ route('support.master-data.aplikasi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label>Nama Aplikasi <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="nama_aplikasi" required placeholder="{{ __('messages.contoh_sakti') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('messages.deskripsi_singkat') }}</label>
                        <textarea name="deskripsi" placeholder="{{ __('messages.penjelasan_singkat') }}" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-foot">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-aplikasi')">{{ __('messages.batal') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.simpan_aplikasi') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="overlay" id="modal-add-kategori">
        <div class="modal w-sm">
            <div class="modal-head">
                <div>
                    <h3>{{ __('messages.tambah_master_kategori') }}</h3>
                    <p>Kategori untuk mengklasifikasikan {{ __('messages.tiket') }}</p>
                </div>
                <button type="button" class="modal-x" onclick="closeModal('modal-add-kategori')">✕</button>
            </div>
            <form action="{{ route('support.master-data.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label>Nama Kategori <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="nama_kategori" required placeholder="{{ __('messages.contoh_bug') }}">
                    </div>
                </div>
                <div class="modal-foot">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-kategori')">{{ __('messages.batal') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.simpan_kategori') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDesc(id) {
        let shortDesc = document.getElementById('desc-short-' + id);
        let fullDesc = document.getElementById('desc-full-' + id);
        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'inline';
            fullDesc.style.display = 'none';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'inline';
        }
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
@endsection
