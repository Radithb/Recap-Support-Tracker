@extends('layouts.app')

@section('content')
<div style="padding: 32px; max-width: 1000px; width: 100%; box-sizing: border-box; margin: 0 auto;">
<div class="header">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1>{{ __('messages.history_letter_document') }}</h1>
            <p class="subtitle">Tiket #{{ $ticket->ticket_id }} &mdash; {{ $ticket->aplikasi->nama_aplikasi ?? '-' }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            {{ __('messages.kembali') }}
        </a>
    </div>
</div>

<div class="card" style="margin-top: 24px; padding: 32px; background: #f8fafc;">
    
    <div style="position: relative; padding-left: 20px; border-left: 2px solid #e2e8f0; margin-left: 10px;">
        
        <!-- STEP 1: Pelaporan Awal -->
        <div style="margin-bottom: 32px; position: relative;">
            <div style="position: absolute; left: -29px; top: 0; width: 16px; height: 16px; border-radius: 50%; background: #3b82f6; border: 4px solid #fff;"></div>
            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <div>
                        <strong style="font-size: 1.1rem; color: var(--ink);">1. Laporan Tiket & Lampiran Bukti</strong>
                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Dari: {{ $ticket->pelapor->nama ?? 'Pelapor' }} ({{ $ticket->pelapor->instansi->nama_instansi ?? '-' }})</div>
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-align: right;">
                        {{ $ticket->tanggal_input->format('d M Y, H:i') }}<br>
                        {{ $ticket->tanggal_input->diffForHumans() }}
                    </div>
                </div>
                
                <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.6; white-space: pre-wrap; background: var(--paper-raised); padding: 12px; border-radius: 8px; margin-bottom: 16px;">{{ $ticket->permasalahan }}</div>

                @if($ticket->lampiran)
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Dokumen Pendukung:</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @php $lampirans = is_array($ticket->lampiran) ? $ticket->lampiran : [$ticket->lampiran]; @endphp
                        @foreach($lampirans as $lamp)
                            @php $ext = strtolower(pathinfo($lamp, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <button type="button" onclick="openUniversalPreview('{{ Storage::url($lamp) }}', '{{ $ext }}', '{{ addslashes(basename($lamp)) }}')" style="border: 1px solid var(--line); border-radius: 8px; overflow: hidden; background: white; cursor: pointer; padding: 0; width: fit-content; text-align: center; display: flex; flex-direction: column;">
                                    <img src="{{ Storage::url($lamp) }}" alt="Lampiran" style="height: 100px; width: auto; object-fit: cover;">
                                    <span style="font-size: 0.7rem; padding: 4px; border-top: 1px solid var(--line); color: var(--text-muted); background: #f8fafc; display: block;">{{ Str::limit(basename($lamp), 15) }}</span>
                                </button>
                            @else
                                <button type="button" onclick="openUniversalPreview('{{ Storage::url($lamp) }}', '{{ $ext }}', '{{ addslashes(basename($lamp)) }}')" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--line); background: white;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                    Lihat {{ strtoupper($ext) }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
                @else
                <div style="font-size: 0.85rem; color: var(--text-muted); font-style: italic;">Tidak ada lampiran.</div>
                @endif
            </div>
        </div>

        <!-- STEP 2: Surat Laporan Template -->
        @if($ticket->template_laporan)
        <div style="margin-bottom: 32px; position: relative;">
            <div style="position: absolute; left: -29px; top: 0; width: 16px; height: 16px; border-radius: 50%; background: #8b5cf6; border: 4px solid #fff;"></div>
            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <div>
                        <strong style="font-size: 1.1rem; color: var(--ink);">2. Draft Surat Izin Akses Login Aplikasi</strong>
                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Dibuat Otomatis oleh Sistem</div>
                    </div>
                </div>
                
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">Sistem telah menghasilkan draf surat otomatis berdasarkan form yang diajukan.</p>

                <button type="button" onclick="openUniversalPreview('{{ Storage::url($ticket->template_laporan) }}', '{{ pathinfo($ticket->template_laporan, PATHINFO_EXTENSION) }}', '{{ addslashes(basename($ticket->template_laporan)) }}')" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid #8b5cf6; color: #6d28d9; background: #f5f3ff; padding: 8px 16px; border-radius: 6px; font-weight: 600;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Lihat {{ str_replace(['_', '-'], ' ', pathinfo($ticket->template_laporan, PATHINFO_FILENAME)) }} ({{ strtoupper(pathinfo($ticket->template_laporan, PATHINFO_EXTENSION)) }})
                </button>
            </div>
        </div>
        @endif

        <!-- STEP 3: Surat Balasan Pelapor -->
        @if($ticket->surat_balasan)
        <div style="margin-bottom: 32px; position: relative;">
            <div style="position: absolute; left: -29px; top: 0; width: 16px; height: 16px; border-radius: 50%; background: #10b981; border: 4px solid #fff;"></div>
            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <div>
                        <strong style="font-size: 1.1rem; color: var(--ink);">3. Surat Balasan / Dokumen Legalitas</strong>
                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Diunggah oleh: {{ $ticket->pelapor->nama ?? 'Pelapor' }}</div>
                    </div>
                </div>
                
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">Dokumen surat resmi yang telah ditandatangani dan diunggah kembali oleh instansi.</p>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @php
                        $balasanFiles = json_decode($ticket->surat_balasan, true);
                        if (!is_array($balasanFiles)) {
                            $balasanFiles = [$ticket->surat_balasan];
                        }
                    @endphp
                    @foreach($balasanFiles as $index => $file)
                        <button type="button" onclick="openUniversalPreview('{{ Storage::url($file) }}', '{{ pathinfo($file, PATHINFO_EXTENSION) }}', '{{ addslashes(basename($file)) }}')" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid #10b981; color: #047857; background: #ecfdf5; padding: 8px 16px; border-radius: 6px; font-weight: 600; width: fit-content;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            Lihat Dokumen Balasan {{ count($balasanFiles) > 1 ? '#' . ($index + 1) : '' }} ({{ strtoupper(pathinfo($file, PATHINFO_EXTENSION)) }})
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- STEP 4: Respons Support -->
        @if($ticket->status === \App\Enums\TicketStatus::DONE || $ticket->penyelesaian || $ticket->lampiran_support)
        <div style="margin-bottom: 32px; position: relative;">
            <div style="position: absolute; left: -29px; top: 0; width: 16px; height: 16px; border-radius: 50%; background: #f59e0b; border: 4px solid #fff;"></div>
            <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid var(--line); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <div>
                        <strong style="font-size: 1.1rem; color: var(--ink);">4. Respons Akhir / Penanganan Support</strong>
                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Ditangani oleh: {{ $ticket->picSupport->nama ?? 'Tim Support' }}</div>
                    </div>
                    @if($ticket->tanggal_penyelesaian)
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-align: right;">
                        {{ $ticket->tanggal_penyelesaian->format('d M Y, H:i') }}<br>
                        {{ $ticket->tanggal_penyelesaian->diffForHumans() }}
                    </div>
                    @endif
                </div>

                @if($ticket->penyelesaian)
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Tindakan Penyelesaian:</div>
                    <div style="font-size: 0.95rem; color: #065f46; line-height: 1.6; white-space: pre-wrap; background: #ecfdf5; padding: 12px; border-radius: 8px; border: 1px solid #a7f3d0;">{{ $ticket->penyelesaian }}</div>
                </div>
                @endif

                @if($ticket->pencegahan)
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Tindakan Pencegahan:</div>
                    <div style="font-size: 0.95rem; color: #92400e; line-height: 1.6; white-space: pre-wrap; background: #fffbeb; padding: 12px; border-radius: 8px; border: 1px solid #fde68a;">{{ $ticket->pencegahan }}</div>
                </div>
                @endif

                @if($ticket->lampiran_support)
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Lampiran Respons Dokumen:</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @php $lampiranSupports = is_array($ticket->lampiran_support) ? $ticket->lampiran_support : [$ticket->lampiran_support]; @endphp
                        @foreach($lampiranSupports as $lamp)
                            @php $ext = strtolower(pathinfo($lamp, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <button type="button" onclick="openUniversalPreview('{{ Storage::url($lamp) }}', '{{ $ext }}', '{{ addslashes(basename($lamp)) }}')" style="border: 1px solid #f59e0b; border-radius: 8px; overflow: hidden; background: white; cursor: pointer; padding: 0; width: fit-content; text-align: center; display: flex; flex-direction: column;">
                                    <img src="{{ Storage::url($lamp) }}" alt="Lampiran" style="height: 100px; width: auto; object-fit: cover;">
                                    <span style="font-size: 0.7rem; padding: 4px; border-top: 1px solid #f59e0b; color: #b45309; background: #fef3c7; display: block;">{{ Str::limit(basename($lamp), 15) }}</span>
                                </button>
                            @else
                                <button type="button" onclick="openUniversalPreview('{{ Storage::url($lamp) }}', '{{ $ext }}', '{{ addslashes(basename($lamp)) }}')" class="btn btn-ghost" style="display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid #f59e0b; background: #fef3c7; color: #b45309;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                    Lihat {{ strtoupper($ext) }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
        
    </div>

</div>

</div>
@endsection
