<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:Inter,system-ui,sans-serif;font-size:17px;font-weight:600;color:#1d1d1f;margin:0;">
            Edit Lapangan
        </h2>
    </x-slot>

    <style>
        *,*::before,*::after{box-sizing:border-box}
        .form-wrap{max-width:680px;margin:36px auto;padding:0 24px;font-family:Inter,system-ui,sans-serif;color:#1d1d1f;font-size:17px}
        .form-card{background:#fff;border:1px solid #e0e0e0;border-radius:16px;padding:36px 40px}
        .form-title{font-size:20px;font-weight:700;letter-spacing:-.2px;margin-bottom:28px;color:#1d1d1f}
        .form-group{margin-bottom:22px}
        label{display:block;font-size:15px;font-weight:500;color:#1d1d1f;margin-bottom:7px}
        .form-control{width:100%;font-size:16px;color:#1d1d1f;background:#fff;border:1px solid #e0e0e0;border-radius:10px;padding:11px 14px;outline:none;transition:border-color .15s,box-shadow .15s;font-family:inherit}
        .form-control:focus{border-color:#0071e3;box-shadow:0 0 0 3px rgba(0,113,227,.12)}
        .form-control.is-invalid{border-color:#e3342f}
        textarea.form-control{resize:vertical;min-height:110px}
        .error-msg{font-size:13px;color:#e3342f;margin-top:6px}
        .hint{font-size:13px;color:#6e6e73;margin-top:5px}
        .foto-preview{display:flex;align-items:center;gap:14px;margin-bottom:10px}
        .foto-preview img{width:72px;height:72px;object-fit:cover;border-radius:10px;border:1px solid #e0e0e0}
        .foto-preview-label{font-size:13px;color:#6e6e73}
        .form-actions{display:flex;gap:12px;align-items:center;margin-top:32px;padding-top:24px;border-top:1px solid #e0e0e0}
        .btn-save{display:inline-flex;align-items:center;background:#0066cc;color:#fff;font-size:15px;font-weight:500;padding:10px 26px;border-radius:9999px;border:none;cursor:pointer;transition:background .15s;font-family:inherit}
        .btn-save:hover{background:#0055aa}
        .btn-cancel{display:inline-flex;align-items:center;background:transparent;color:#0066cc;font-size:15px;font-weight:500;padding:10px 22px;border-radius:9999px;border:1px solid #0066cc;text-decoration:none;transition:background .15s,color .15s;font-family:inherit}
        .btn-cancel:hover{background:#0066cc;color:#fff}
    </style>

    <div class="form-wrap">
        <div class="form-card">
            <div class="form-title">Edit Lapangan: {{ $lapangan->nama_lapangan }}</div>

            <form action="{{ route('admin.lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_lapangan">Nama Lapangan</label>
                    <input type="text" id="nama_lapangan" name="nama_lapangan"
                        class="form-control {{ $errors->has('nama_lapangan') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}"
                        placeholder="Contoh: Lapangan Futsal A">
                    @error('nama_lapangan')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_olahraga">Jenis Olahraga</label>
                    <select id="jenis_olahraga" name="jenis_olahraga"
                        class="form-control {{ $errors->has('jenis_olahraga') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Jenis Olahraga --</option>
                        <option value="Futsal" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="Badminton" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="Basket" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Basket' ? 'selected' : '' }}>Basket</option>
                        <option value="Tenis" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Tenis' ? 'selected' : '' }}>Tenis</option>
                        <option value="Voli" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Voli' ? 'selected' : '' }}>Voli</option>
                        <option value="Lainnya" {{ old('jenis_olahraga', $lapangan->jenis_olahraga) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_olahraga')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga_per_jam">Harga per Jam (Rp)</label>
                    <input type="number" id="harga_per_jam" name="harga_per_jam"
                        class="form-control {{ $errors->has('harga_per_jam') ? 'is-invalid' : '' }}"
                        value="{{ old('harga_per_jam', $lapangan->harga_per_jam) }}"
                        placeholder="Contoh: 75000" min="1">
                    @error('harga_per_jam')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"
                        class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        placeholder="Tuliskan deskripsi singkat tentang lapangan...">{{ old('deskripsi', $lapangan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_lapangan">Foto Lapangan</label>
                    @if($lapangan->foto_lapangan)
                    <div class="foto-preview">
                        <img src="{{ asset('storage/' . $lapangan->foto_lapangan) }}" alt="Foto {{ $lapangan->nama_lapangan }}">
                        <span class="foto-preview-label">Foto saat ini. Upload baru untuk mengganti.</span>
                    </div>
                    @endif
                    <input type="file" id="foto_lapangan" name="foto_lapangan"
                        class="form-control {{ $errors->has('foto_lapangan') ? 'is-invalid' : '' }}"
                        accept=".jpg,.jpeg,.png,.webp">
                    <p class="hint">Format: JPG, JPEG, PNG, WEBP. Maks 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                    @error('foto_lapangan')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status"
                        class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia" {{ old('status', $lapangan->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status', $lapangan->status) === 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                    <a href="{{ route('admin.lapangan.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
