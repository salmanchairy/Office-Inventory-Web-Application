<div class="col-12"><div class="location-form-label">Identitas lokasi</div></div>
<div class="col-md-6"><label class="form-label">Regional <span class="text-danger">*</span></label><input name="regional" class="form-control" value="{{ old('regional', $location?->regional) }}" placeholder="Contoh: Regional 1" required></div>
<div class="col-md-6"><label class="form-label">Site / Cabang</label><input name="site" class="form-control" value="{{ old('site', $location?->site) }}" placeholder="Contoh: Pelindo Regional 1"></div>
<div class="col-12 pt-2"><div class="location-form-label">Detail lokasi</div></div>
<div class="col-md-6"><label class="form-label">Gedung</label><input name="building" class="form-control" value="{{ old('building', $location?->building) }}" placeholder="Contoh: Gedung Utama"></div>
<div class="col-md-6"><label class="form-label">Ruang</label><input name="room" class="form-control" value="{{ old('room', $location?->room) }}" placeholder="Contoh: Server Room"></div>
<div class="col-12 pt-2"><div class="location-form-label">Koordinat peta <span>opsional</span></div></div>
<div class="col-md-6"><label class="form-label">Latitude</label><input type="number" name="latitude" class="form-control" value="{{ old('latitude', $location?->latitude) }}" step="0.0000001" min="-90" max="90" placeholder="Contoh: 3.595196"></div>
<div class="col-md-6"><label class="form-label">Longitude</label><input type="number" name="longitude" class="form-control" value="{{ old('longitude', $location?->longitude) }}" step="0.0000001" min="-180" max="180" placeholder="Contoh: 98.672226"></div>
<div class="col-12"><label class="form-label">Keterangan</label><textarea name="description" class="form-control" rows="2" placeholder="Catatan tambahan mengenai lokasi ini">{{ old('description', $location?->description) }}</textarea></div>
