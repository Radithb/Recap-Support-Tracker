@extends('layouts.app')

@section('content')
<div class="login-wrap">
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SKELETON LOADING STATE                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="skeleton-loading" style="width: 100%;">
        <div class="login-split-layout">
            <!-- Left Column Skeleton -->
            <div class="login-split-left">
                <div class="brand">
                    <div class="skel" style="width: 38px; height: 38px; border-radius: 8px; opacity: 0.2;"></div>
                    <div class="brand-text">
                        <div class="skel" style="width: 250px; height: 16px; margin-bottom: 6px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 200px; height: 10px; opacity: 0.2; border-radius: 4px;"></div>
                    </div>
                </div>
                
                <div style="margin: auto 0;">
                    <div class="eyebrow" style="display: flex; align-items: center; margin-bottom: 12px;">
                        <div class="skel" style="width: 180px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                    </div>
                    
                    <!-- H1 Skeleton (3 lines) -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 24px;">
                        <div class="skel" style="width: 95%; max-width: 480px; height: 26px; opacity: 0.2; border-radius: 6px;"></div>
                        <div class="skel" style="width: 90%; max-width: 480px; height: 26px; opacity: 0.2; border-radius: 6px;"></div>
                        <div class="skel" style="width: 50%; max-width: 480px; height: 26px; opacity: 0.2; border-radius: 6px;"></div>
                    </div>
                    
                    <!-- Paragraph Skeleton (8 lines) -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="skel" style="width: 98%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 95%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 92%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 96%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 94%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 97%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 85%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                        <div class="skel" style="width: 60%; max-width: 480px; height: 12px; opacity: 0.2; border-radius: 4px;"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column Skeleton -->
            <div class="login-split-right">
                <div class="skel" style="width: 320px; height: 16px; margin: 0 auto 24px auto; opacity: 0.1; border-radius: 4px;"></div>
                
                <div class="login-box" style="margin: 0 auto; max-width: 460px; width: 100%;">
                    <div class="login-panel-card" style="border: 1px solid var(--line); padding: 40px; border-radius: 16px; background: #fff;">
                        <!-- Centered headers -->
                        <div class="skel" style="width: 140px; height: 14px; margin: 0 auto 12px auto; opacity: 0.1; border-radius: 4px;"></div>
                        <div class="skel" style="width: 120px; height: 36px; margin: 0 auto 6px auto; opacity: 0.1; border-radius: 8px;"></div>
                        <div class="skel" style="width: 320px; height: 14px; margin: 0 auto 32px auto; opacity: 0.1; border-radius: 4px;"></div>
                        
                        <!-- Left-aligned inputs -->
                        <div style="margin-bottom: 20px;">
                            <div class="skel" style="width: 50px; height: 14px; margin-bottom: 8px; opacity: 0.1; border-radius: 4px;"></div>
                            <div class="skel" style="width: 100%; height: 48px; opacity: 0.1; border-radius: 8px;"></div>
                        </div>
                        
                        <div style="margin-bottom: 24px;">
                            <div class="skel" style="width: 80px; height: 14px; margin-bottom: 8px; opacity: 0.1; border-radius: 4px;"></div>
                            <div class="skel" style="width: 100%; height: 48px; opacity: 0.1; border-radius: 8px;"></div>
                        </div>
                        
                        <!-- Checkbox and Forgot Password line -->
                        <div style="display: flex; justify-content: space-between; margin-bottom: 24px;">
                            <div class="skel" style="width: 100px; height: 14px; opacity: 0.1; border-radius: 4px;"></div>
                            <div class="skel" style="width: 120px; height: 14px; opacity: 0.1; border-radius: 4px;"></div>
                        </div>

                        <!-- Button -->
                        <div class="skel" style="width: 100%; height: 48px; opacity: 0.1; border-radius: 8px; margin-bottom: 32px;"></div>
                        
                        <!-- Register Link -->
                        <div class="skel" style="width: 250px; height: 14px; margin: 0 auto; opacity: 0.1; border-radius: 4px;"></div>
                    </div>
                </div>

                <div class="skel" style="width: 200px; height: 14px; margin: 32px auto 0 auto; opacity: 0.1; border-radius: 4px;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- ACTUAL CONTENT                              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="content-wrap" id="actual-content" style="width: 100%; display: none;">
        <div class="login-split-layout fade-up" style="animation-delay: 0.1s;">
            <!-- Left Column -->
            <div class="login-split-left">
                <div class="brand">
                    <img src="{{ asset('logo.png') }}" alt="Logo">
                    <div class="brand-text">
                        <h2>PT SAKTI Kinerja Kolaborasindo</h2>
                        <p>PORTAL PELAPORAN &amp; PEMANTAUAN TIKET MITRA</p>
                    </div>
                </div>
                
                <div style="margin: auto 0; position: relative; z-index: 10;">
                    <div class="eyebrow">LAYANAN SUPPORT TERPADU</div>
                    <h1>Transparansi penuh atas setiap laporan mitra Anda.</h1>
                    <p class="desc" style="margin-bottom: 0;">
                        Setiap kendala yang Anda laporkan langsung masuk ke sistem tiket kami dan ditindaklanjuti oleh tim support yang responsif. Tidak perlu menebak-nebak progresnya status penanganan, riwayat komunikasi, hingga estimasi penyelesaian bisa Anda pantau kapan saja, langsung dari dashboard. Semua terhubung erat dengan seluruh layanan dalam ekosistem SAKTI, SICUNDO, dan mitra pendukung lainnya, sehingga laporan Anda tertangani cepat, akurat, dan tanpa perlu berpindah-pindah platform.
                    </p>
                </div>

                <div class="badges-bg">
                    <div class="badge-float" style="top: 12%; right: 15%; --scale: 0.8; opacity: 0.5; animation: float-badge 6s ease-in-out infinite;">SAKTI Multiusaha</div>
                    <div class="badge-float" style="top: 24%; right: 2%; --scale: 1.15; opacity: 0.95; animation: float-badge-alt 8s ease-in-out infinite; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">SICUNDO SAKTI</div>
                    <div class="badge-float" style="top: 36%; right: 22%; --scale: 0.9; opacity: 0.7; animation: float-badge 7s ease-in-out infinite 1s;">SAKTI.Link</div>
                    <div class="badge-float" style="top: 48%; right: 5%; --scale: 1.2; opacity: 1; animation: float-badge-alt 7.5s ease-in-out infinite 0.5s; box-shadow: 0 25px 50px rgba(0,0,0,0.4);">LACI</div>
                    <div class="badge-float" style="top: 60%; right: 20%; --scale: 0.85; opacity: 0.6; animation: float-badge 6.5s ease-in-out infinite 1.5s;">SAKTI Mobile</div>
                    <div class="badge-float" style="top: 70%; right: 3%; --scale: 1.05; opacity: 0.85; animation: float-badge-alt 8.5s ease-in-out infinite 0.2s;">SICUNDO KU</div>
                    <div class="badge-float" style="top: 80%; right: 24%; --scale: 0.75; opacity: 0.45; animation: float-badge 6s ease-in-out infinite 2s;">SAKTI Retail</div>
                    <div class="badge-float" style="top: 88%; right: 8%; --scale: 0.95; opacity: 0.8; animation: float-badge-alt 7s ease-in-out infinite 1s; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">Transaksi SAKTI.Link</div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="login-split-right">
                <div class="top-text">Masuk sebagai mitra: <strong>PT Sakti Kinerja Kolaborasindo</strong></div>
                
                <div class="login-box fade-up" style="animation-delay: 0.15s; margin: 0 auto; max-width: 460px; width: 100%;">
                    <div class="login-panel-card fade-up" style="animation-delay: 0.2s;">
                        <p class="eyebrow" style="color: var(--amber); margin-bottom: 12px;">{{ __('messages.masuk_ke_akun') }}</p>
                        <h1 style="margin-bottom: 6px;">Login</h1>
                        <p class="lede" style="margin-bottom: 24px;">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>

                        {{-- Tampilkan error login --}}
                        @if($errors->any())
                            <div id="login-error" class="alert-dismiss" style="text-align: left; margin-bottom: 18px; font-weight: 500; color: var(--amber); background: var(--amber-soft); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: flex-start; transition: opacity 0.6s ease, transform 0.6s ease;">
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="document.getElementById('login-error').style.display='none'" style="background: none; border: none; color: var(--amber); cursor: pointer; font-size: calc(18px * var(--text-scale, 1)); font-weight: bold; line-height: 1; padding: 0 4px; margin-left: 10px;">&times;</button>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="field">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="support@skk.co.id" required>
                            </div>
                            <div class="field">
                                <label>{{ __('messages.password') }}</label>
                                <input type="password" name="password" placeholder="••••••••" required>
                            </div>
                            
                            <!-- Adding remember me and forgot password -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: calc(12px * var(--text-scale, 1));">
                                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--ink-soft); font-weight: 500;">
                                    <input type="checkbox" name="remember" style="width: 14px; height: 14px; accent-color: var(--brand-primary); margin:0; padding:0; border: 1.5px solid var(--line); border-radius: 4px; cursor: pointer;">
                                    Ingat saya
                                </label>
                                <a href="#" style="color: var(--brand-primary); font-weight: 600; text-decoration: underline;">Lupa kata sandi?</a>
                            </div>

                            <button type="submit" class="btn" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; color: white; padding: 14px; border-radius: 12px; font-size: 15px; font-weight: 600; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3); transition: all 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37, 99, 235, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(37, 99, 235, 0.3)';">Masuk ke Dashboard &rarr;</button>
                        </form>

                        <div class="register-prompt" style="position: relative; margin-top: 32px; border-top: none; padding-top: 24px;">
                            <div style="position: absolute; top: -7px; left: 50%; transform: translateX(-50%); background: var(--paper-raised); padding: 0 10px; font-size: calc(11px * var(--text-scale, 1)); color: var(--ink-soft); font-family: var(--font-mono); z-index: 2;">atau</div>
                            <div style="position: absolute; top: 0; left: 0; right: 0; border-top: 1px solid var(--line); z-index: 1;"></div>
                            Belum mempunyai akun? <a href="{{ route('register') }}" style="color: var(--brand-primary); font-weight: 700; text-decoration: underline;">Daftar sebagai mitra</a>
                        </div>
                    </div>
                </div>

                <div class="bottom-text fade-up" style="animation-delay: 0.25s;">
                    Butuh bantuan masuk? <a href="#" id="support-modal-trigger">Hubungi tim support</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bantuan Support -->
<div id="support-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
    <div class="modal-card" style="background: var(--paper-raised, #fff); border: 1px solid var(--line); border-radius: 16px; width: 90%; max-width: 440px; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); transform: scale(0.95); transition: transform 0.3s ease; position: relative;">
        <!-- Close Button -->
        <button id="close-support-modal" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; color: var(--ink-soft); cursor: pointer; line-height: 1; padding: 0;">&times;</button>
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="background: var(--brand-primary-soft, rgba(229, 57, 53, 0.1)); width: 56px; height: 56px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <span style="font-size: 28px;">💬</span>
            </div>
            <h2 style="margin: 0 0 8px 0; font-family: var(--font-display); font-size: calc(20px * var(--text-scale, 1)); font-weight: 700; color: var(--ink);">Hubungi Tim Support</h2>
            <p style="margin: 0; font-size: calc(13px * var(--text-scale, 1)); color: var(--ink-soft); line-height: 1.5;">
                Jika Anda mengalami kendala saat masuk ke portal, silakan hubungi tim support kami melalui kontak di bawah ini:
            </p>
        </div>

        <!-- Contact List -->
        <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
            <!-- Telepon -->
            <div style="border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 16px; background: var(--paper, #fff);">
                <div style="background: var(--brand-primary-soft, rgba(229, 57, 53, 0.05)); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('telephone.png') }}" alt="Telepon" style="width: 20px; height: 20px; object-fit: contain;">
                </div>
                <div style="flex-grow: 1;">
                    <div style="font-weight: 700; font-size: calc(12px * var(--text-scale, 1)); color: var(--ink-soft); text-transform: uppercase; letter-spacing: 0.05em;">Nomor Telepon</div>
                    <div style="font-family: var(--font-mono); font-size: calc(14px * var(--text-scale, 1)); color: var(--ink); font-weight: 600; margin-top: 2px;">+62 812-2318-2828</div>
                </div>
            </div>

            <!-- Email -->
            <div style="border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 16px; background: var(--paper, #fff);">
                <div style="background: var(--brand-primary-soft, rgba(229, 57, 53, 0.05)); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('mail.png') }}" alt="Email" style="width: 20px; height: 20px; object-fit: contain;">
                </div>
                <div style="flex-grow: 1;">
                    <div style="font-weight: 700; font-size: calc(12px * var(--text-scale, 1)); color: var(--ink-soft); text-transform: uppercase; letter-spacing: 0.05em;">Email Support</div>
                    <div style="font-family: var(--font-mono); font-size: calc(14px * var(--text-scale, 1)); color: var(--ink); font-weight: 600; margin-top: 2px;">info@ptskk.id</div>
                </div>
            </div>

            <!-- WhatsApp -->
            <a href="https://wa.me/{{ formatNomorWa(config('services.whatsapp_support_number') ?? '081223182828') }}?text=Halo,%20saya%20ingin%20bertanya%20terkait%20Recap%20Support%20Tracker" target="_blank" style="text-decoration: none; border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 16px; background: var(--paper, #fff); transition: background 0.2s; cursor: pointer;" onmouseover="this.style.background='var(--paper-sunken, #f8f9fa)'" onmouseout="this.style.background='var(--paper, #fff)'">
                <div style="background: var(--brand-primary-soft, rgba(229, 57, 53, 0.05)); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <img src="{{ asset('whatsapp.png') }}" alt="WhatsApp" style="width: 20px; height: 20px; object-fit: contain;">
                </div>
                <div style="flex-grow: 1;">
                    <div style="font-weight: 700; font-size: calc(12px * var(--text-scale, 1)); color: var(--ink-soft); text-transform: uppercase; letter-spacing: 0.05em;">WhatsApp Chat</div>
                    <div style="font-size: calc(13px * var(--text-scale, 1)); color: var(--brand-primary); font-weight: 600; margin-top: 2px; text-decoration: underline;">Hubungi via WhatsApp &rarr;</div>
                </div>
            </a>
        </div>

        <!-- Operating Hours Note -->
        <div style="text-align: center; font-size: calc(11px * var(--text-scale, 1)); color: var(--ink-soft); font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 0.05em;">
            Jam Operasional: Senin - Jumat (09:00 - 17:00 WIB)
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skeleton = document.getElementById('skeleton-loading');
        const content  = document.getElementById('actual-content');
        setTimeout(function () {
            skeleton.style.display = 'none';
            content.style.display = 'flex';
            content.classList.add('loaded');
        }, 800);

        // Modal Bantuan Support logic
        const supportTrigger = document.getElementById('support-modal-trigger');
        const supportModal = document.getElementById('support-modal');
        const closeSupportModal = document.getElementById('close-support-modal');
        const modalId = document.querySelector('#support-modal .modal-card');

        function openModal(e) {
            e.preventDefault();
            supportModal.style.display = 'flex';
            setTimeout(() => {
                supportModal.style.opacity = '1';
                if (modalId) modalId.style.transform = 'scale(1)';
            }, 10);
        }

        function closeModal() {
            supportModal.style.opacity = '0';
            if (modalId) modalId.style.transform = 'scale(0.95)';
            setTimeout(() => {
                supportModal.style.display = 'none';
            }, 300);
        }

        if (supportTrigger) supportTrigger.addEventListener('click', openModal);
        if (closeSupportModal) closeSupportModal.addEventListener('click', closeModal);
        
        // Close modal when clicking outside modal-card
        if (supportModal) {
            supportModal.addEventListener('click', (e) => {
                if (e.target === supportModal) {
                    closeModal();
                }
            });
        }
    });
</script>
@endsection
