@section('jsDatatables')
    <script type="text/javascript">
        Object.assign(DataTable.defaults, {
            processing: true,
            serverSide: true,
            responsive: false,
            pageLength: 10,
            bLengthChange: true,
            bInfo: true,
            pagingType: 'simple_numbers',
            language: {
                lengthMenu:   "Jumlah baris _MENU_ data",
                zeroRecords:  "Data tidak ditemukan",
                info:         "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty:    "Menampilkan 0 dari 0 data",
                infoFiltered: "(pencarian dari _MAX_ total data)",
                sSearch: "",
                searchPlaceholder: "Pencarian...",
                loadingRecords: "",
                processing: "Memuat data...",
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            },
            layout: {
                topStart: '',
                topEnd: 'search',
                bottomStart: ['info', 'pageLength'],
                bottomEnd: 'paging',
             },
            "initComplete": function(settings, json){
                $('.btn-add').removeClass('dt-button').addClass('btn btn-sm btn-primary');
                $('.dt-search input').addClass('form-control form-control-sm form-control-datatable');
                $('.dt-length label').addClass('font-weight-normal mb-0');
                $('.dt-length select').addClass('form-control form-control-sm ml-1 mr-1 d-inline-block').css('width', 'auto');
                $('table.dataTable').wrap('<div class="table-responsive"></div>');
            },
            order: {name: 'created_at', dir: 'desc'},
        });
      
        {{ $slot }}

        $(".dt-orderable-none").removeClass("dt-ordering-asc");
   </script>
@endsection