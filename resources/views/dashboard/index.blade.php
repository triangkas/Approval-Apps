<x-app-layout>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4"
                        style="background: linear-gradient(135deg, #343a40, #6c757d); color: var(--white);">
                        <div class="card-body">
                            <h5>Selamat Datang di {{ config('app.name', 'Laravel') }}</h5>
                            <h6>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table class="datatables table table-striped"></table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5>Perbandingan Status Pengajuan</h5>
                            <div style="height: 250px;">
                                <canvas id="pieChart" style="display: inline" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-datatables-ajax>
        new DataTable('.datatables', {
            ajax:'{{ route('dashboard.data-json') }}',
            order: [[3, 'desc']],
            columns: [
                {
                    title: 'No.',
                    width: '30px',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {title: 'Judul', data: 'title', className: 'one-title'},
                {title: 'Estimasi Budget', data: 'budget', className: 'dt-right'},
                {title: 'Tanggal Pengajuan', data: 'sent_at', className: 'dt-center'},
                {title: 'Status', data: 'status', className: 'dt-center'}
            ],
            layout: {
                topStart: function () {
                    const div = document.createElement('div');
                    div.innerHTML = '<h5 class="mb-0">Data Pengajuan</h5>';
                    return div;
                }
            }
        });
    </x-datatables-ajax>

    @section('js')
        <script>
            const labels = @json($chart['labels']);
            const datasets = @json($chart['datasets']);
            const ctx = document.getElementById('pieChart').getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah data',
                        data: datasets,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        </script>
    @endsection
</x-app-layout>