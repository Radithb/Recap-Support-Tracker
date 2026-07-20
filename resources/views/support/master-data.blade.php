@extends('layouts.app')

@section('page_title', 'Master Data')
@section('page_subtitle', 'internal.ptskk.id')

@section('content')
<div class="pelapor-panel active">
    
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="skeleton-wrap" id="skeleton-loading" style="max-width: 1050px; margin: 0 auto; padding: 0 3rem;">
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
            
            <div class="skel-panel" style="padding: 0; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; overflow: hidden; grid-column: 1 / -1;">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="skel" style="width: 140px; height: 16px; border-radius: 4px; margin-bottom: 8px;"></div>
                        <div class="skel" style="width: 280px; height: 12px; border-radius: 4px;"></div>
                    </div>
                </div>
                <div class="skel" style="height: 200px; width: 100%;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="display: none; max-width: 1050px; margin: 0 auto; padding: 0 3rem;">
        {{-- Page Header --}}
        <div class="page-head fade-up" style="animation-delay: 0.1s; margin-bottom: 2.5rem;">
            <div>
                <p class="eyebrow" style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600;">{{ __('messages.d2_master_data') }}</p>
                <h1 style="margin: 0; font-size: 2rem; color: var(--ink);">{{ __('messages.kelola_master_data') }}</h1>
                <p style="color: var(--text-muted); margin-top: 0.5rem; max-width: 600px; line-height: 1.5;">{{ __('messages.referensi_dipakai') }}</p>
            </div>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <!-- ROW 1: Aplikasi & Kategori -->
            <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start;">
                <div class="glass-panel fade-up" style="animation-delay: 0.15s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                        <div>
                            <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">{{ __('messages.master_aplikasi') }}</h3>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">{{ __('messages.divalidasi_proses_1') }}</p>
                        </div>
                        <button type="button" onclick="openModal('modal-add-aplikasi')" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--line); border-radius: 6px; background: transparent; color: var(--ink); white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">+ {{ __('messages.tambah') }}</button>
                    </div>
                    <div style="max-height: 400px; overflow-y: auto;">
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
                                    {{ $app->is_active ? __('messages.aktif') : __('messages.nonaktif') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

                <div class="glass-panel fade-up" style="animation-delay: 0.2s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                        <div>
                            <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">{{ __('messages.master_kategori') }}</h3>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">{{ __('messages.dipakai_proses_3') }}</p>
                        </div>
                        <button type="button" onclick="openModal('modal-add-kategori')" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--line); border-radius: 6px; background: transparent; color: var(--ink); white-space: nowrap; display: inline-flex; align-items: center; gap: 4px;">+ {{ __('messages.tambah') }}</button>
                    </div>
                    <div style="max-height: 400px; overflow: auto;">
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

        <div style="margin-bottom: 2.5rem;">
            <!-- ROW 2: Koperasi & PIC -->
            <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start;">
                <!-- Master Data Instansi/Koperasi -->
                <div class="glass-panel fade-up" style="animation-delay: 0.25s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                        <div>
                            <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">Master Data Nama Koperasi</h3>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">Daftar koperasi yang pernah dilaporkan</p>
                        </div>
                    </div>
                    <div style="max-height: 400px; overflow: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: var(--paper-sunken); position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Nama Koperasi</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Kontak</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: center; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Total Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instansis as $ins)
                            <tr style="border-bottom: 1px solid var(--line);">
                                <td style="padding: 1rem 1.5rem; color: var(--ink); font-size: 0.9rem; font-weight: 500; vertical-align: top;">
                                    {{ $ins->nama_instansi }}
                                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal; margin-top: 4px;">{{ Str::limit($ins->alamat ?? 'Alamat belum diatur', 45) }}</div>
                                </td>
                                <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; vertical-align: top;">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        {{ $ins->no_telp ?? '-' }}
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center; vertical-align: top;">
                                    <span style="background: #e0f2fe; color: #0284c7; padding: 0.3rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">
                                        {{ $ins->users_count }} Akun
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

                <!-- Master Data PIC Tim Support -->
                <div class="glass-panel fade-up" style="animation-delay: 0.3s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                        <div>
                            <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">Master Data PIC Tim Support</h3>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">Daftar user tim support aplikasi</p>
                        </div>
                    </div>
                    <div style="max-height: 400px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: var(--paper-sunken); position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Profil Support</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supportPics as $pic)
                            <tr style="border-bottom: 1px solid var(--line);">
                                <td style="padding: 1rem 1.5rem; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if($pic->avatar)
                                            <img src="{{ Storage::url($pic->avatar) }}" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 1px solid var(--line);">
                                        @else
                                            @php
                                                $words = explode(' ', $pic->nama);
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : substr($words[0], 1, 1)));
                                            @endphp
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; border: 1px solid #fecaca;">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; color: var(--ink); font-size: 0.9rem;">{{ $pic->nama }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">{{ $pic->spesialisasi ?? 'Tim Support Umum' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.9rem; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        {{ $pic->email }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ROW 3: Master Data Status Tiket (Full Width Container) -->
        <div style="margin-bottom: 2.5rem;">
            <div class="glass-panel fade-up" style="animation-delay: 0.35s; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 0; overflow: hidden; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid var(--line);">
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; color: var(--ink);">Master Data Status Tiket</h3>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: var(--text-muted);">Referensi status laporan tiket (Read Only)</p>
                    </div>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: var(--paper-sunken);">
                            <tr>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Value Sistem</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Label Visual</th>
                                <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.7rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Deskripsi Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $st)
                            <tr style="border-bottom: 1px solid var(--line);">
                                <td style="padding: 1.25rem 1.5rem; color: var(--ink); font-size: 0.95rem; font-family: monospace; background: var(--paper-sunken); font-weight: 600; width: 180px; vertical-align: top;">
                                    {{ $st->name }}
                                </td>
                                <td style="padding: 1.25rem 1.5rem; width: 220px; vertical-align: top;">
                                    @php
                                        $statusVal = $st->value;
                                        $statusLower = strtolower($statusVal);
                                        
                                        if ($statusLower === 'done') {
                                            $bg = '#dcfce7'; $color = '#16a34a';
                                        } elseif ($statusLower === 'pending') {
                                            $bg = '#fef9c3'; $color = '#ca8a04';
                                        } elseif ($statusLower === 'proses' || $statusLower === 'on progress' || $statusLower === 'open') {
                                            $bg = '#fee2e2'; $color = '#dc2626';
                                        } else {
                                            $bg = 'var(--paper-sunken)'; $color = 'var(--text-muted)';
                                        }
                                    @endphp
                                    <span style="background: {{ $bg }}; color: {{ $color }}; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                        <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $color }};"></span> {{ $statusVal }}
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.95rem; line-height: 1.5; vertical-align: top;">
                                    @if($st->name === 'OPEN')
                                        <strong style="color: var(--ink);">Status Awal:</strong> Tiket laporan yang baru saja dibuat oleh pelapor dan belum mulai dianalisis atau ditangani oleh tim teknis.
                                    @elseif($st->name === 'PROSES')
                                        <strong style="color: var(--ink);">Dalam Pengerjaan:</strong> Tiket sedang dalam tahapan analisis, *troubleshooting*, atau penanganan aktif oleh tim support.
                                    @elseif($st->name === 'PENDING')
                                        <strong style="color: var(--ink);">Ditangguhkan Sementara:</strong> Pengerjaan tiket tertunda atau dihentikan sementara waktu karena membutuhkan konfirmasi tambahan, data tambahan, atau aksi dari pihak pelapor sebelum bisa dilanjutkan.
                                    @elseif($st->name === 'DONE')
                                        <strong style="color: var(--ink);">Selesai:</strong> Kendala pada tiket sudah terselesaikan dengan tuntas dan penyelesaiannya telah disetujui. Tiket akan dikategorikan sebagai rekam jejak.
                                    @endif
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
                    <h3>{{ __('messages.tambah_master_aplikasi') }}</h3>
                    <p>{{ __('messages.aplikasi_muncul_pelapor') }}</p>
                </div>
                <button type="button" class="modal-x" onclick="closeModal('modal-add-aplikasi')">✕</button>
            </div>
            <form action="{{ route('support.master-data.aplikasi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label>{{ __('messages.nama_aplikasi') }} <span style="color:var(--danger)">*</span></label>
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
                    <p>{{ __('messages.kategori_klasifikasi') }}</p>
                </div>
                <button type="button" class="modal-x" onclick="closeModal('modal-add-kategori')">✕</button>
            </div>
            <form action="{{ route('support.master-data.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label>{{ __('messages.nama_kategori') }} <span style="color:var(--danger)">*</span></label>
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
