@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Scan QR / Barcode
            </h2>
            <p class="text-muted mb-0">
                Scan QR Code asset untuk melakukan pemeriksaan.
            </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-qr-code-scan me-2"></i>
                        Scanner Asset
                    </h5>
                </div>

                <div class="card-body">
                    {{-- Area Scanner --}}
                    <div
                        id="reader"
                        class="rounded overflow-hidden"
                        style="width: 100%;"
                    ></div>

                    {{-- Status --}}
                    <div
                        id="scan-status"
                        class="alert alert-secondary mt-3 mb-0"
                    >
                        <i class="bi bi-camera me-2"></i>
                        Arahkan kamera ke QR Code asset.
                    </div>

                    {{-- Hasil Scan --}}
                    <div
                        id="scan-result"
                        class="mt-4 d-none"
                    >
                        <div class="card bg-light border-0">
                            <div class="card-body text-center">
                                <div class="mb-2">
                                    <i
                                        class="bi bi-check-circle-fill text-success"
                                        style="font-size: 40px;"
                                    ></i>
                                </div>
                                <h5 class="fw-bold">
                                    QR Code Berhasil Dibaca
                                </h5>
                                <p class="text-muted mb-2">
                                    ID Inventaris
                                </p>
                                <div
                                    id="scanned-code"
                                    class="badge bg-dark fs-6 px-3 py-2"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Petunjuk --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Petunjuk Scan
                    </h6>
                    <ol class="mb-0">
                        <li class="mb-2">
                            Izinkan browser menggunakan kamera.
                        </li>
                        <li class="mb-2">
                            Arahkan kamera ke QR Code asset.
                        </li>
                        <li class="mb-2">
                            Pastikan QR Code terlihat jelas dan tidak terlalu jauh.
                        </li>
                        <li>
                            Setelah QR terbaca, sistem akan menampilkan ID inventaris asset.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Library QR Scanner --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>

    let scannerStarted = true;

    function onScanSuccess(decodedText, decodedResult) {

        if (!scannerStarted) {
            return;
        }

        scannerStarted = false;

        const status = document.getElementById('scan-status');

        status.className = 'alert alert-info mt-3 mb-0';
        status.innerHTML =
            '<i class="bi bi-hourglass-split me-2"></i>' +
            'QR Code terbaca. Mencari data asset...';

        // Tampilkan hasil scan
        document.getElementById('scanned-code').textContent = decodedText;
        document
            .getElementById('scan-result')
            .classList.remove('d-none');

        // Kirim hasil scan ke Laravel menggunakan Relative Path
        const assetCode = decodedText.trim();

        fetch(
            "/scan/find-asset/" + encodeURIComponent(assetCode),
            {
                method: "GET",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            }
        )
        .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message ||
                    `Server error: ${response.status}`
                );
            }

            return data;
        })
        .then(data => {
            if (data.success) {
                status.className = 'alert alert-success mt-3 mb-0';
                status.innerHTML =
                    '<i class="bi bi-check-circle me-2"></i>' +
                    'Asset ditemukan. Membuka data asset...';

                setTimeout(() => {
                    window.location.href = data.asset.url;
                }, 800);
            }
        })
        .catch(error => {
            console.error('Scan error:', error);

            status.className = 'alert alert-danger mt-3 mb-0';
            status.innerHTML =
                '<i class="bi bi-exclamation-triangle me-2"></i>' +
                error.message;

            scannerStarted = true;
        });
    }

    function onScanFailure(error) {
        // Error setiap frame tidak perlu ditampilkan.
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        false
    );

    html5QrcodeScanner.render(
        onScanSuccess,
        onScanFailure
    );

</script>

@endsection