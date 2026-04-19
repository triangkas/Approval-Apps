<x-app-layout>
    <x-breadcrumb :title="__('Persetujuan')" :subtitle="$_action">
        <li class="breadcrumb-item"><a href="{{ route('approval.index') }}">{{ __('Persetujuan') }}</a></li>
        <li class="breadcrumb-item"><a href="#">{{ $_action }}</a></li>
    </x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <h5 class="bold">Detail Pengajuan</h5>
                                    <div class="table-responsive">
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
                                                            <a href="{{ $urlFile . $file->file_path }}"
                                                                target="_blank">{{ $file->file_path }}</a><br />
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
                                <div class="col-12 col-md-12">
                                    <h5 class="bold">Proses Persetujuan</h5>
                                    @if ($actApproval == 'already')
                                        <form method="POST" action="{{ route('approval.status', $detail->id) }}">
                                            @csrf
                                            <div class="form-group">
                                                <x-input-label for="status"
                                                    value='Status <span class="text-danger">*</span>' />
                                                <select class="form-control" name="status" id="status">
                                                    <option value="">Pilih Status</option>
                                                    <option value="approved"
                                                        @if (old('status') === 'approved') selected @endif>Setujui
                                                    </option>
                                                    <option value="rejected"
                                                        @if (old('status') === 'rejected') selected @endif>Tolak</option>
                                                </select>
                                                <x-input-error class="mt-2 text-danger" :messages="$errors->get('status')" />
                                            </div>
                                            <div class="form-group">
                                                <x-input-label for="comment" id="label-note" value='Catatan' />
                                                <textarea class="form-control" rows="5" name="comment">{{ old('comment', '') }}</textarea>
                                                <x-input-error class="mt-2 text-danger" :messages="$errors->get('comment')" />
                                            </div>
                                            <div class="button-group mt-2">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save mr-2"></i> Proses</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="location.href='{{ route('approval.index') }}'"><i
                                                        class="fas fa-undo-alt mr-2"></i> Kembali</button>
                                            </div>
                                        </form>
                                    @elseif($actApproval == 'not_yet')
                                        <div class="alert alert-warning text-center" role="alert">
                                            Belum dapat melakukan persetujuan karena masih menunggu proses dari level
                                            sebelumnya.
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center" role="alert">
                                            Sudah tidak dapat melakukan persetujuan.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script type="text/javascript">
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

        function updateLabelNote(value) {
            const labelNote = document.getElementById('label-note');

            if (value === 'rejected') {
                labelNote.innerHTML = 'Catatan <span class="text-danger">*</span>';
            } else {
                labelNote.innerHTML = 'Catatan';
            }
        }

        const statusSelect = document.getElementById('status');

        statusSelect.addEventListener('change', function() {
            updateLabelNote(this.value);
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateLabelNote(statusSelect.value);
        });
    </script>
</x-app-layout>
