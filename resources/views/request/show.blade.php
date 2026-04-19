<div class="col-12 table-responsive">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td width="30%">Judul</td>
                <td width="70%">{{ $detail->title }}</td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>{{ $detail->description }}</td>
            </tr>
            <tr>
                <td>Estimasi Budget</td>
                <td>{{ number_format($detail->budget, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Koordinat Lokasi</td>
                <td>
                    <div id="map" style="height:200px;"></div>
                </td>
            </tr>
            <tr>
                <td>Dokumen</td>
                <td>
                    @foreach($files as $file)
                        <a href="{{ $urlFile.$file->file_path }}" target="_blank">{{ $file->file_path }}</a><br />
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    const lat = parseFloat(@json($detail->latitude));
    const lng = parseFloat(@json($detail->longitude));
    const name = @json($detail->title);

    const map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    L.marker([lat, lng])
        .addTo(map)
        .bindPopup(`<b>${name}</b><br>
        <a target="_blank" href="https://www.google.com/maps?q=${lat},${lng}">
            Buka di Google Maps
        </a>`)
        .openPopup();
</script>