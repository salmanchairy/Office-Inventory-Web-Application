@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pemeriksaan Asset</h2>
            <p class="text-muted mb-0">
                Isi hasil pemeriksaan fisik perangkat.
            </p>
        </div>

        <a href="{{ route('assets.show', $asset) }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Detail
        </a>
    </div>

    {{-- Informasi Asset --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-pc-display me-2"></i>
                Informasi Asset
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <small class="text-muted">ID Inventaris</small>
                    <div class="fw-bold">{{ $asset->asset_code }}</div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kategori</small>
                    <div>{{ $asset->category->name ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Merek</small>
                    <div>{{ $asset->brand }}</div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Model</small>
                    <div>{{ $asset->model ?: '-' }}</div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Serial Number Terdaftar</small>
                    <div>{{ $asset->serial_number }}</div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Lokasi</small>
                    <div>
                        {{ $asset->location->regional ?? '-' }}
                        @if($asset->location?->room)
                            - {{ $asset->location->room }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Pemeriksaan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-clipboard-check me-2"></i>
                Form Hasil Pemeriksaan
            </h5>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inspections.store', $asset) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="inspection_date" class="form-label">
                            Tanggal Pemeriksaan <span class="text-danger">*</span>
                        </label>

                        <input type="datetime-local"
                               name="inspection_date"
                               id="inspection_date"
                               class="form-control"
                               value="{{ old('inspection_date', now()->format('Y-m-d\TH:i')) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="condition" class="form-label">
                            Kondisi Fisik <span class="text-danger">*</span>
                        </label>

                        <select name="condition"
                                id="condition"
                                class="form-select"
                                required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik" @selected(old('condition') == 'Baik')>
                                Baik
                            </option>
                            <option value="Rusak Ringan" @selected(old('condition') == 'Rusak Ringan')>
                                Rusak Ringan
                            </option>
                            <option value="Rusak Berat" @selected(old('condition') == 'Rusak Berat')>
                                Rusak Berat
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="serial_number_checked" class="form-label">
                            Serial Number pada Perangkat
                        </label>

                        <input type="text"
                               name="serial_number_checked"
                               id="serial_number_checked"
                               class="form-control"
                               value="{{ old('serial_number_checked', $asset->serial_number) }}"
                               maxlength="100"
                               placeholder="Masukkan serial number yang ditemukan">

                        <small class="text-muted">
                            Cocokkan dengan serial number terdaftar.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="physical_check" class="form-label">
                            Kecocokan Fisik <span class="text-danger">*</span>
                        </label>

                        <select name="physical_check"
                                id="physical_check"
                                class="form-select"
                                required>
                            <option value="">-- Pilih Hasil --</option>
                            <option value="Sesuai" @selected(old('physical_check') == 'Sesuai')>
                                Sesuai
                            </option>
                            <option value="Tidak Sesuai" @selected(old('physical_check') == 'Tidak Sesuai')>
                                Tidak Sesuai
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">
                            Catatan Pemeriksaan
                        </label>

                        <textarea name="description"
                                  id="description"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Contoh: perangkat menyala, tetapi kipas mengeluarkan suara bising.">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="recommendation" class="form-label">
                            Rekomendasi Tindakan
                        </label>

                        <textarea name="recommendation"
                                  id="recommendation"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Contoh: perlu pemeriksaan teknisi atau penggantian komponen.">{{ old('recommendation') }}</textarea>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Foto Pemeriksaan Aset
                        </label>

                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <button
                                type="button"
                                class="btn btn-primary"
                                id="open-camera-btn"
                            >
                                📷 Buka Kamera
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                onclick="document.getElementById('photos-gallery').click()"
                            >
                                📁 Pilih dari File / Galeri
                            </button>
                        </div>

                        <div id="camera-panel" class="mt-3" hidden>
                            <video
                                id="camera-preview"
                                autoplay
                                playsinline
                                style="width:100%; max-width:480px; background:#000; border-radius:8px;"
                            ></video>

                            <div class="mt-2">
                                <button type="button" class="btn btn-success" id="take-photo-btn">
                                    Ambil Foto
                                </button>

                                <button type="button" class="btn btn-secondary" id="close-camera-btn">
                                    Tutup Kamera
                                </button>
                            </div>

                            <canvas id="camera-canvas" hidden></canvas>
                        </div>


                        <input
                            type="file"
                            name="photos[]"
                            id="photos-camera"
                            accept="image/*"
                            capture="environment"
                            multiple
                            hidden
                        >

                        <input
                            type="file"
                            name="photos[]"
                            id="photos-gallery"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            hidden
                        >

                        <div id="selected-photos" class="small text-muted">
                            Belum ada foto dipilih.
                        </div>

                        <small class="text-muted">
                            Maksimal 5 foto, masing-masing maksimal 5 MB.
                        </small>

                        @error('photos')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        @error('photos.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <script>
                        const cameraInput = document.getElementById('photos-camera');
                        const galleryInput = document.getElementById('photos-gallery');
                        const selectedPhotos = document.getElementById('selected-photos');

                        const openCameraBtn = document.getElementById('open-camera-btn');
                        const takePhotoBtn = document.getElementById('take-photo-btn');
                        const closeCameraBtn = document.getElementById('close-camera-btn');

                        const cameraPanel = document.getElementById('camera-panel');
                        const cameraPreview = document.getElementById('camera-preview');
                        const cameraCanvas = document.getElementById('camera-canvas');

                        let chosenPhotos = [];
                        let cameraStream = null;

                        // Menampilkan daftar foto yang sudah dipilih
                        function showSelectedPhotos() {
                            selectedPhotos.textContent = chosenPhotos.length
                                ? chosenPhotos.length + ' foto: ' +
                                    chosenPhotos.map(file => file.name).join(', ')
                                : 'Belum ada foto dipilih.';
                        }

                        // Menggabungkan foto dari kamera dan file/galeri
                        function updatePhotoInput(input) {
                            const newFiles = Array.from(input.files || []);

                            for (const file of newFiles) {
                                const exists = chosenPhotos.some(existing =>
                                    existing.name === file.name &&
                                    existing.size === file.size &&
                                    existing.lastModified === file.lastModified
                                );

                                if (!exists) {
                                    if (chosenPhotos.length >= 5) {
                                        alert('Maksimal 5 foto.');
                                        break;
                                    }

                                    chosenPhotos.push(file);
                                }
                            }

                            syncPhotosToForm();
                        }

                        // Memasukkan semua foto ke input yang dikirim ke Laravel
                        function syncPhotosToForm() {
                            const transfer = new DataTransfer();

                            chosenPhotos.forEach(file => transfer.items.add(file));

                            galleryInput.files = transfer.files;
                            showSelectedPhotos();
                        }

                        cameraInput.addEventListener('change', () => {
                            updatePhotoInput(cameraInput);
                            cameraInput.value = '';
                        });

                        
                        galleryInput.addEventListener('change', () => {
                            // Simpan pilihan foto ke daftar gabungan.
                            // Jangan kosongkan galleryInput karena input ini
                            // digunakan untuk mengirim foto ke Laravel.
                            updatePhotoInput(galleryInput);
                        });


                        // Membuka kamera langsung di halaman
                        openCameraBtn.addEventListener('click', async () => {
                            try {
                                if (!navigator.mediaDevices ||
                                    !navigator.mediaDevices.getUserMedia) {
                                    alert(
                                        'Kamera tidak tersedia. Buka aplikasi melalui HTTPS ' +
                                        'atau localhost dan gunakan browser yang mendukung kamera.'
                                    );
                                    return;
                                }

                                cameraStream = await navigator.mediaDevices.getUserMedia({
                                    video: {
                                        facingMode: { ideal: 'environment' }
                                    },
                                    audio: false
                                });

                                cameraPreview.srcObject = cameraStream;
                                cameraPanel.hidden = false;

                                await cameraPreview.play();
                            } catch (error) {
                                alert(
                                    'Kamera gagal dibuka. Periksa izin kamera browser, ' +
                                    'pastikan kamera tidak digunakan aplikasi lain, ' +
                                    'dan coba izinkan akses kamera.'
                                );
                            }
                        });

                        // Mengambil foto dari pratinjau kamera
                        takePhotoBtn.addEventListener('click', () => {
                            if (!cameraPreview.videoWidth || !cameraPreview.videoHeight) {
                                alert('Kamera belum siap. Silakan tunggu sebentar.');
                                return;
                            }

                            if (chosenPhotos.length >= 5) {
                                alert('Maksimal 5 foto.');
                                return;
                            }

                            cameraCanvas.width = cameraPreview.videoWidth;
                            cameraCanvas.height = cameraPreview.videoHeight;

                            const context = cameraCanvas.getContext('2d');
                            context.drawImage(
                                cameraPreview,
                                0,
                                0,
                                cameraCanvas.width,
                                cameraCanvas.height
                            );

                            cameraCanvas.toBlob(blob => {
                                if (!blob) {
                                    alert('Gagal mengambil foto. Silakan coba lagi.');
                                    return;
                                }

                                const photo = new File(
                                    [blob],
                                    'kamera-' + Date.now() + '.jpg',
                                    {
                                        type: 'image/jpeg',
                                        lastModified: Date.now()
                                    }
                                );

                                chosenPhotos.push(photo);
                                syncPhotosToForm();
                            }, 'image/jpeg', 0.9);
                        });

                        // Menutup kamera dan melepaskan akses perangkat
                        closeCameraBtn.addEventListener('click', () => {
                            if (cameraStream) {
                                cameraStream.getTracks().forEach(track => track.stop());
                                cameraStream = null;
                            }

                            cameraPreview.srcObject = null;
                            cameraPanel.hidden = true;
                        });

                        // Memastikan kamera berhenti setelah formulir berhasil dikirim
                        const inspectionForm = cameraInput.closest('form');

                        if (inspectionForm) {
                            inspectionForm.addEventListener('submit', () => {
                                if (cameraStream) {
                                    cameraStream.getTracks().forEach(track => track.stop());
                                }
                            });
                        }
                    </script>


                </div>

                <hr class="my-4">

                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <a href="{{ route('assets.show', $asset) }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Pemeriksaan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
