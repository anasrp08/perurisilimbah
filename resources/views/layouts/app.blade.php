<!DOCTYPE html>
<html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMBAH</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="icon" type="image/png" href="{{ asset('/img/logo.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/adminlte3/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/adminlte3/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/otherplugin/select/select1.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/otherplugin/button/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/otherplugin/twitter/bootstrap1.css')}}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/otherplugin/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/adminlte3/plugins/otherplugin/rowgroup/rowGroup.bootstrap4.min.css')}}">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"> --}} 
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('/adminlte3/plugins/otherplugin/fontgooglecss.css')}}" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>



            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge" id="jumlahnotif">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " id='divkapasitas'>

                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Simbah</span>
            </a>

            <!-- Sidebar -->

            <div class="sidebar">
                @if (Auth::check())
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/img/'. auth()->user()->avatar) }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{auth()->user()->email}}</a>
                    </div>
                </div>
                @else
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/img/logo.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">user</a>
                    </div>
                </div>
                @endif
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @include('layouts.sidebar')

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('title')
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {!! date("Y") !!} <a href="#">Peruri</a>.</strong> All rights reserved.
        </footer>

        {{-- <script src="{{ asset('/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/adminlte3/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">

        </script>
        <!-- Bootstrap -->
        <script src="{{ asset('/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('/adminlte3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/adminlte3/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('/adminlte3/dist/js/demo.js') }}"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{{ asset('/adminlte3/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/moment/moment.min.js')}}"></script>
        <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script> --}}
 
        <script src="{{ asset('/adminlte3/plugins/jquery/jquery.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('/adminlte3/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
        </script>
        <!-- Bootstrap -->
        <script src="{{ asset('/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('/adminlte3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/adminlte3/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('/adminlte3/dist/js/demo.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/gijgo/gijgo.min.js')}}" type="text/javascript"></script>
        <link href="{{ asset('/adminlte3/plugins/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{{ asset('/adminlte3/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>


        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
        <script src="{{ asset('/adminlte3/plugins/otherplugin/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/otherplugin/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/otherplugin/rowgroup/dataTables.rowGroup.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/otherplugin/select/dataTables.select1.min.js') }}"></script> 
        <script src="{{ asset('/adminlte3/plugins/otherplugin/button/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('/adminlte3/plugins/otherplugin/autoNumeric.js') }}"></script>

        <script>
            $(document).ready(function () {
                var pProv = {

                    tahun: moment().format('YYYY')
                }
                $.ajax({
                    url: "{{ route('notifikasi.data') }}",
                    method: "POST",
                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "accept": "application/json",
                        "Access-Control-Allow-Origin": "*"
                    },
                    data: pProv,
                    dataType: "json",

                    success: function (data) { 
                        var cekdata = data.dataNotifikasi
                        var dataKapasitas = data.notifikasiKapasitas
                        var arrSum = parseInt(0)
                        var arrSumKadaluarsa = parseInt(0)
                        var arrKapasitas = parseInt(0)
                        if (data.role == 'operator' || data.role == 'admin') {


                            if (cekdata == null && dataKapasitas.length == 0) {
                                $('#jumlahnotif').text(0)
                                $('#divkapasitas').append('<a href="#" class="dropdown-item">' +
                                    '</i>Tidak Ada Notifikasi</a>');
                            } else {
                                if (cekdata != null) {
                                    var dataValues = data.dataNotifikasi.values
                                    var dataKapasitas = data.notifikasiKapasitas
                                    var dataTangal = data.dataNotifikasikeys
                                    
                                    for (i = 0; i < dataValues.length; i++) {
                                        arrSum += parseInt(dataValues[i].jumlah)
                                        arrSumKadaluarsa += parseInt(dataValues[i].jumlah)

                                        
                                        $('#divkapasitas').append(
                                            '<a href="#" class="dropdown-item">' +
                                            '<i class="far fa-bell"></i> ' + dataValues[i]
                                            .jumlah +
                                            " Limbah <br>Kadaluarsa Tanggal " + moment(
                                                dataValues[i]
                                                .tanggal).format('DD/MM/YYYY') + '</a>');
                                    }
                                    toastr.error('Ada limbah akan kadaluarsa', 'Perhatian', {
                                        timeOut: 5000
                                    });
                                } else {
                                    // $('#divkapasitas').append('<a href="#" class="dropdown-item">'+
                                    //     '<i class="far fa-bell"></i>-</a>');
                                }


                                if (dataKapasitas.length != 0) {
                                    arrSum += dataKapasitas.length
                                    arrKapasitas += dataKapasitas.length
                                    for (j = 0; j < dataKapasitas.length; j++) {
                                        $('#divkapasitas').append(
                                            '<a href="#" class="dropdown-item">' +
                                            '<i class="far fa-bell"></i> ' + dataKapasitas[j]
                                            .tps +
                                            ' - ' + dataKapasitas[j].saldo + '/' +
                                            dataKapasitas[j]
                                            .kapasitas + " <br>Status " + dataKapasitas[j]
                                            .status +
                                            '</a>');

                                    }
                                    toastr.error(arrKapasitas + ' Kapasitas Akan Penuh',
                                        'Perhatian', {
                                            timeOut: 5000
                                        });
                                } else {
                                    // $('#divkapasitas').append('<a href="#" class="dropdown-item">'+
                                    //     '<i class="far fa-bell"></i>-</a>');
                                }

                                $('#jumlahnotif').text(arrSum)
                                $('#jmlhnotif').text(arrSum + ' Notifikasi')

                            }



                        }

                    }

                });

                var handle = setInterval(setNotification, 30000);
                // setNotification()
                var paramStatus = []


                function setNotification() {

                    var pProv = {

                        tahun: moment().format('YYYY')
                    }
                    $.ajax({
                        url: "{{ route('notifikasi.masuk') }}",
                        method: "POST",
                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "accept": "application/json",
                            "Access-Control-Allow-Origin": "*"
                        },
                        data: pProv,
                        dataType: "json",

                        success: function (data) {
                            // console.log(data)
                            if (data.notifMasuk > 0) {

                                if (data.role == 'operator') {

                                    toastr.info('ada ' + data.notifMasuk +
                                        ' Permintaan Angkut Limbah',
                                        'Informasi Belum Diterima', {
                                            timeOut: 3000,
                                            positionClass: "toast-top-left",
                                        });
                                }else if(data.role == 'pengawas'){
                                    toastr.info('ada ' + data.notifMasuk +
                                        ' Permintaan Angkut Limbah Belum Tervalidasi',
                                        'Informasi', {
                                            timeOut: 3000,
                                            positionClass: "toast-top-left",
                                        });
                                }

                            }

                            if(data.notifValidasiBA > 0){
                                if(data.role == 'pengawas' || data.role == 'unit kerja'){
                                toastr.info('ada ' + data.notifValidasiBA +
                                        ' Permintaan Validasi Berita Acara Pemusnahan', {
                                            timeOut: 5000,
                                            positionClass: "toast-top-left",
                                        });
                                }

                            }


                        }
                    });
                }
                // function myStopFunction() {
                //         clearInterval(handle);
                //         handle = 0;
                //         }
                // toastr.options.onclick = function () {
                //     myStopFunction()

                //     var url = "";
                //     document.location.href = url;
                // }
            })

        </script>


        @yield('scripts')
</body>

</html>
