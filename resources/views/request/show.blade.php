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
                    @foreach ($files as $file)
                        <a href="{{ $urlFile . $file->file_path }}" target="_blank">{{ $file->file_path }}</a><br />
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($detail->status == 'waiting')
                        @if ($detail->approval_level == '0')
                            <span class="badge badge-warning">Menunggu
                                Persetujuan</span>
                        @else
                            <span class="badge badge-info">Disetujui oleh
                                {{ $detail->level->user->name }}</span>
                        @endif
                    @elseif($detail->status == 'approved')
                        <span class="badge badge-success">Disetujui oleh semua
                            pihak</span>
                    @elseif($detail->status == 'rejected')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-secondary">Draft</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="col-12 col-md-12">
    <h5 class="bold">Riwayat Persetujuan</h5>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Approver</th>
                    <th>Status</th>
                    <th>Waktu Proses</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @if ($histories->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Belum ada riwayat
                            persetujuan</td>
                    </tr>
                @else
                    @foreach ($histories as $history)
                        <tr>
                            <td>{{ $history->user->name }}</td>
                            <td>
                                @if ($history->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($history->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime($history->created_at)) }}
                            </td>
                            <td>{{ $history->comment }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
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
