@extends('layouts.app')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'SAKTI Desk')


@section('content')
<div class="pelapor-panel active">
    {{-- SKELETON LOADING STATE --}}
    <div class="skeleton-wrap" id="skeleton-loading">
        <div class="skel" style="height: 100px; width: 100%; margin-bottom: 22px;"></div>
        <div class="skel" style="height: 120px; width: 100%; margin-bottom: 28px;"></div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px;">
            <div class="skel" style="height: 100px;"></div>
            <div class="skel" style="height: 100px;"></div>
            <div class="skel" style="height: 100px;"></div>
        </div>
        <div>
            <div class="skel" style="height: 30px; width: 40%; margin-bottom: 14px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
            <div class="skel" style="height: 80px; width: 100%; margin-bottom: 12px;"></div>
        </div>
    </div>

    {{-- ACTUAL CONTENT --}}
    <div class="content-wrap" id="actual-content" style="display:none;">
        @if(session('success'))
            <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: var(--sage-soft); color: var(--sage); border-radius: 8px; margin-bottom: 24px; font-size: calc(14px * var(--text-scale, 1)); font-weight: 600; border: 1px solid rgba(46, 125, 82, 0.2); transition: opacity 0.6s ease, transform 0.6s ease;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('success-alert').style.display='none'" style="background: none; border: none; color: var(--sage); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
            </div>
        @endif

        <div class="welcome-banner fade-up" style="animation-delay: 0.1s;">
            <div>
                <h2>{{ __('messages.halo') }}, {{ Auth::user()->nama ?? 'User' }}!</h2>
                <p>{{ __('messages.selamat_datang') }}</p>
            </div>
        </div>

        <!-- TAB NAVIGATION -->
        <div class="dashboard-tabs fade-up" style="display: flex; gap: 8px; border-bottom: 2px solid var(--line); margin-bottom: 24px; animation-delay: 0.12s;">
            <button type="button" id="tab-btn-tickets" class="dash-tab-btn active" onclick="switchDashTab('tickets', this)" style="padding: 10px 18px; font-weight: 600; font-size: 14px; border: none; background: none; color: var(--brand-primary); border-bottom: 2px solid var(--brand-primary); margin-bottom: -2px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <img src="{{ asset('ticket-laporan.svg') }}" alt="" style="width: 18px; height: 18px; object-fit: contain; vertical-align: middle;"> {{ __('messages.tiket_dan_laporan_saya') }}
            </button>
            <button type="button" id="tab-btn-faq" class="dash-tab-btn" onclick="switchDashTab('faq', this)" style="padding: 10px 18px; font-weight: 500; font-size: 14px; border: none; background: none; color: var(--ink-soft); border-bottom: 2px solid transparent; margin-bottom: -2px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <span style="-webkit-mask-image: url('{{ asset('question.png') }}'); mask-image: url('{{ asset('question.png') }}'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center; background-color: currentColor; width: 18px; height: 18px; display: inline-block; vertical-align: middle;"></span> {{ __('messages.pertanyaan_sering_diajukan') }}
            </button>
        </div>

        <!-- PANE 1: TIKET & LAPORAN -->
        <div id="tab-pane-tickets" class="dash-tab-pane">
            <div class="cta-band fade-up" style="animation-delay: 0.15s;">
                <div>
                    <h2>{{ __('messages.ada_kendala') }}</h2>
                    <p>{{ __('messages.laporkan_sekali') }}</p>
                </div>
                <button class="btn btn-amber" onclick="openModal('modal-create')">＋ {{ __('messages.buat_laporan_baru') }}</button>
            </div>

            <!-- Statistik Sederhana -->
            <div class="stat-row fade-up" style="animation-delay: 0.2s;">
                <div class="stat-card"><div class="n" style="color:var(--clay)">{{ $totalOpen }}</div><div class="l">{{ __('messages.open_proses') }}</div></div>
                <div class="stat-card"><div class="n" style="color:#B8923F">{{ $totalPending }}</div><div class="l">{{ __('messages.pending_butuh_info') }}</div></div>
                <div class="stat-card"><div class="n" style="color:var(--sage)">{{ $totalDone }}</div><div class="l">{{ __('messages.selesai_total') }}</div></div>
            </div>

            <div class="fade-up" style="animation-delay: 0.25s;">
                <div>
                    <div class="page-head" style="margin-bottom:14px;">
                        <div><h1 style="font-size: calc(22px * var(--text-scale, 1));">{{ __('messages.riwayat_laporan_anda') }}</h1></div>
                    </div>
                    
                    <div class="ticket-list">
                        @forelse($tickets as $t)
                        <div class="ticket-card fade-up" onclick="openModal('modal-ticket-{{ $t->ticket_id }}')" style="cursor:pointer; animation-delay: {{ 0.3 + ($loop->index * 0.08) }}s;">
                            <div class="tid">{{ $t->ticket_id }}</div>
                            <div class="main">
                                <h3>{{ $t->permasalahan }}</h3>
                                <p>{{ $t->penyelesaian ?? __('messages.belum_ada_catatan') }}</p>
                            </div>
                            <div class="meta">{{ $t->aplikasi->nama_aplikasi }} &middot; {{ $t->tanggal_input->format('d M Y') }} &middot; {{ $t->tanggal_input->format('H:i') }}</div>
                            
                            @php
                                $statusClass = match($t->status) {
                                    \App\Enums\TicketStatus::OPEN, \App\Enums\TicketStatus::PROSES => 'status-open',
                                    \App\Enums\TicketStatus::PENDING => 'status-pending',
                                    \App\Enums\TicketStatus::DONE => 'status-done',
                                    default => ''
                                };
                            @endphp
                            <span class="status {{ $statusClass }}">{{ $t->status->value ?? $t->status }}</span>
                        </div>
                        @empty
                        <div class="ticket-card" style="justify-content:center; padding:30px;">
                            <p class="eyebrow">{{ __('messages.belum_ada_tiket_laporan') }}</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- PANE 2: PUSAT SOLUSI / FAQ -->
        <div id="tab-pane-faq" class="dash-tab-pane" style="display: none;">
            <div style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <div style="margin-bottom: 20px;">
                    <h3 style="margin: 0; font-family: var(--font-display); font-size: 18px; font-weight: 700; color: var(--ink);">
                        {{ __('messages.pertanyaan_sering_diajukan') }}
                    </h3>
                    <p style="color: var(--ink-soft); font-size: 13px; margin: 4px 0 0 0;">
                        {{ __('messages.faq_relevan_desc') }}
                    </p>
                </div>

                <!-- Filter & Form Pencarian FAQ -->
                <form method="GET" action="{{ route('pelapor.dashboard') }}" style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;">
                    <input type="hidden" name="tab" value="faq">
                    <div style="flex: 1; min-width: 240px; position: relative;">
                        <span style="-webkit-mask-image: url('{{ asset('magnifying-glass.png') }}'); mask-image: url('{{ asset('magnifying-glass.png') }}'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center; background-color: currentColor; width: 14px; height: 14px; display: inline-block; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--ink-soft);"></span>
                        <input type="text" name="faq_search" value="{{ request('faq_search') }}" placeholder="{{ __('messages.cari_faq_placeholder') }}" style="width: 100%; padding: 10px 12px 10px 36px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 14px; box-sizing: border-box;">
                    </div>
                    
                    <select name="faq_kategori_id" onchange="this.form.submit()" style="padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 14px; font-weight: 500; cursor: pointer;">
                        <option value="">{{ __('messages.semua_kategori') }}</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->kategori_id }}" {{ request('faq_kategori_id') == $kat->kategori_id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-secondary" style="padding: 10px 18px; font-size: 14px; border-radius: 8px;">
                        {{ __('messages.cari') }}
                    </button>

                    @if(request('faq_search') || request('faq_kategori_id'))
                        <a href="{{ route('pelapor.dashboard', ['tab' => 'faq']) }}" class="btn btn-ghost" style="padding: 10px 14px; font-size: 14px; border-radius: 8px; color: var(--ink-soft); text-decoration: none;">
                            {{ __('messages.reset') }}
                        </a>
                    @endif
                </form>

                <!-- Daftar FAQ Accordion -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse($faqs as $faq)
                        <div class="faq-item" style="border: 1px solid var(--line); border-radius: 10px; background: var(--paper); overflow: hidden; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='scale(1.01)'" onmouseout="this.style.transform='scale(1)'">
                            <button type="button" onclick="openModal('modal-faq-{{ $faq->faq_id }}')" style="width: 100%; text-align: left; background: none; border: none; padding: 14px 18px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 14px; color: var(--ink);">
                                <div style="display: flex; align-items: center; gap: 10px; flex: 1;">
                                    <span style="background: var(--brand-primary-soft); color: var(--brand-primary); padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                        {{ $faq->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                    <span style="font-weight: 600; font-size: 14px; line-height: 1.4;">
                                        {{ $faq->pertanyaan }}
                                    </span>
                                </div>
                                <span style="font-size: 16px; color: var(--ink-soft);">
                                    →
                                </span>
                            </button>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 30px 16px; border: 1.5px dashed var(--line); border-radius: 10px; color: var(--ink-soft);">
                            <div style="-webkit-mask-image: url('{{ asset('magnifying-glass.png') }}'); mask-image: url('{{ asset('magnifying-glass.png') }}'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center; background-color: currentColor; width: 28px; height: 28px; display: inline-block; margin-bottom: 6px;"></div>
                            <div style="font-weight: 600; font-size: 14px; color: var(--ink);">{{ __('messages.belum_ada_faq_public') }}</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Tickets -->
@foreach($tickets as $t)
<div class="overlay" id="modal-ticket-{{ $t->ticket_id }}">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>{{ __('messages.detail_laporan') }}</h3><p>{{ $t->ticket_id }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-ticket-{{ $t->ticket_id }}'); event.stopPropagation();">✕</button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">{{ __('messages.aplikasi') }}</div>
                    <div style="font-size: 0.95rem; color: var(--ink); font-weight: 500;">{{ $t->aplikasi->nama_aplikasi }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">{{ __('messages.kategori') }}</div>
                    <div style="font-size: 0.95rem; color: var(--ink); font-weight: 500;">{{ $t->kategori->nama_kategori ?? '-' }}</div>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.permasalahan') }}</div>
                <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.5; white-space: pre-wrap; background: var(--paper-raised); padding: 12px; border-radius: 8px; border: 1px solid var(--line);">{{ $t->permasalahan }}</div>
            </div>

            @if($t->lampiran)
            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.lampiran_bukti') }}</div>
                @php $ext = strtolower(pathinfo($t->lampiran, PATHINFO_EXTENSION)); @endphp
                @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank">
                        <img src="{{ Storage::url($t->lampiran) }}" alt="Lampiran" style="max-width: 100%; max-height: 140px; border-radius: 8px; border: 1px solid var(--line); display: block; object-fit: cover;">
                    </a>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ __('messages.klik_gambar') }}</div>
                @elseif($ext === 'mp4')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        <span>🎥</span> {{ __('messages.lihat_video') }}
                    </a>
                @elseif($ext === 'pdf')
                    <a href="{{ Storage::url($t->lampiran) }}" target="_blank" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 6px; border: 1.5px solid var(--line); text-decoration: none;">
                        <span>📄</span> {{ __('messages.unduh_pdf') }}
                    </a>
                @endif
            </div>
            @endif

            @if($t->lampiran_support)
            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Lampiran Respons Support</div>
                @php $extSupp = strtolower(pathinfo($t->lampiran_support, PATHINFO_EXTENSION)); @endphp
                @if(in_array($extSupp, ['jpg', 'jpeg', 'png']))
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank">
                        <img src="{{ Storage::url($t->lampiran_support) }}" alt="Lampiran Support" style="max-width: 100%; max-height: 140px; border-radius: 8px; border: 1px solid var(--line); display: block; object-fit: cover;">
                    </a>
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ __('messages.klik_gambar') }}</div>
                @elseif($extSupp === 'mp4')
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        <span>🎥</span> {{ __('messages.lihat_video') }}
                    </a>
                @elseif($extSupp === 'pdf')
                    <a href="{{ Storage::url($t->lampiran_support) }}" target="_blank" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 6px; border: 1.5px solid var(--line); text-decoration: none;">
                        <span>📄</span> {{ __('messages.unduh_pdf') }}
                    </a>
                @endif
            </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.penyelesaian_support') }}</div>
                    @if($t->penyelesaian)
                        <div style="font-size: 0.95rem; color: #166534; line-height: 1.5; white-space: pre-wrap; background: #f0fdf4; padding: 12px; border-radius: 8px; border: 1px solid #bbf7d0;">{{ $t->penyelesaian }}</div>
                    @else
                        <div style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.5; white-space: pre-wrap; background: var(--paper-raised); padding: 12px; border-radius: 8px; border: 1px dashed var(--line);">{{ __('messages.belum_ada_catatan') }}</div>
                    @endif
                </div>
                @if($t->pencegahan)
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.tindakan_pencegahan') }}</div>
                    <div style="font-size: 0.95rem; color: #854d0e; line-height: 1.5; white-space: pre-wrap; background: #fefce8; padding: 12px; border-radius: 8px; border: 1px solid #fef08a;">{{ $t->pencegahan }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modals for FAQs -->
@foreach($faqs as $faq)
<div class="overlay" id="modal-faq-{{ $faq->faq_id }}">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>FAQ Detail</h3><p>{{ $faq->kategori->nama_kategori ?? 'Umum' }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-faq-{{ $faq->faq_id }}'); event.stopPropagation();">✕</button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <div style="margin-bottom: 16px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.pertanyaan') }}</div>
                <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.5; font-weight: 500;">{{ $faq->pertanyaan }}</div>
            </div>
            <div style="margin-bottom: 8px;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">{{ __('messages.jawaban') }}</div>
                <div style="font-size: 0.95rem; color: var(--ink-soft); line-height: 1.6; white-space: pre-wrap; background: var(--paper-raised); padding: 16px; border-radius: 8px; border: 1px solid var(--line);">{!! nl2br(e($faq->jawaban)) !!}</div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Create -->
<div class="overlay" id="modal-create">
    <div class="modal w-sm">
        <div class="modal-head">
            <div><h3>{{ __('messages.buat_laporan_baru') }}</h3><p>{{ __('messages.jelaskan_kendala') }}</p></div>
            <button type="button" class="modal-x" onclick="closeModal('modal-create')">✕</button>
        </div>
        <form action="{{ route('pelapor.tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>{{ __('messages.aplikasi_bermasalah') }}</label>
                    <select name="aplikasi_id" required>
                        <option value="">{{ __('messages.pilih_aplikasi') }}</option>
                        @foreach($aplikasis as $app)
                            <option value="{{ $app->aplikasi_id }}" {{ old('aplikasi_id') == $app->aplikasi_id ? 'selected' : '' }}>{{ $app->nama_aplikasi }}</option>
                        @endforeach
                    </select>
                    @error('aplikasi_id') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>{{ __('messages.deskripsi_kendala') }}</label>
                    <textarea name="permasalahan" id="permasalahan_input" required placeholder="{{ __('messages.tuliskan_detail') }}">{{ old('permasalahan') }}</textarea>
                    @error('permasalahan') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    
                    <!-- Smart Auto-Suggest FAQ Box -->
                    <div id="faq-suggest-box" style="display: none; margin-top: 10px; padding: 12px; border: 1px solid var(--line); border-radius: 8px; background: var(--paper-sunken);">
                        <div style="font-size: 12px; font-weight: 700; color: var(--brand-primary); margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="display: flex; align-items: center; gap: 6px;">💡 {{ __('messages.solusi_cepat') }}</span>
                            <button type="button" style="background: none; border: none; font-size: 11px; color: var(--brand-primary); cursor: pointer; font-weight: 500; padding: 0;" onclick="closeModal('modal-create'); switchDashTab('faq', document.getElementById('tab-btn-faq'));">{{ __('messages.lihat_semua_faq') }}</button>
                        </div>
                        <div id="faq-suggest-list" style="display: flex; flex-direction: column; gap: 8px;"></div>
                    </div>
                </div>
                <div class="field" style="margin-top: 14px;">
                    <label>{{ __('messages.upload_lampiran_opsional') }}</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input type="file" id="lampiran_input" name="lampiran" accept=".jpg,.jpeg,.png,.mp4,.pdf" style="flex: 1; width:100%; font-size: calc(13px * var(--text-scale, 1)); font-family:var(--font-body); padding:8px; border:1.5px dashed var(--line); border-radius:8px; background:var(--paper); cursor:pointer;" onchange="document.getElementById('clear_lampiran_btn').style.display = this.value ? 'inline-block' : 'none';">
                        <button type="button" id="clear_lampiran_btn" style="display: none; padding: 8px 12px; background: #fee2e2; color: #ef4444; border: 1px solid #f87171; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500;" onclick="document.getElementById('lampiran_input').value = ''; this.style.display = 'none';">{{ __('messages.hapus_lampiran') }}</button>
                    </div>
                    <div class="helper">{{ __('messages.format_lampiran') }}</div>
                    @error('lampiran') <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-create')">{{ __('messages.batal') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.kirim_laporan') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchDashTab(tabName, btn) {
    document.querySelectorAll('.dash-tab-btn').forEach(b => {
        b.style.color = 'var(--ink-soft)';
        b.style.fontWeight = '500';
        b.style.borderBottomColor = 'transparent';
        b.classList.remove('active');
    });
    document.querySelectorAll('.dash-tab-pane').forEach(p => {
        p.style.display = 'none';
    });

    if (btn) {
        btn.style.color = 'var(--brand-primary)';
        btn.style.fontWeight = '600';
        btn.style.borderBottomColor = 'var(--brand-primary)';
        btn.classList.add('active');
    }

    const pane = document.getElementById('tab-pane-' + tabName);
    if (pane) pane.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function () {
    const skeleton = document.getElementById('skeleton-loading');
    const content  = document.getElementById('actual-content');
    
    setTimeout(function () {
        if(skeleton) skeleton.style.display = 'none';
        if(content) content.style.display = 'block';
    }, 1200);

    @if(request('tab') === 'faq' || request('faq_search') || request('faq_kategori_id'))
        const faqTabBtn = document.getElementById('tab-btn-faq');
        if (faqTabBtn) switchDashTab('faq', faqTabBtn);
    @endif

    @if($errors->any())
        openModal('modal-create');
    @endif

        // Smart Auto-Suggest FAQ Script
        const permasalahanInput = document.getElementById('permasalahan_input');
        const suggestBox = document.getElementById('faq-suggest-box');
        const suggestList = document.getElementById('faq-suggest-list');
        let searchDebounce = null;

        if (permasalahanInput && suggestBox && suggestList) {
            permasalahanInput.addEventListener('input', function () {
                const query = this.value.trim();
                clearTimeout(searchDebounce);

                if (query.length < 3) {
                    suggestBox.style.display = 'none';
                    suggestList.innerHTML = '';
                    return;
                }

                searchDebounce = setTimeout(function () {
                    fetch(`{{ route('pelapor.faq.search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(faqs => {
                            if (faqs && faqs.length > 0) {
                                suggestList.innerHTML = faqs.map(faq => `
                                    <div style="border: 1px solid var(--line); border-radius: 6px; padding: 10px; background: var(--paper); font-size: 13px;">
                                        <div style="font-weight: 600; color: var(--ink); display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 4px;">
                                            <span><span style="-webkit-mask-image: url('{{ asset('question.png') }}'); mask-image: url('{{ asset('question.png') }}'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center; background-color: currentColor; width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></span>${faq.pertanyaan}</span>
                                            <span style="font-size: 10px; background: var(--brand-primary-soft); color: var(--brand-primary); padding: 2px 6px; border-radius: 4px; font-weight: 600; white-space: nowrap;">${faq.kategori ? faq.kategori.nama_kategori : 'Public'}</span>
                                        </div>
                                        <div style="font-size: 12px; color: var(--ink-soft); line-height: 1.4; white-space: pre-wrap;">${faq.jawaban}</div>
                                    </div>
                                `).join('');
                                suggestBox.style.display = 'block';
                            } else {
                                suggestBox.style.display = 'none';
                                suggestList.innerHTML = '';
                            }
                        })
                        .catch(() => {
                            suggestBox.style.display = 'none';
                        });
                }, 300);
            });
        }
    });
</script>
@endsection
