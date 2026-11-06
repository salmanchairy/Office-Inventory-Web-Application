@extends('layouts.app')

@section('title', 'Scan QR Asset')
@section('page-title', 'Scan QR')

@push('styles')
<style>
    .scan-wrap { max-width: 920px; margin: 0 auto; }
    .scan-heading { margin-bottom:1.5rem; text-align:center; }.scan-heading h4 { margin:0 0 .35rem; color:#07569B; font-weight:700; }.scan-heading p { margin:0; color:#7A8FA8; }
    .scan-card .card-body { padding:1.5rem; }.scan-camera { position:relative; min-height:310px; display:flex; overflow:hidden; align-items:center; justify-content:center; border:1px dashed #bfd8ec; border-radius:13px; background:#f8fbfe; }.scan-camera.has-camera { display:block; border-style:solid; }.scan-placeholder { max-width:270px; color:#7890a7; text-align:center; }.scan-placeholder i { display:grid; width:56px; height:56px; place-items:center; margin:0 auto .9rem; color:#0788D8; border-radius:16px; background:#E8F4FF; font-size:1.8rem; }.scan-placeholder strong { display:block; color:#244363; }.scan-placeholder span { display:block; margin-top:.35rem; font-size:.82rem; line-height:1.5; }
    #reader { width:100%; }.scan-camera #reader video { width:100% !important; border-radius:12px; object-fit:cover; }.scan-camera #reader__dashboard { padding:.75rem !important; }.scan-camera #reader__dashboard_section_csr select { max-width:100%; }
    .scan-status { display:flex; align-items:flex-start; gap:.65rem; margin-top:1rem; padding:.8rem .95rem; border-radius:10px; background:#F2F7FC; color:#526B87; font-size:.84rem; }.scan-status i { color:#0788D8; font-size:1rem; }.scan-status.success { background:#e7f7ef; color:#18794e; }.scan-status.success i { color:#198754; }.scan-status.error { background:#fff0f1; color:#a62d3d; }.scan-status.error i { color:#dc3545; }
    .scan-actions { display:flex; justify-content:center; gap:.6rem; margin-top:1rem; }.scan-upload-note { margin-top:1rem; color:#7186A0; font-size:.78rem; text-align:center; }.scan-result { display:none; margin-top:1rem; padding:.85rem 1rem; border-radius:10px; background:#e7f7ef; color:#18794e; text-align:center; }.scan-result.show { display:block; }.scan-result code { color:#146c43; font-weight:700; }
    @media (max-width:576px) { .scan-card .card-body { padding:1rem; }.scan-camera { min-height:265px; }.scan-actions { flex-direction:column; }.scan-actions .btn { width:100%; } }
</style>
@endpush

@section('content')
<div class="container-fluid px-0"><div class="scan-wrap">
    <div class="scan-heading"><h4>Scan QR Asset</h4><p>Pindai QR pada label aset atau masukkan kode inventaris secara manual.</p></div>
    <div class="card scan-card"><div class="card-body">
        <div class="scan-camera" id="scanCamera"><div class="scan-placeholder" id="scanPlaceholder"><i class="bi bi-qr-code-scan"></i><strong>Siap memindai</strong><span>Aktifkan kamera, lalu arahkan ke QR code aset.</span></div><div id="reader" class="d-none"></div></div>
        <div class="scan-status" id="scanStatus" role="status"><i class="bi bi-camera"></i><span>Kamera belum aktif.</span></div>
        <div class="scan-actions"><button type="button" class="btn btn-primary" id="startScan"><i class="bi bi-camera me-1"></i>Aktifkan Kamera</button><button type="button" class="btn btn-outline-primary" id="uploadQr"><i class="bi bi-image me-1"></i>Unggah Gambar QR</button><button type="button" class="btn btn-outline-secondary d-none" id="stopScan"><i class="bi bi-stop-circle me-1"></i>Hentikan</button><input type="file" id="qrImage" class="d-none" accept="image/png,image/jpeg,image/webp"></div>
        <form class="input-group mt-3" id="manualLookup"><input class="form-control" id="manualCode" placeholder="Masukkan kode inventaris, contoh: INV-R1-00057"><button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i>Cari Aset</button></form>
        <div class="scan-result" id="scanResult"><i class="bi bi-check-circle-fill me-1"></i>Kode terbaca: <code id="scannedCode"></code><span class="ms-1">— membuka data aset…</span></div>
        <div class="scan-upload-note">Gunakan gambar PNG, JPG, atau WEBP yang menampilkan QR code dengan jelas.</div>
    </div></div>
</div></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const lookupUrl = @json(route('scan.find-asset', ['asset_code' => '__CODE__'], false));
    const camera = document.getElementById('scanCamera');
    const reader = document.getElementById('reader');
    const placeholder = document.getElementById('scanPlaceholder');
    const status = document.getElementById('scanStatus');
    const startButton = document.getElementById('startScan');
    const uploadButton = document.getElementById('uploadQr');
    const imageInput = document.getElementById('qrImage');
    const stopButton = document.getElementById('stopScan');
    const result = document.getElementById('scanResult');
    const scannedCode = document.getElementById('scannedCode');
    let scanner = null;
    let scanning = false;
    let lookingUp = false;

    function setStatus(message, type = 'default') {
        const icon = type === 'error' ? 'bi-exclamation-circle' : type === 'success' ? 'bi-check-circle' : 'bi-camera';
        status.className = `scan-status ${type === 'default' ? '' : type}`;
        status.innerHTML = `<i class="bi ${icon}"></i><span></span>`;
        status.querySelector('span').textContent = message;
    }

    async function stopScanner() {
        if (!scanner || !scanning) return;
        try { await scanner.stop(); } catch (_) { /* Scanner may already be stopped. */ }
        scanning = false;
        reader.classList.add('d-none');
        reader.innerHTML = '';
        camera.classList.remove('has-camera');
        placeholder.classList.remove('d-none');
        startButton.classList.remove('d-none');
        stopButton.classList.add('d-none');
    }

    async function lookupAsset(rawCode) {
        const code = rawCode.trim();
        if (!code || lookingUp) return;
        lookingUp = true;
        setStatus('Mencari aset…');
        try {
            const response = await fetch(lookupUrl.replace('__CODE__', encodeURIComponent(code)), { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'Aset tidak ditemukan.');
            scannedCode.textContent = data.asset.asset_code;
            result.classList.add('show');
            setStatus('Aset ditemukan. Membuka detail aset…', 'success');
            window.setTimeout(() => { window.location.assign(data.asset.url); }, 700);
        } catch (error) {
            result.classList.remove('show');
            setStatus(error.message || 'Data aset tidak dapat dimuat.', 'error');
        } finally { lookingUp = false; }
    }

    async function startScanner() {
        if (!window.Html5Qrcode) { setStatus('Library pemindai tidak dapat dimuat. Muat ulang halaman.', 'error'); return; }
        if (!navigator.mediaDevices?.getUserMedia) { setStatus('Browser ini tidak mendukung akses kamera. Gunakan input kode manual.', 'error'); return; }
        result.classList.remove('show');
        startButton.disabled = true;
        setStatus('Menyiapkan kamera…');
        try {
            const cameras = await Html5Qrcode.getCameras();
            if (!cameras.length) throw new Error('Kamera tidak ditemukan pada perangkat ini.');
            const selectedCamera = cameras.find((item) => /back|rear|environment/i.test(item.label)) || cameras[0];
            placeholder.classList.add('d-none'); reader.classList.remove('d-none'); camera.classList.add('has-camera');
            scanner = new Html5Qrcode('reader');
            await scanner.start(selectedCamera.id, { fps: 10, qrbox: { width: 230, height: 230 }, aspectRatio: 1 }, async (decodedText) => { if (!scanning) return; await stopScanner(); lookupAsset(decodedText); }, () => {});
            scanning = true;
            setStatus('Kamera aktif. Arahkan ke QR code aset.');
            startButton.classList.add('d-none'); stopButton.classList.remove('d-none');
        } catch (error) {
            reader.classList.add('d-none'); reader.innerHTML = ''; placeholder.classList.remove('d-none'); camera.classList.remove('has-camera');
            setStatus(error.message || 'Kamera tidak dapat diakses. Izinkan kamera atau gunakan input kode manual.', 'error');
        } finally { startButton.disabled = false; }
    }

    async function scanImage(file) {
        if (!file) return;
        if (!window.Html5Qrcode) { setStatus('Library pemindai tidak dapat dimuat. Muat ulang halaman.', 'error'); return; }
        await stopScanner();
        result.classList.remove('show');
        uploadButton.disabled = true;
        setStatus('Membaca QR dari gambar…');
        try {
            const imageScanner = new Html5Qrcode('reader');
            const decodedText = await imageScanner.scanFile(file, true);
            await imageScanner.clear();
            lookupAsset(decodedText);
        } catch (_) {
            setStatus('QR code tidak ditemukan pada gambar. Gunakan gambar yang lebih jelas.', 'error');
        } finally {
            reader.innerHTML = '';
            reader.classList.add('d-none');
            uploadButton.disabled = false;
            imageInput.value = '';
        }
    }

    startButton.addEventListener('click', startScanner);
    stopButton.addEventListener('click', async () => { await stopScanner(); setStatus('Kamera dihentikan.'); });
    uploadButton.addEventListener('click', () => imageInput.click());
    imageInput.addEventListener('change', (event) => scanImage(event.target.files[0]));
    document.getElementById('manualLookup').addEventListener('submit', (event) => { event.preventDefault(); lookupAsset(document.getElementById('manualCode').value); });
});
</script>
@endpush
