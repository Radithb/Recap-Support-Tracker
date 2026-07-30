    <form action="{{ route('implementasi.update', $implementasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Koperasi</label>
                <select name="instansi_id" class="form-control" required>
                    <option value="">Pilih Koperasi</option>
                    @foreach($instansis as $instansi)
                        <option value="{{ $instansi->instansi_id }}" {{ (old('instansi_id', $implementasi->instansi_id) == $instansi->instansi_id) ? 'selected' : '' }}>
                            {{ $instansi->nama_instansi }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Aplikasi/Modul</label>
                <div id="edit-aplikasi-container">
                    @php
                        $savedAplikasis = $implementasi->aplikasis->pluck('aplikasi_id')->toArray();
                        if(empty($savedAplikasis) && $implementasi->aplikasi_id) {
                            $savedAplikasis = [$implementasi->aplikasi_id];
                        }
                        $oldAplikasis = old('aplikasi_id', $savedAplikasis);
                        if(empty($oldAplikasis)) $oldAplikasis = [''];
                    @endphp
                    @foreach($oldAplikasis as $index => $oldAppId)
                    <div class="aplikasi-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <select name="aplikasi_id[]" class="form-control" required style="flex-grow: 1;">
                            <option value="" disabled {{ empty($oldAppId) ? 'selected' : '' }}>Pilih Aplikasi</option>
                            @foreach($aplikasis as $app)
                                <option value="{{ $app->aplikasi_id }}" {{ $oldAppId == $app->aplikasi_id ? 'selected' : '' }}>
                                    {{ $app->nama_aplikasi }}
                                </option>
                            @endforeach
                        </select>
                        @if($index === 0)
                            <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addEditAplikasiInput()">+</button>
                        @else
                            <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; flex-shrink: 0;" onclick="removeEditInput(this)">-</button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Pelatihan</label>
                <div class="grid-2">
                    <div>
                        <label class="form-label" style="font-weight: normal; font-size: 12px; color: #64748b;">Mulai</label>
                        <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ old('tanggal_pelatihan', $implementasi->tanggal_pelatihan ? $implementasi->tanggal_pelatihan->format('Y-m-d') : '') }}" required>
                    </div>
                    <div>
                        <label class="form-label" style="font-weight: normal; font-size: 12px; color: #64748b;">Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $implementasi->tanggal_selesai ? $implementasi->tanggal_selesai->format('Y-m-d') : '') }}">
                    </div>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Metode Pelatihan</label>
                    <select name="metode_pelatihan" class="form-control" required>
                        <option value="Online (Zoom/Meet)" {{ old('metode_pelatihan', $implementasi->metode_pelatihan) == 'Online (Zoom/Meet)' ? 'selected' : '' }}>Online (Zoom/Meet)</option>
                        <option value="Offline (Kunjungan)" {{ old('metode_pelatihan', $implementasi->metode_pelatihan) == 'Offline (Kunjungan)' ? 'selected' : '' }}>Offline (Kunjungan)</option>
                    </select>
                </div>
                <div></div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Anggota Yang Hadir</label>
                    <div id="edit-anggota-container">
                        @php
                            $savedAnggota = $implementasi->anggota_hadir ? array_map('trim', explode(',', $implementasi->anggota_hadir)) : [];
                            $oldAnggota = old('anggota_hadir', $savedAnggota);
                            if(empty($oldAnggota)) $oldAnggota = [''];
                        @endphp
                        @foreach($oldAnggota as $index => $anggota)
                        <div class="anggota-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" name="anggota_hadir[]" class="form-control" placeholder="Nama Anggota" value="{{ $anggota }}" required>
                            @if($index === 0)
                                <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addEditAnggotaInput()">+</button>
                            @else
                                <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; flex-shrink: 0;" onclick="removeEditInput(this)">-</button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Trainer/Pendamping (Opsional)</label>
                    <div id="edit-trainer-container">
                        @php
                            $savedTrainer = $implementasi->nama_trainer ? array_map('trim', explode(',', $implementasi->nama_trainer)) : [];
                            $oldTrainer = old('nama_trainer', $savedTrainer);
                            if(empty($oldTrainer)) $oldTrainer = [''];
                        @endphp
                        @foreach($oldTrainer as $index => $trainer)
                        <div class="trainer-input-group" style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" name="nama_trainer[]" class="form-control" placeholder="Nama Trainer" value="{{ $trainer }}">
                            @if($index === 0)
                                <button type="button" class="btn-action" style="background-color: #10b981; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; flex-shrink: 0;" onclick="addEditTrainerInput()">+</button>
                            @else
                                <button type="button" class="btn-action" style="background-color: #ef4444; padding: 0; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; flex-shrink: 0;" onclick="removeEditInput(this)">-</button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">No. Telepon / WhatsApp PIC</label>
                    <input type="text" name="kontak_pic" class="form-control" placeholder="Contoh: 081234567890" value="{{ old('kontak_pic', $implementasi->kontak_pic) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email PIC (Opsional)</label>
                    <input type="email" name="email_pic" class="form-control" placeholder="Email PIC Koperasi" value="{{ old('email_pic', $implementasi->email_pic) }}">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Target Go-Live (Opsional)</label>
                <input type="date" name="target_go_live" class="form-control" value="{{ old('target_go_live', $implementasi->target_go_live ? $implementasi->target_go_live->format('Y-m-d') : '') }}">
                <small style="display: block; margin-top: 5px; color: #64748b; font-size: 12px;">Kosongkan jika belum ada kepastian tanggal rilis</small>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Pelatihan (Opsional)</label>
                <textarea name="catatan_pelatihan" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika ada">{{ old('catatan_pelatihan', $implementasi->catatan_pelatihan) }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('modalEditData')">Batal</button>
            <button type="submit" class="btn-primary" style="background-color: #f59e0b; color: white; padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-weight: 500;">Simpan Perubahan</button>
        </div>
    </form>
