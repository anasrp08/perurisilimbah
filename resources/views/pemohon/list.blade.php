@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Pemohon Limbah</title>
@section('title')
<h1>Daftar Pemohon Limbah </h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Pemohon Limbah</li>
@endsection


@section('content')

<!-- Main content --
<!-- Default box -->
{{-- <div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Filter Data</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div id="formkantor" class="form-group">
                    <label>Nama Limbah</label>
                    <select name="f_nmlimbah" id="f_nmlimbah" class="form-control select2bs4" style="width: 100%;">

                        <option value="" disabled selected>-Pilih Nama Limbah-</option>
                        @foreach($namaLimbah as $data)
                        <option value="{{$data->namalimbah}}">{{$data->namalimbah}} </option>
@endforeach
</select>
</div>

<div id="formkantor" class="form-group">
    <label>Jenis Limbah</label>
    <select name="f_jenislimbah" id="f_jenislimbah" class="form-control select2bs4" style="width: 100%;">
        <option value="" disabled selected>-Pilih Jenis Limbah-</option>
        @foreach($jenisLimbah as $data)
        <option value="{{$data->jenislimbah}}">{{$data->jenislimbah}} </option>
        @endforeach
    </select>
</div>
<div id="formkantor" class="form-group">
    <label>Fisik Limbah</label>
    <select name="f_fisiklimbah" id="f_fisiklimbah" class="form-control select2bs4" style="width: 100%;">
        <option value="" disabled selected>-Pilih Fisik Limbah-</option>
        @foreach($tipeLimbah as $data)
        <option value="{{$data->tipelimbah}}">{{$data->tipelimbah}} </option>
        @endforeach
    </select>
</div>


</div>
<!-- no surat -->
<div class="col-md-4">

    <div class="form-group">
        <label>Tanggal Mutasi Input </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control float-right" name="f_tglinput" id="f_tglinput">
        </div>

    </div>

    <div id="formkantor" class="form-group">
        <label>Asal Limbah</label>
        <select name="f_asallimbah" id="f_asallimbah" class="form-control select2bs4" style="width: 100%;">
            <option value="" disabled selected>-Pilih Asal Limbah-</option>
            @foreach($penghasilLimbah as $data)
            <option value="{{$data->seksi}}">{{$data->seksi}} ({{$data->departemen}}) </option>
            @endforeach}}
        </select>
    </div>
    <div id="formkantor" class="form-group">
        <label>TPS Limbah</label>
        <select name="f_tpslimbah" id="f_tpslimbah" class="form-control select2bs4" style="width: 100%;">
            <option value="" disabled selected>-Pilih TPS-</option>
            @foreach($tpsLimbah as $data)
            <option value="{{$data->namatps}}">{{$data->namatps}} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-4">

    <div id="formkantor" class="form-group">
        <label>Mutasi</label>
        <select name="f_mutasi" id="f_mutasi" class="form-control select2bs4" style="width: 100%;">

        </select>
    </div>
    <div id="formkantor" class="form-group">
        <label>Limbah 3R</label>
        <select name="f_limbah3r" id="f_limbah3r" class="form-control select2bs4" style="width: 100%;">
            <option value="" disabled selected>-Pilih Limbah 3R-</option>

            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>

        </select>
    </div>

</div>
<div class="card-footer">
    <button type="button" name="search" id="search" class="btn btn-success "><i class="fa  fa-search"></i>
        Filter</button>
</div>


</div>
</div>
<!-- /.box-body -->
</div> --}}

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_pemohon" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal</th>
                    <th>Nama Limbah</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Asal Limbah</th>
                    <th>Jenis Limbah (B3/Non)</th>
                    <th>Status</th> 
                    <th>Terima Oleh</th>
                    <th>Tervalidasi</th>
                    <th>Validasi Oleh</th> 
                </tr>
            </thead>

        </table>
    </div>
</div>

<!-- modal -->
@include('pemohon.f_confirmnp')

{{-- @include('layouts.confimdelete') --}}



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
     
        $('#entridate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#nonb3').hide()
        // $('.select2').select2()
        $('#jenislimbah').change(function () {
            if ($(this).val() == "Limbah B3") {
                $("#nonb3").hide();

            } else {
                $("#nonb3").show();

            }
        });



        $('#refresh').click(function () {

            $('#daftar_pemohon').DataTable().ajax.reload();

        })
        


        var table = $('#daftar_pemohon').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            paging:true,
            dom: '<"right"B>rtipl<"clear">',
            buttons: [
                {
                    text: 'Terima',
                    className: 'terima btn btn-success',
                    action: function (e, dt, node, config) {
                        // console.log(dt)
                        // console.log(config)
                        // console.log(e)
                        // console.log(node)
                        $('#title_konfirmasi').text('Diterima Oleh: ')
                        $('#hidden_transaksi').val('terima')
                        $('#modalconfirm').modal('show')

                    }


                },
                {
                    text: 'Validasi',
                    className: 'validasi btn btn-info',
                    action: function (e, dt, node, config) {
                        $('#title_konfirmasi').text('Divalidasi Oleh: ')
                        $('#hidden_transaksi').val('validasi')
                        $('#modalconfirm').modal('show')

                    }


                },
                {
                    extend: "selectAll",
                    text: 'Pilih Semua',
                    className: 'semua btn btn-default',
                },
                {
                    extend: 'selectNone',
                    text: 'Batal Pilih Semua',
                    className: 'batal btn btn-default',
                },
            ],
            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3, 4, 5,6,7,8,9]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            select: {
                style: 'multi'
            },
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('pemohon.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {





                }
            },
            // bFilter: false,
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
                        if (data == null || data == "-" || data == "0000-00-00 00:00:00" ||
                            data == "NULL") {
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
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'seksi',
                    name: 'seksi'
                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },

                // {
                //     data: 'limbah3r',
                //     name: 'limbah3r'

                // },

                {
                    data: 'keterangan',
                    name: 'keterangan',
                    render: function (data, type, row) {

                        if (data == 'Input') {
                            return '<span class="badge badge-info">' + data + '</span>'
                        } else {
                            return '<span class="badge badge-success">' + data + '</span>'
                        }
                    }
                },
                {
                    data: 'changed_by',
                    name: 'changed_by',
                    render: function (data, type, row) {
                    if (data == null) {
                            return '<span class="badge badge-info">-</span>'
                        } else {
                            return '<span class="badge badge-success">' + data + '</span>'
                        }
                    }
                },
                {
                    data: 'validated',
                    name: 'validated',
                    render: function (data, type, row) {
                        if (data == null) {
                            return '<span class="badge badge-info">Belum Validasi</span>'
                        } else {
                         return moment(data).format('DD/MM/YYYY');
                        }
                    }

                },
                {
                    data: 'validated_by',
                    name: 'validated_by',
                    render: function (data, type, row) {
                        // console.log(data)
                    if (data == null) {
                            return '<span class="badge badge-info">Belum Validasi</span>'
                        } else {
                            return data
                        }
                }

                },


                // {
                //     data: 'created_at',
                //     name: 'created_at',
                //     render: function (data, type, row) {

                //         return moment(data).format('DD/MM/YYYY');

                //     }
                // },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false

                // }
            ]
        });
        var buttonTerima = table.buttons( ['.terima'] );
        var buttonValidasi = table.buttons( ['.validasi'] );
        var buttonDatatable = table.buttons( ['.batal','.semua'] );
        

        var roleUser = '<?php echo Laratrust::hasRole("admin") ?>'
        var roleUnitKerja = '<?php echo Laratrust::hasRole("unit kerja") ?>'
        var rolePengawas = '<?php echo Laratrust::hasRole("pengawas") ?>'
        var roleOperator = '<?php echo Laratrust::hasRole("operator") ?>'
        if(roleUnitKerja == 1){
            buttonTerima.disable();
            buttonValidasi.disable();
            buttonDatatable.disable();
        }else if(rolePengawas==1){
            buttonTerima.disable();
        }else if(roleOperator==1){
            buttonValidasi.disable();
        }
        // console.log(loginInstansi)

        // buttons.disable();
        

        // new $.fn.dataTable.FixedColumns(table, {
        //     leftColumns: 3,
        //     heightMatch: 'auto'
        // });



        // $(document).on('click', '.delete', function () {
        //     user_id = $(this).data('id');
        //     $("#success-alert").hide();
        //     var data = table.row($(this).closest('tr')).data();

        //     $('#confirmModal').modal();

        // });
        $('#submit').on('click', function () {
            var output = [];
                        var jsonData = {}
                        var id = []
                        var nomor_order = []
                        var status = []
                        var dataSelected = []

                        var data1 = table.rows({
                            selected: true
                        }).data()
                        console.log(data1.toArray())
                        if (data1.count() == 0) {
                            toastr.warning('Ada Order Yang Belum Dipilih', 'Warning', {
                                timeOut: 5000
                            });
                        } else {
                            for(i=0;i<data1.count();i++){

                                var obj = {};
                                // console.log(value)
                                obj.limbah3r = data1[i].limbah3r;
                                obj.tgl = data1[i].tgl;
                                obj.id_transaksi = data1[i].id_transaksi;
                                obj.idmutasi = data1[i].idmutasi;
                                obj.idasallimbah = data1[i].idasallimbah;
                                obj.idlimbah = data1[i].idlimbah;
                                obj.idstatus = data1[i].idstatus;
                                obj.idjenislimbah = data1[i].idjenislimbah;
                                obj.jumlah = data1[i].jumlah;
                                obj.satuan = data1[i].idsatuan;
                                obj.np = $('#np').val();
                                obj.hiddenTransaksi = $('#hidden_transaksi').val();

                                output.push(obj);
                                jsonData["Order"] = output
                            }
                           
                        }
                        // var tipeTransaksi=('#hidden_transaksi').val()
                        var url=''
                        // if(tipeTransaksi=='terima'){
                        //     url="{{ route('pemohon.updatevalid') }}"
                        // }else{
                        //     url="{{ route('satpam.valid') }}"
                        // }


                        console.log(jsonData)
                        url="{{ route('pemohon.updatevalid') }}"
                        $.ajax({
                            url: url,
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: JSON.stringify(jsonData),
                            // contentType: 'json',
                            // cache: false,
                            // processData: false,
                            // dataType: "json",
                            beforeSend: function () {
                                $('#saveentri').text('proses menyimpan...');
                            },
                            success: function (data) {
                                // console.log(data)
                                if (data.errors) {
                                    toastr.success(data.errors, 'Success', {
                                        timeOut: 5000
                                    });
                                }
                                if (data.success) {
                                    toastr.success(data.success, 'Success', {
                                        timeOut: 5000
                                    });
                                    $('#daftar_pemohon').DataTable().ajax.reload();
                                    // $('#counterentries').text(data.count);

                                    $('#saveentri').text('Simpan');
                                    // $('#tblorder').DataTable().ajax.reload();
                                    // renderTgl()

                                }

                            }
                        })
                        $('#np').val('').change()
                        $('#modalconfirm').modal('toggle')
        })
        $('#daftar_pemohon tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });
        var user_id
        $(document).on('click', '.valid', function () {

            toastr.success('Data Berhasil Terupdate', {
                timeOut: 5000
            });
            user_id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            console.log(data)
            // updateValid(paramData)

        });


        // var user_id;
        // $('body').on('click', '.edit', function () {

        //     var id = $(this).data('id');
        //     var data = table.row($(this).closest('tr')).data();
        //     var tglCatat
        //     // var tglCatat = moment(data.tgl).format('DD/MM/YYYY');
        //     if (data.tgl == "-" || data.tgl == "0000-00-00 00:00:00" || data.tgl === null) {
        //         tglCatat = ""
        //     } else {
        //         tglCatat = moment(data.tgl).format('DD/MM/YYYY');
        //     }
        //     $('#jenislimbah').val(data.jenislimbah).change()
        //     $('#entridate').val(tglCatat)
        //     $('#satuan').val(data.satuan).change()
        //     $('#namalimbah').val(data.namalimbah).change()
        //     $('#fisiklimbah').val(data.fisik).change()
        //     $('#tps').val(data.tps).change()
        //     $('#limbahasal').val(data.asallimbah).change()
        //     $('#jmlhlimbah').val(data.jumlah)
        //     $('#limbah3r').val(data.limbah3r).change()
        //     $('#hidden_id').val(data.id)
        //     $('#jumlahlama').val(data.jumlah)
        //     $('#idnamalimbah').val(data.idnama)



        //     $('#formEdit').modal();




        // });

        // $('#edit_limbah').on('submit', function (event) {
        //     event.preventDefault();

        //         $.ajax({
        //             url: "{{ route('limbah.update') }}",
        //             method: "POST",
        //             data: new FormData(this),
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             dataType: "json",
        //             beforeSend: function () {
        //                 $('#action_button').val('menyimpan...');
        //             },
        //             success: function (data) {
        //                 var html = '';
        //                 if (data.errors) {
        //                     html = '<div id=error class="alert alert-danger">';
        //                     for (var count = 0; count < data.errors.length; count++) {
        //                         html += '<p>' + data.errors[count] + '</p>';
        //                     }
        //                     html += '</div>';
        //                     $('#form_result').html(html);
        //                     $('#action_button').val('Simpan');
        //                 }
        //                 if (data.success) {
        //                     toastr.success(data.success, 'Tersimpan', {
        //                         timeOut: 5000
        //                     });
        //                     $('#edit_limbah')[0].reset();
        //                     $('#action_button').val('Simpan');
        //                     $('#daftarlimbah').DataTable().ajax.reload();
        //                     setTimeout(function () {
        //                         $('#formEdit').modal('toggle');
        //                     }, 1000);
        //                 }
        //             }
        //         });

        // })
        function updateValid(paramData) {
            // $.ajax({
            //             url: "{{ route('limbah.update') }}",
            //             method: "POST",
            //             data: new FormData(this),
            //             contentType: false,
            //             cache: false,
            //             processData: false,
            //             dataType: "json",
            //             beforeSend: function () {
            //                 $('#action_button').val('menyimpan...');
            //             },
            //             success: function (data) {
            //                 var html = '';
            //                 if (data.errors) {
            //                     html = '<div id=error class="alert alert-danger">';
            //                     for (var count = 0; count < data.errors.length; count++) {
            //                         html += '<p>' + data.errors[count] + '</p>';
            //                     }
            //                     html += '</div>';
            //                     $('#form_result').html(html);
            //                     $('#action_button').val('Simpan');
            //                 }
            //                 if (data.success) {
            //                     toastr.success(data.success, 'Tersimpan', {
            //                         timeOut: 5000
            //                     });
            //                     $('#edit_limbah')[0].reset();
            //                     $('#action_button').val('Simpan');
            //                     $('#daftarlimbah').DataTable().ajax.reload();
            //                     setTimeout(function () {
            //                         $('#formEdit').modal('toggle');
            //                     }, 1000);
            //                 }
            //             }
            // });
        }



    })

</script>
@endsection
