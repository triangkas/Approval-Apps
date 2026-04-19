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
            ajax:'{{ route('request.data-json') }}',
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
                        let updateUrl = '{{ route("request.edit", ":id") }}';
                        let editUrl = updateUrl.replace(':id', data);
                        return `<div class="btn-group">\
                                <button class="btn btn-dark btn-sm" type="button" title="Detail" onclick="detailData('${data}')"><i class="fa fa-book-reader"></i></button>\
                                <button class="btn btn-info btn-sm" type="button" title="Edit" onclick="window.location.href='${editUrl}'"><i class="fa fa-pen"></i></button>\
                                <button class="btn btn-danger btn-sm" type="button" title="Hapus" onclick="confirmDelete('${data}')"><i class="fa fa-trash"></i></button>\
                            </div>`;
                    }
                },
                {title: 'Judul', data: 'title', className: 'one-title'},
                {title: 'Estimasi Budget', data: 'budget', className: 'dt-right'},
                {title: 'Tanggal Pengajuan', data: 'sent_at', className: 'dt-center'},
                {title: 'Status', data: 'status', className: 'dt-center'}
            ],
            layout: {
                topStart: {
                    buttons: [
                        {
                            text: '<i class="fa fa-plus mr-2"></i>Tambah',
                            className: 'btn-add',
                            action: function (e, dt, node, config) {
                                window.location.href = '{{ route('request.create') }}';
                            }
                        }
                    ]
                }
            }
        });
    </x-datatables-ajax>
    <x-modal-detail url="{{ route('request.show', ':id') }}" />
    <x-modal-delete method="delete" url="{{ route('request.destroy', ':id') }}" />
</x-app-layout>