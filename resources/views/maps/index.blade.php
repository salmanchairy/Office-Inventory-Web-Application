@extends('layouts.app')

@section('title', 'Peta Persebaran')
@section('page-title', 'Peta Persebaran')

@push('styles')
<style>
    .map-page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.2rem;
    }

    .map-page-header h4 {
        color: #173B63;
        font-size: 1.45rem;
        font-weight: 750;
        letter-spacing: -.02em;
        margin: 0 0 .25rem;
    }

    .map-page-header p {
        margin: 0;
        color: #71849A;
        font-size: .9rem;
    }

    .map-page-tabs { display:inline-flex; gap:.3rem; padding:.3rem; margin-bottom:1.25rem; border:1px solid #E1EAF4; border-radius:11px; background:#fff; box-shadow:0 4px 14px rgba(31,82,130,.04); }
    .map-page-tabs a { padding:.52rem .78rem; border-radius:8px; color:#6D8299; font-size:.82rem; font-weight:700; text-decoration:none; }
    .map-page-tabs a.active, .map-page-tabs a:hover { color:#07569B; background:#EAF5FF; }

    .map-toolbar {
        display: grid;
        grid-template-columns: minmax(190px, 1fr) 210px auto;
        gap: .75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #E1EAF4;
        border-radius: 14px;
        box-shadow: 0 7px 20px rgba(31,82,130,.045);
    }

    .map-toolbar .input-group-text {
        background: #fff;
        color: #0788D8;
    }

    .map-shell {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        min-height: 590px;
        overflow: hidden;
        border: 1px solid #E1EAF4;
        border-radius: 14px;
        box-shadow: 0 7px 20px rgba(31,82,130,.045);
    }

    #distributionMap {
        min-height: 590px;
        width: 100%;
        background: #e8f4ff;
    }

    .map-detail {
        padding: 1.35rem;
        overflow-y: auto;
        background: #fff;
        border-left: 1px solid #E1EAF4;
    }

    .detail-kicker {
        color: #7A8FA8;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .detail-title {
        margin: .35rem 0;
        color: #07569B;
        font-size: 1.18rem;
        font-weight: 700;
    }

    .detail-address {
        color: #5f7894;
        font-size: .88rem;
        line-height: 1.55;
    }

    .detail-summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .65rem;
        margin: 1.25rem 0;
    }

    .summary-chip {
        padding: .72rem;
        border: 1px solid #E1EAF4;
        border-radius: 11px;
        background: #F8FBFF;
    }

    .summary-chip span {
        display: block;
        color: #7A8FA8;
        font-size: .7rem;
    }

    .summary-chip strong {
        color: #244363;
        font-size: 1.05rem;
    }

    .asset-list-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 1rem 0 .6rem;
        color: #244363;
        font-size: .88rem;
        font-weight: 700;
    }

    .map-asset {
        padding: .75rem 0;
        border-top: 1px solid #EDF2F7;
    }

    .map-asset-code {
        color: #07569B;
        font-size: .79rem;
        font-weight: 700;
    }

    .map-asset-meta {
        margin-top: .2rem;
        color: #6f849a;
        font-size: .77rem;
        line-height: 1.45;
    }

    .map-empty {
        display: flex;
        min-height: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        color: #7A8FA8;
        text-align: center;
    }

    .map-empty i {
        margin-bottom: .75rem;
        color: #8bbfe4;
        font-size: 2.6rem;
    }

    .asset-condition {
        display: inline-block;
        margin-top: .35rem;
        padding: .17rem .45rem;
        border-radius: 20px;
        font-size: .67rem;
        font-weight: 700;
    }

    .condition-baik {
        color: #157347;
        background: #d1e7dd;
    }

    .condition-ringan {
        color: #946c00;
        background: #fff3cd;
    }

    .condition-berat {
        color: #b02a37;
        background: #f8d7da;
    }

    .asset-marker {
        display: grid;
        width: 36px;
        height: 36px;
        place-items: center;
        color: #fff;
        border: 3px solid #fff;
        border-radius: 50%;
        background: linear-gradient(135deg, #0788D8, #07569B);
        box-shadow: 0 4px 12px rgba(7, 101, 174, .35);
        font-size: .72rem;
        font-weight: 700;
    }

    .leaflet-div-icon {
        background: transparent;
        border: 0;
    }

    @media (max-width: 992px) {
        .map-shell {
            grid-template-columns: 1fr;
        }

        .map-detail {
            max-height: 360px;
            border-top: 1px solid #E1EAF4;
            border-left: 0;
        }

        #distributionMap {
            min-height: 480px;
        }
    }

    @media (max-width: 576px) {
        .map-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .map-toolbar {
            grid-template-columns: 1fr;
        }

        .map-page-tabs { display:flex; width:100%; }
        .map-page-tabs a { flex:1; text-align:center; }

        .map-shell,
        #distributionMap {
            min-height: 420px;
        }

        .map-detail {
            padding: 1rem;
        }

        .detail-summary {
            grid-template-columns: repeat(4, 1fr);
            gap: .4rem;
        }

        .summary-chip {
            padding: .55rem .35rem;
        }

        .summary-chip span {
            font-size: .6rem;
        }

        .summary-chip strong {
            font-size: .9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="map-page-header">
        <div>
            <h4>Peta Persebaran Aset</h4>
            <p>Pantau sebaran lokasi dan kondisi aset secara visual.</p>
        </div>
        <span class="badge text-bg-light border text-secondary px-3 py-2"><i class="bi bi-geo-alt me-1"></i><span id="locationCount">0</span> lokasi terpetakan</span>
    </div>

    <nav class="map-page-tabs" aria-label="Navigasi lokasi">
        <a href="{{ route('locations.index') }}"><i class="bi bi-list-ul me-1"></i>Daftar Lokasi</a>
        <a href="{{ route('maps.index') }}" class="active"><i class="bi bi-map me-1"></i>Peta Persebaran</a>
    </nav>

    <form class="card map-toolbar" id="mapFilters">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input class="form-control" type="search" name="search" placeholder="Cari cabang, regional, gedung, atau ruang">
        </div>
        <select class="form-select" name="condition" aria-label="Filter kondisi aset">
            <option value="">Semua kondisi aset</option>
            <option value="Baik">Memiliki aset baik</option>
            <option value="Rusak Ringan">Memiliki aset rusak ringan</option>
            <option value="Rusak Berat">Memiliki aset rusak berat</option>
        </select>
        <button class="btn btn-primary" type="submit"><i class="bi bi-funnel me-1"></i>Terapkan</button>
    </form>

    <div class="card map-shell">
        <div id="distributionMap" aria-label="Peta persebaran kantor cabang"></div>
        <aside class="map-detail" id="mapDetail" aria-live="polite">
            <div class="map-empty"><i class="bi bi-map"></i><strong>Pilih penanda lokasi</strong><span class="small mt-1">Klik marker untuk melihat cabang dan daftar asetnya.</span></div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const endpoint = @json(route('api.map.locations', [], false));
        const map = L.map('distributionMap', {
            scrollWheelZoom: true,
            trackResize: true
        }).setView([0.8, 101.5], 6);
        
        const markerLayer = L.layerGroup().addTo(map);
        const detail = document.getElementById('mapDetail');
        const count = document.getElementById('locationCount');
        const filters = document.getElementById('mapFilters');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // FIX: Invalidate size saat peta di-render pertama kali & window di-resize
        setTimeout(() => {
            map.invalidateSize();
        }, 300);

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });

        const makeText = (tag, text, className = '') => {
            const element = document.createElement(tag);
            element.textContent = text || '-';
            if (className) element.className = className;
            return element;
        };

        const conditionClass = (condition) => ({
            'Baik': 'condition-baik',
            'Rusak Ringan': 'condition-ringan',
            'Rusak Berat': 'condition-berat'
        } [condition] || '');

        function showLocation(location) {
            detail.replaceChildren();
            detail.append(makeText('div', location.regional, 'detail-kicker'));
            detail.append(makeText('h5', location.name, 'detail-title'));
            detail.append(makeText('div', location.address || 'Alamat belum dilengkapi', 'detail-address'));

            const summary = document.createElement('div');
            summary.className = 'detail-summary';
            [
                ['Total', location.asset_summary.total],
                ['Baik', location.asset_summary.baik],
                ['Rusak ringan', location.asset_summary.rusak_ringan],
                ['Rusak berat', location.asset_summary.rusak_berat]
            ].forEach(([label, value]) => {
                const chip = document.createElement('div');
                chip.className = 'summary-chip';
                chip.append(makeText('span', label), makeText('strong', value));
                summary.append(chip);
            });
            detail.append(summary);

            const assetTitle = document.createElement('div');
            assetTitle.className = 'asset-list-title';
            assetTitle.append(makeText('span', 'Daftar aset'), makeText('span', `${location.assets.length} aset`, 'badge text-bg-primary'));
            detail.append(assetTitle);

            if (!location.assets.length) {
                detail.append(makeText('p', 'Belum ada aset yang tercatat pada lokasi ini.', 'text-muted small'));
                return;
            }

            location.assets.forEach((asset) => {
                const item = document.createElement('div');
                item.className = 'map-asset';
                item.append(makeText('div', asset.asset_code, 'map-asset-code'));
                item.append(makeText('div', [asset.brand, asset.model, asset.category].filter(Boolean).join(' • '), 'map-asset-meta'));
                item.append(makeText('div', `SN: ${asset.serial_number || '-'} · ${asset.status}`, 'map-asset-meta'));
                item.append(makeText('span', asset.condition, `asset-condition ${conditionClass(asset.condition)}`));
                detail.append(item);
            });
        }

        function markerIcon(total) {
            return L.divIcon({
                className: '',
                html: `<div class="asset-marker">${total}</div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });
        }

        async function loadLocations() {
            const params = new URLSearchParams(new FormData(filters));
            markerLayer.clearLayers();
            count.textContent = '0';
            detail.innerHTML = '<div class="map-empty"><i class="bi bi-arrow-repeat"></i><strong>Memuat data lokasi…</strong></div>';

            try {
                const response = await fetch(`${endpoint}?${params.toString()}`, {
                    headers: {
                        Accept: 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal memuat data lokasi.');
                const payload = await response.json();
                const locations = payload.data || [];
                const bounds = [];

                locations.forEach((location) => {
                    const lat = parseFloat(location.latitude);
                    const lng = parseFloat(location.longitude);

                    if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                        const marker = L.marker([lat, lng], {
                            icon: markerIcon(location.asset_summary.total),
                            title: location.name
                        });
                        marker.on('click', () => showLocation(location));
                        marker.addTo(markerLayer);
                        bounds.push([lat, lng]);
                    }
                });

                count.textContent = bounds.length;

                if (bounds.length) {
                    map.fitBounds(bounds, {
                        padding: [45, 45],
                        maxZoom: 14
                    });
                    showLocation(locations[0]);
                } else {
                    detail.innerHTML = '<div class="map-empty"><i class="bi bi-geo-alt"></i><strong>Belum ada lokasi terpetakan</strong><span class="small mt-1">Tambahkan latitude dan longitude pada menu Lokasi untuk menampilkan marker.</span></div>';
                }

                // Refresh ukuran peta setelah data & bounds dimuat
                setTimeout(() => map.invalidateSize(), 200);

            } catch (error) {
                detail.innerHTML = '<div class="map-empty"><i class="bi bi-exclamation-circle"></i><strong>Data peta tidak dapat dimuat</strong><span class="small mt-1">Silakan muat ulang halaman.</span></div>';
            }
        }

        filters.addEventListener('submit', (event) => {
            event.preventDefault();
            loadLocations();
        });
        loadLocations();
    });
</script>
@endpush
