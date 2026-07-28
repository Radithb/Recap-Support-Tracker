@extends('layouts.app')

@section('page_title', 'Manajemen Pengguna')
@section('page_subtitle', 'Fitur Eksklusif Super Admin')

@section('content')
<div class="pelapor-panel">

    @if(session('success'))
        <div id="success-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; align-items: center; gap: 10px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; font-size: 0.9rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="error-alert" class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; align-items: center; gap: 10px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; font-size: 0.9rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-dismiss fade-up" style="animation-delay: 0.1s; display: flex; align-items: flex-start; gap: 10px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; font-size: 0.9rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="glass-panel fade-up" style="padding: 0; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 24px; border-bottom: 1px solid var(--line);">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--ink); margin: 0;">Daftar Pengguna Sistem</h2>
            <button onclick="openModal('modal-add-user')" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Pengguna
            </button>
        </div>

        <div class="table-scroll-wrapper" style="overflow: auto; border: none; border-radius: 0; background: transparent; margin: 0; padding-bottom: 0;">
            <table style="width: 100%; min-width: 800px; border-collapse: collapse;">
                <thead style="background: var(--paper-sunken); position: sticky; top: 0; z-index: 10;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Nama Pengguna</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Email</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Peran</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Instansi</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="border-bottom: 1px solid var(--line);">
                        <td style="padding: 1.25rem 1.5rem; color: var(--ink); font-size: 0.95rem; font-weight: 600;">{{ $user->nama }}</td>
                        <td style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.95rem;">{{ $user->email }}</td>
                        <td style="padding: 1.25rem 1.5rem; text-align: center;">
                            @if($user->role === \App\Enums\UserRole::SUPERADMIN->value)
                                <span class="badge" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Super Admin</span>
                            @elseif($user->role === \App\Enums\UserRole::SUPPORT->value)
                                <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Support</span>
                            @else
                                <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">Pelapor</span>
                            @endif
                        </td>
                        <td style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.95rem;">
                            {{ $user->instansi ? $user->instansi->nama_instansi : '-' }}
                        </td>
                        <td style="padding: 1.25rem 1.5rem; text-align: center; position: relative;">
                            @if($user->user_id !== Auth::id())
                            <div style="position: relative; display: inline-block;">
                                <button type="button" onclick="toggleDropdown(event, 'dropdown-user-{{ $user->user_id }}')" style="background: var(--paper-raised); border: 1.5px solid var(--line); border-radius: 8px; width: 32px; height: 32px; cursor: pointer; color: var(--ink); display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--border-hover)'; this.style.background='var(--paper-sunken)'" onmouseout="this.style.borderColor='var(--line)'; this.style.background='var(--paper-raised)'" title="Aksi">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.5"></circle><circle cx="12" cy="5" r="1.5"></circle><circle cx="12" cy="19" r="1.5"></circle></svg>
                                </button>
                                
                                <div id="dropdown-user-{{ $user->user_id }}" class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 36px; background: var(--paper-raised); border: 1px solid var(--line); border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 140px; z-index: 100; text-align: left; padding: 4px; overflow: hidden;">
                                    <button type="button" onclick="openModal('modal-edit-user-{{ $user->user_id }}')" style="display: flex; width: 100%; align-items: center; gap: 8px; padding: 10px 12px; font-size: 0.85rem; font-weight: 500; color: var(--ink); background: transparent; border: none; cursor: pointer; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='var(--paper-sunken)'" onmouseout="this.style.background='transparent'">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        Edit
                                    </button>
                                    <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menghapus akun ini?')) { document.getElementById('form-delete-{{ $user->user_id }}').submit(); }" style="display: flex; width: 100%; align-items: center; gap: 8px; padding: 10px 12px; font-size: 0.85rem; font-weight: 500; color: #ef4444; background: transparent; border: none; cursor: pointer; border-radius: 6px; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.background='transparent'">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Hapus
                                    </button>
                                    <form id="form-delete-{{ $user->user_id }}" action="{{ route('superadmin.pengguna.destroy', $user->user_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                            @else
                                <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Anda (Saat Ini)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="overlay" id="modal-add-user" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="modal w-sm modal-centered" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; width: 100%; max-width: 500px; margin: 20px; max-height: 90vh; overflow-y: auto;">
        <div class="modal-head" style="padding: 20px 24px; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--ink);">Tambah Pengguna Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modal-add-user')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;">✕</button>
        </div>
        <form action="{{ route('superadmin.pengguna.store') }}" method="POST">
            @csrf
            <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="nama" required placeholder="Masukkan nama" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Email <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email" required placeholder="Email aktif" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Kata Sandi <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="password" required placeholder="Minimal 8 karakter" value="password123" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Peran (Role) <span style="color:var(--danger)">*</span></label>
                    <select name="role" id="role-select" required onchange="toggleInstansi(this, 'add')" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                        <option value="">-- Pilih Peran --</option>
                        <option value="support">Tim Support (Internal)</option>
                        <option value="pelapor">Mitra Koperasi (Pelapor)</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
                <div class="field" id="instansi-group-add" style="display: none;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Instansi Koperasi <span style="color:var(--danger)">*</span></label>
                    <select name="instansi_id" id="instansi-select-add" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                        <option value="">-- Pilih Instansi --</option>
                        @foreach($instansis as $instansi)
                            <option value="{{ $instansi->instansi_id }}">{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-foot" style="padding: 16px 24px; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px; background: var(--paper-sunken); border-radius: 0 0 12px 12px;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-user')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Modals Edit Pengguna -->
@foreach($users as $user)
<div class="overlay" id="modal-edit-user-{{ $user->user_id }}" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="modal w-sm modal-centered" style="background: var(--paper-raised); border: 1px solid var(--line); border-radius: 12px; width: 100%; max-width: 500px; margin: 20px; max-height: 90vh; overflow-y: auto;">
        <div class="modal-head" style="padding: 20px 24px; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--ink);">Edit Pengguna</h3>
            </div>
            <button type="button" onclick="closeModal('modal-edit-user-{{ $user->user_id }}')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;">✕</button>
        </div>
        <form action="{{ route('superadmin.pengguna.update', $user->user_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="nama" required value="{{ $user->nama }}" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Email <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email" required value="{{ $user->email }}" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Ubah Kata Sandi</label>
                    <input type="text" name="password" placeholder="Kosongkan jika tidak ingin mengubah" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                </div>
                <div class="field">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Peran (Role) <span style="color:var(--danger)">*</span></label>
                    <select name="role" required onchange="toggleInstansi(this, 'edit-{{ $user->user_id }}')" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                        <option value="support" {{ $user->role === 'support' ? 'selected' : '' }}>Tim Support (Internal)</option>
                        <option value="pelapor" {{ $user->role === 'pelapor' ? 'selected' : '' }}>Mitra Koperasi (Pelapor)</option>
                        <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
                <div class="field" id="instansi-group-edit-{{ $user->user_id }}" style="display: {{ $user->role === 'pelapor' ? 'block' : 'none' }};">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--ink);">Instansi Koperasi <span style="color:var(--danger)">*</span></label>
                    <select name="instansi_id" id="instansi-select-edit-{{ $user->user_id }}" {{ $user->role === 'pelapor' ? 'required' : '' }} style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--line); background: var(--paper); color: var(--ink); font-size: 0.9rem;">
                        <option value="">-- Pilih Instansi --</option>
                        @foreach($instansis as $instansi)
                            <option value="{{ $instansi->instansi_id }}" {{ $user->instansi_id == $instansi->instansi_id ? 'selected' : '' }}>{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-foot" style="padding: 16px 24px; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px; background: var(--paper-sunken); border-radius: 0 0 12px 12px;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-edit-user-{{ $user->user_id }}')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    function openModal(id) {
        let el = document.getElementById(id);
        if(el) {
            el.style.display = 'flex';
        }
    }

    function closeModal(id) {
        let el = document.getElementById(id);
        if(el) {
            el.style.display = 'none';
        }
    }

    function toggleInstansi(selectElement, suffix) {
        let role = selectElement.value;
        let group = document.getElementById('instansi-group-' + suffix);
        let instansiSelect = document.getElementById('instansi-select-' + suffix);
        
        if (role === 'pelapor') {
            group.style.display = 'block';
            instansiSelect.setAttribute('required', 'required');
        } else {
            group.style.display = 'none';
            instansiSelect.removeAttribute('required');
            instansiSelect.value = "";
        }
    }

    function toggleDropdown(event, id) {
        event.stopPropagation();
        let menu = document.getElementById(id);
        let allMenus = document.querySelectorAll('.dropdown-menu');
        
        allMenus.forEach(m => {
            if(m.id !== id) m.style.display = 'none';
        });
        
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function() {
        let allMenus = document.querySelectorAll('.dropdown-menu');
        allMenus.forEach(m => {
            m.style.display = 'none';
        });
    });
</script>
@endsection
