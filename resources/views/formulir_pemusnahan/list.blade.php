@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Formulir Pemusnahan Limbah</title>
@section('title')
<h1>Daftar Formulir Pemusnahan Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Formulir Pemusnahan</li>

@endsection

@section('content')



<div class="row">
    {{-- @include('pemohon.f_pemohon') --}}
    @include('formulir_pemusnahan.tbl_formulir')
</div>

{{-- @include('formulir_pemusnahan.tbl_formulir') --}}
@include('formulir_pemusnahan.f_confirmnp')


@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var seksi = '<?php echo $username->seksi ?>'
       
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#refresh').click(function () {

            $('#tbl_formulir').DataTable().ajax.reload();

        })
        var table = $('#tbl_formulir').DataTable({
            scrollCollapse: true,
            scrollX: true,
            dom: '<"right"B>frtipl<"clear">',
            buttons: [{
                text: 'Validasi',
                className: 'validasi btn btn-info',
                action: function (e, dt, node, config) {
                    $('#title_konfirmasi').text('Divalidasi Oleh: ')
                    $('#hidden_transaksi').val('validasi')
                    $('#modalconfirm').modal('show')
                }
            }, ],
            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('ba_pemusnahan.daftar') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {
                    d.idasallimbah=seksi
                }
            },
            // dom: 'Bfrti',
            select: {
                style: 'multi'
            },

            language: {
                emptyTable: "Tidak Ada Data"
            },
            order: [
                [0, 'asc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'seksi',
                    name: 'seksi'
                },

                {
                    data: 'no_surat',
                    name: 'no_surat'
                },
                {
                    data: 'no_ba_pemusnahan',
                    name: 'no_ba_pemusnahan'
                },
                {
                    data: 'tgl_pemrosesan',
                    name: 'tgl_pemrosesan',
                    render: function (data, type, row) {
                        if (data == null || data == "" || data == "NULL") {
                            return '-'
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
                    data: 'jenislimbah',
                    name: 'jenislimbah'
                },
                {
                    data: 'pemohon_validasi',
                    name: 'pemohon_validasi',
                    render: function (data, type, row) {
                        if(data == null || row.validated_pemohon == null){
                            return 'Belum Divalidasi'
                        }else{
                            return 'Oleh: '+data +'\n'+'Pada: '+moment(row.validated_pemohon).format('DD/MM/YYYY HH:mm:ss')
                        }
                       
                    }
                },
                {
                    data: 'pengawas_validasi',
                    name: 'pengawas_validasi',
                    render: function (data, type, row) {
                        if(data == null || row.validated_pengawas == null){
                            return 'Belum Divalidasi'
                        }else{
                            return 'Oleh: '+data +'\n'+ 'Pada: '+moment(row.validated_pengawas).format('DD/MM/YYYY HH:mm:ss')
                        }
                        
                    }
                },

                {
                    data: 'keterangan_status',
                    name: 'keterangan_status',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },

            ]

        });

        $('#tbl_formulir tbody').on('click', '.validasi', function () {

            var dataRow = table.row($(this).parents('tr')).data();
            console.log(dataRow)
            if (seksi == dataRow.idasallimbah || seksi == 'admin' || seksi == 'operator' || seksi ==
                'pengawas') {
                var url =

                    '{{ route("ba_pemusnahan.cetak",[":id"])}}';
                url = url.replace(":id", dataRow.id_detail);
                document.location.href = url;
            } else {
                toastr.warning('User yang dipakai tidak diijinkan', 'Perhatian', {
                    timeOut: 5000
                });
            }
        });

        $('#tbl_formulir tbody').on('click', '.download', function () {

            var dataRow = table.row($(this).parents('tr')).data();
            console.log(dataRow)
            if (seksi == dataRow.idasallimbah || seksi == 'admin' || seksi == 'operator' || seksi ==
                'pengawas') {
                var url =

                    '{{ route("ba_pemusnahan.cetak",[":id"])}}';
                url = url.replace(":id", dataRow.id_detail);
                document.location.href = url;
            } else {
                toastr.warning('User yang dipakai tidak diijinkan', 'Perhatian', {
                    timeOut: 5000
                });
            } 
        });
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

                for (i = 0; i < data1.count(); i++) {

                    var obj = {};
                    obj.idmutasi = data1[i].idmutasi
                    obj.id_detail = data1[i].id_detail
                    obj.np = $('#np').val();
                    output.push(obj);
                    jsonData["Order"] = output



                }
                var url = ''
                console.log(jsonData)
                url = "{{ route('ba_pemusnahan.validasi') }}"
                $.ajax({
                    url: url,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    data: JSON.stringify(jsonData),
                 
                    beforeSend: function () {
                        $('#submit').text('proses menyimpan...');
                        $('#submit').prop('disabled', true);
                    },
                    success: function (data) {

                        if (data.errors) {
                            toastr.success(data.errors, 'Success', {
                                timeOut: 5000
                            });
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Success', {
                                timeOut: 5000
                            });
                            $('#tbl_formulir').DataTable().ajax.reload();


                            $('#submit').text('Submit');
                            $('#submit').prop('disabled', false);


                        }

                    }
                })
                $('#np').val('').change()
                $('#modalconfirm').modal('toggle')

            }

        })



    })

</script>
@endsection
