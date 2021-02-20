@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

    #daftar_pack tbody tr {

        cursor: pointer;
    }

    .pihakketiga {
        display: none;
    }

    .nonpihakketiga {
        display: none;
    }

    .modal-lg {
        max-width: 75% !important;
    }

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Limbah Masuk TPS</title>
@section('title')
<h1>Daftar Limbah Masuk TPS</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Limbah Masuk TPS</li>
@endsection


@section('content')
<div class="row">
    @include('pemrosesan.f_tambah_proses')

    @include('pemrosesan.tbl_proses_lain')
</div>
<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:80%; ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Display File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body" style="height:550px; important!">
                {{-- <span id="form_result"></span> --}}
                <div id="pdfviewer" style="width:100%; height:100%;"></div>
            </div>
        </div>
    </div>
</div>
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Apakah Anda Yakin Untuk Menghapus Data Ini ? <span class="label label-warning" id="status"></span></h4>
                {{-- <div class="form-group">
                    <label>Alasan</label>
                    <input type="text" id="alasan" name="alasan" class="form-control"
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <label>NP</label>
                    <select name="np_pemroses" id="np_pemroses" class="form-control select2bs4"
                        style="width: 100%;">
                       
                        <option value="" disabled selected>-</option>
                        @foreach($np as $data)
                        <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                        @endforeach
                    </select>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
{{-- @include('layouts.edit_modal') --}}


{{-- @include('pemrosesan.f_confirmnp') --}}



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#tgl_proses').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#refresh').click(function () {

            $('#tbl_lain').DataTable().ajax.reload();

        })



        var table = $('#tbl_lain').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            //    dom: '<"right"B>rtipl<"clear">',

            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 2, 3]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            // select: true,
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('lain.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {}
            },
            // bFilter: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tgl_proses',
                    name: 'tgl_proses',
                    render: function (data, type, row) {
                        // console.log()
                        return moment(data).format('DD/MM/YYYY');

                    }
                },
                // {
                //     data: 'kadaluarsa',
                //     name: 'kadaluarsa',
                //     render: function (data, type, row) {
                //         var currDate = moment().format('DD/MM/YYYY');
                //         var day7 = moment(data).subtract(7, 'd').format('DD/MM/YYYY');

                //         var day3 = moment(data).subtract(3, 'd').format('DD/MM/YYYY');
                //         // console.log(currDate.to(day3));
                //         // console.log(currDate)
                //         if (currDate == day7) {
                //             return '<h5><span class="badge badge-warning">' + moment(data)
                //                 .format('DD/MM/YYYY') + '</span></h5>'
                //         } else if (currDate == day3) {
                //             return '<h5><span class="badge badge-danger">' + moment(data)
                //                 .format('DD/MM/YYYY') + '</span></h5>'
                //         } else {
                //             return moment(data).format('DD/MM/YYYY');
                //         }



                //     }
                // },
                {
                    data: 'nama_limbah',
                    name: 'nama_limbah',

                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                    // render: function (data, type, row) { 
                    //     return data+' '+row.satuan ;
                    //     //tambah menu, dashboard, proses pengurangan saldo TPS (by query)

                    // }

                },
                {
                    data: 'treatmen',
                    name: 'treatmen',

                },
                {
                    data: 'unit_penghasil',
                    name: 'unit_penghasil'
                },
                {
                    data: 'file',
                    name: 'file',
                    render: function (data, type, row) {

                        // console.log(row.filesuratperintah)
                        if (data == null || data == "" || data == "NULL") {
                            // return '<span class="label label-info">Lihat File</span>'
                            return '<span class="label bg-maroon"> Belum Ada File</span>'
                            // 12333.pdf
                        } else {
                            return '<button type="button" class="file btn btn-primary" data-toggle="modal" >Lihat File</button>';
                        }
                    }

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false

                }


            ]
        });

        $('#input_proseslain').on('submit', function (event) {
            event.preventDefault();
            if ($('#transaksi').val() != 'update') {

                $.ajax({
                    url: "{{ route('lain.proses') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        $('#submit').text('menyimpan...');
                    },
                    success: function (data) {
                        var html = '';
                        console.log(data)
                        if (data.errors) {
                            toastr.error(data.success, 'Gagal Terimpan', {
                                timeOut: 5000
                            });
                            $('#submit').text('Submit');
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Tersimpan', {
                                timeOut: 5000
                            });
                            $('#tbl_lain').DataTable().ajax.reload();
                            $('#submit').text('Submit');
                            $('#input_proseslain')[0].reset();
                            // $('#unit_penghasil').get(0).selectedIndex = 0;
                            $('#np_pemroses').get(0).selectedIndex = 0;
                            // window.location.reload() 
                        }

                    }
                })
            } else {
                $.ajax({
                    url: "{{ route('lain.update') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        $('#submit').text('menyimpan...');
                    },
                    success: function (data) {
                        var html = '';
                        console.log(data)
                        if (data.errors) {
                            toastr.error(data.success, 'Gagal Terimpan', {
                                timeOut: 5000
                            });
                            $('#submit').text('Submit');
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Tersimpan', {
                                timeOut: 5000
                            });
                            $('#tbl_lain').DataTable().ajax.reload();
                            $('#submit').text('Submit');
                            $('#input_proseslain')[0].reset();
                            $("#submit").removeClass("btn btn-warning");
                            $("#submit").addClass("btn btn-primary");
                            // $('#unit_penghasil').get(0).selectedIndex = 0;
                            $('#np_pemroses').get(0).selectedIndex = 0;
                            // window.location.reload() 
                        }

                    }
                })
            }






        })




        $(document).on('click', '.delete', function () {
            user_id = $(this).data('id');
            $("#success-alert").hide();
            var data = table.row($(this).closest('tr')).data();

            $('#confirmModal').modal();

        });
        $('#ok_button').click(function () {
            $.ajax({
                url: "/lain/destroy/" + user_id,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    toastr.success(data.success, 'Tersimpan', {
                        timeOut: 5000
                    });
                    setTimeout(function () {
                        $('#ok_button').text('OK');
                        $('#confirmModal').modal('hide');
                        $('#tbl_lain').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        $('body').on('click', '.edit', function () {
            $('#alasan').show();
            $("#submit").removeClass("btn btn-primary");
            $("#submit").addClass("btn btn-warning");
            $('#batal').show();
            var id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            $('#transaksi').val('update')
            $('#submit').text('Update')
            
            var tgl = moment(data.tgl_proses).format('DD/MM/YYYY');
            $('input[name="nama_limbah"]').val(data.nama_limbah);
            $('input[name="jmlh"]').val(data.jumlah);
            $('input[name="satuan"]').val(data.satuan);
            $('input[name="tgl_proses"]').val(tgl);
            $('input[name="treatmen"]').val(data.treatmen);
            $('input[name="keterangan"]').val(data.keterangan);

            $('select[name="np_pemroses"]').find('option[value="' + data.np_pemroses + '"]').attr(
                "selected", true).change();
            $('input[name="unit_penghasil"]').val(data.unit_penghasil)
             


            $('#hidden_id').val(data.id);
            $('#action').val("Edit");
            $('#action_button').val("Edit");


            // $.get('jadwal/' + id + '/edit', function (data) {
            //     console.log(data)
            //     $('#action').val("Edit");
            //     $('#action_button').val("Edit");
            //     $('#formEdit').modal('show');
            //     var tgl_srtkantor = moment(data.tgl_srtsidang).format('DD/MM/YYYY');
            //     var tgl_srtperintah = moment(data.tgl_pelaksanasidang).format(
            //         'DD/MM/YYYY');
            //     $('#nosurat').val(data.nosurat);
            //     // $('#petugas').val(data.petugas);
            //     $('#pilihuji').val(data.pilihuji).change();
            //     $('#kantor').val(data.kantor).change();
            //     $('#tglsuratkantor').val(tgl_srtkantor);
            //     $('#tglsuratperintah').val(tgl_srtperintah);
            //     $('#hidden_id').val(data.id);
            // })


        });


        $('#tbl_lain tbody').on('click', '.file', function () {
            var data1 = table.row($(this).parents('tr')).data();
            console.log(data1)
            $('#formModal').modal('show');
            $('#title').text('File Pemrosesan Lain');
            pdfViewer(data1.file)


        });

        function pdfViewer(data) {
            // return  document.getElementById("pdfviewer").innerHTML = '<iframe src ="{{ asset("project/public")}}' + data + '" style="width:100%; height:100%;"></iframe>';
            return document.getElementById("pdfviewer").innerHTML = '<iframe src ="{{ asset("")}}' + data +
                '" style="width:100%; height:100%;"></iframe>';
        }

        // $('#daftar_pack tbody').on('click', 'tr', function () {
        //     $(this).toggleClass('selected');
        // });
        var user_id




    })

</script>
@endsection
