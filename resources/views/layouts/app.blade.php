<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/image/favicon.png') }}">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <!--Internal Fileuploads js-->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fileuploads/css/fileupload.css') }}" type="text/css"/>
        <!-- datepicker3 -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}">
        <!-- daterangepicker -->
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.css') }}" />
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables JS -->
        <script src="{{ asset('assets/plugins/datatables/datatables.js') }}"></script>
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.css') }}">
        <!-- Theme style custom -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    </head>
    <body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <x-navbar-left />
                <x-navbar-right />
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <x-application-logo />
                <x-sidebar />
            </aside>  
            <div class="content-wrapper">
                {{ $slot }}
            </div>
            <footer class="main-footer">
                <x-footer />
            </footer>
        </div>
        
        <!-- Bootstrap -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- InputMask -->
        <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <!-- daterangepicker -->
        <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- datepicker3 -->
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <!--Internal Fileuploads js-->
        <script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
        <!-- Internal Tree js -->
		<script src="{{ asset('assets/plugins/treejs/tree.js') }}"></script>
        <!-- AdminLTE -->
        <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
        <!-- Alert -->
        @include('sweetalert::alert')
        <!-- Tinymce js  -->
		<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
		<script type="text/javascript">
            $('.select2').select2();
            $('[data-mask]').inputmask();
            $('.datepicker').attr("autocomplete", "off");
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
            });
            $('.rangedatepicker').attr("autocomplete", "off");
            $('.rangedatepicker').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
		</script>
        @yield('jsDatatables')
        @yield('js')
        @yield('js-extra')
    </body>
</html>
