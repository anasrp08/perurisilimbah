@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Entri Data Limbah</title>
@section('title')
<h1>Entri Permohonan Angkut Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Entri Data</li>

@endsection

@section('content')


<!-- Main content -->

{{-- <div class="callout callout-info">
        <h4>Info!</h4>

        <p>Pilih Jenis Uji Mini Lab Jika ingin memasukkan data pengujian Mini Lab</p>
        <p>Pilih Jenis Uji Bantuan Ahli Jika ingin memasukkan data pengujian Bantuan ahli</p>
    </div> --}}
<div class="row">
    
    <div class="col-md-8">
        <div class="card card-info">
            <div class="card-header">
                <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-sync"></i>
                    Refresh</button>
            </div>
            <div class="card-body">
                <table id="daftarlimbah" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Limbah</th>
                            <th>Jumlah</th>
                            <th>Jenis Limbah (B3/Non)</th>
                            <th>Fisik</th>

                            <th>Tanggal Permohonan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Limbah Sludge</td>
                            <td>300 karung</td>
                            <td>Limbah B3</td>
                            <td>Padat</td>
                            <td>07/08/2020</td>
                            <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                        </tr>
                        <td>2</td>
                        <td>Limbah Sludge</td>
                        <td>100 liter</td>
                        <td>Limbah B3</td>
                        <td>Cair</td>
                        <td>20/08/2020</td>
                        <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                        </tr>
                        <td>3</td>
                        <td>Limbah Sludge</td>
                        <td>400 Kaleng</td>
                        <td>Limbah B3</td>
                        <td>Padat</td>
                        <td>20/08/2020</td>
                        <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                        </tr>
                        <td>4</td>
                        <td>Limbah Sludge</td>
                        <td>100 Drum</td>
                        <td>Limbah B3</td>
                        <td>Padat</td>
                        <td>27/08/2020</td>
                        <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#nonb3').hide()
        // if ($('#suratperintah').is(':visible')) {

        //    if (isEmpty("tglsuratperintah")) {
        //        if (isEmpty("filesuratperintah")) {

        //            sentData(this)
        //        } 
        //    } 

        $('#jenislimbah').change(function () {
            if ($("#jenislimbah option:selected").index() == 1) {
                $("#nonb3").hide();
            } else {
                $("#nonb3").show();

            }
        });

        $('#entridate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        function isEmpty(comp) {
            if ($("#" + comp).val() == "") {
                var html = '';
                html = '<div class="alert alert-danger">' +
                    '<p>Form ' + comp + ' kosong</p>' +

                    '</div>';
                $('#form_result').html(html);
                return false
            } else {
                return true
            }
        }
        $("#fisiklimbah").change(function () {
            getDropdown('{{ route("limbah.getnama")}}', $('#jenislimbah').val(), $(this).val(),
                "namalimbah")

        });
        $("#namalimbah").change(function () {
            getDropdown('{{ route("limbah.getsatuan")}}', "", $(this).val(), "satuan")

        });


        // function getDropdown(paramUrl, param, idkomponen) {
        //     var url = paramUrl;
        //     url = url.replace(':id', param);
        //     $.ajax({
        //         url: url,
        //         method: 'GET',

        //         success: function (data) {

        //             $("#" + idkomponen).html(data.html);
        //         }
        //     });

        // }
        function getDropdown(paramUrl, param1, param2, idkomponen) {
            // var url = paramUrl;
            // url=    ;
            // url=url.replace(':fisik', fisik);
            // console.log(url)
            var paramData
            if (idkomponen == 'namalimbah') {
                paramData = {
                    jenis: param1,
                    fisik: param2
                }
            } else {
                paramData = {
                    namalimbah: param2
                }
            }

            $.ajax({
                url: paramUrl,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: paramData,
                success: function (data) {

                    $("#" + idkomponen).html(data.html);
                }
            });

        }
        $('#input_limbah').on('submit', function (event) {
            event.preventDefault();
            if ($('#nonb3').is(':visible')) {

                if (isEmpty("limbah3r")) {


                    sentData(this)

                }
            } else {
                sentData(this)
            }

            function sentData(tes) {
                $.ajax({
                    url: "{{ route('limbah.store') }}",
                    method: "POST",
                    data: new FormData(tes),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        $('#action_button').val('menyimpan...');
                    },
                    success: function (data) {
                        var html = '';
                        console.log(data)
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_result').html(html);
                            $('#action_button').val('Submit');
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Tersimpan', {
                                timeOut: 5000
                            });
                            $('#input_limbah')[0].reset();
                            $('#action_button').val('Simpan');
                            // $('#pilihuji').get(0).selectedIndex = 0;
                            window.location.reload()

                            $('#form_result').html('');
                        }

                    }
                })
            }

        })

        var table = $('#daftarlimbah').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,

            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('limbah.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {


                    d.jenislimbah = $(":input[name=f_jenislimbah]").val();
                    d.namalimbah = $(":input[name=f_nmlimbah]").val();
                    d.tglinput = $('#f_tglinput').val();
                    d.mutasi = $(":input[name=f_status]").val();
                    d.fisik = $(":input[name=f_fisiklimbah]").val();
                    d.asallimbah = $(":input[name=f_asallimbah]").val();
                    d.tpslimbah = $(":input[name=f_tpslimbah]").val();
                    d.limbah3r = $(":input[name=f_limbah3r]").val();


                }
            },
            bFilter: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tgl',
                    name: 'tgl',
                    render: function (data, type, row) {
                        if (data == null || data == "-" || data == "0000-00-00 00:00:00" || data == "NULL") {
                            return '<span>-</span>'
                        } else {
                            return moment(data).format('DD/MM/YYYY');
                        }

                    }
                },
                {
                    data: 'namalimbah',
                    name: 'namalimbah'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                // {
                //     data: 'satuan',
                //     name: 'satuan'
                // },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                {
                    data: 'fisik',
                    name: 'fisik'

                },
                // {
                //     data: 'limbah3r',
                //     name: 'limbah3r'

                // },

                {
                    data: 'mutasi',
                    name: 'mutasi',
                    render: function (data, type, row) {

                        if (data == 'Input') {
                            return '<span class="badge badge-info">' + data + '</span>'
                        } else {
                            return '<span class="badge badge-success">' + data + '</span>'
                        }
                    }
                },
                {
                    data: 'tps',
                    name: 'tps',
                    
                },

                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data, type, row) {

                        return moment(data).format('DD/MM/YYYY');

                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false

                }
            ]
        });

    })

</script>
@endsection
