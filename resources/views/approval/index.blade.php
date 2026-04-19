<x-app-layout>
    <x-breadcrumb :title="__('Pengajuan')" subtitle="">
        <li class="breadcrumb-item"><a href="#">{{ __('Pengajuan') }}</a></li>
    </x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table class="datatables table table-striped"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-datatables-ajax>
        new DataTable('.datatables', {
            ajax:'{{ route('approval.data-json') }}',
            order: [[4, 'desc']],
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
                {
                    title: 'Aksi',
                    width: '150px',
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    render: function (data, type, row, meta) {
                        let Url = '{{ route("approval.show", ":id") }}';
                        let detailUrl = Url.replace(':id', data);
                        return `<div class="btn-group">\
                                <button class="btn btn-primary btn-sm" type="button" title="Detail" onclick="window.location.href='${detailUrl}'">Detail Pengajuan</button>\
                            </div>`;
                    }
                },
                {title: 'Judul', data: 'title', className: 'one-title'},
                {title: 'Estimasi Budget', data: 'budget', className: 'dt-right'},
                {title: 'Tanggal Pengajuan', data: 'sent_at', className: 'dt-center'},
                {title: 'Status', data: 'status', className: 'dt-center'}
            ]
        });
    </x-datatables-ajax>
</x-app-layout>