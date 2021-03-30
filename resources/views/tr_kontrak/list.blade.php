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
<title>Report Kontrak Limbah</title>
@section('title')
<h1>Report Kontrak Limbah </h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Report Kontrak Limbah</li>
@endsection


@section('content')



<div class="row">
    <div class="col-md-4">
        @include('tr_kontrak.f_transaksi_anggaran')
    </div>
    <div class="col-md-8">
        <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link  active" id="home-tab" data-toggle="pill" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Daftar Pencatatan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="neraca-anggaran-tab" data-toggle="pill" href="#neraca-anggaran" role="tab"
                        aria-controls="neraca-anggaran" aria-selected="false">Neraca Anggaran</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"
                style="position: relative;">
                    @include('tr_kontrak.tbl_transaksi')

                </div>
                <div class="tab-pane fade" id="neraca-anggaran" role="tabpanel" aria-labelledby="neraca-anggaran-tab"
                style="position: relative;">
                @include('tr_kontrak.tbl_neraca_anggaran')
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
  
@include('layouts.confimdelete')



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $("#transaksi_tahun").val(moment().format('YYYY'))
        $(".numberinput").autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            aForm: true,
            vMax: '999999999999999',
            vMin: '-999999999999999'
        });

        $('input[name="f_tglinput"]').daterangepicker({
            format: 'DD/MM/YYYY',
            autoUpdateInput: false,
            autoclose: true,
            locale: {
                cancelLabel: 'Clear'
            }

        })
        $('input[name="f_tglinput"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                'DD/MM/YYYY'));
        });

        $("#transaksi_tipelimbah").change(function () {
            getDropdown('{{ route("kontrakb3.tipelimbah")}}', $(this).val(), $("#transaksi_tahun")
                .val())

        });
        var harga = 0

        function getDropdown(paramUrl, param1, param2) {

            var paramData
            paramData = {
                idtipe: param1,
                tahun: param2
            }

            $.ajax({
                url: paramUrl,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: paramData,
                success: function (data) {
                    console.log(data)
                    harga = data.dataHarga
                    $('#dataharga').val(numberWithCommas(data.dataHarga))
                    $('#labelharga').text('Harga / ' + data.dataSatuan)
                    $('#transaksi_total').val(numberWithCommas(data.md_kuota))
                }
            });

        }
        $('#jmlhlimbah').on('change', function () {
            // console.log(this)
            var valJumlah = $(this).val()
            // var harga = $('#dataharga').val()
            var result = parseInt(valJumlah) * parseInt(harga)
            console.log(result)
            $('#transaksi_konsumsi').val(numberWithCommas(result))
        })
        $('#refresh').click(function () {

            $('#daftar_transaksi').DataTable().ajax.reload();
        })
        $('#tambah_transaksi').on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(this)
            var label = $('#labelharga').text()
            var splitData = label.split(' / ')
            formData.append('satuan', splitData[1])
            $.ajax({
                url: "{{ route('kontrakb3.store') }}",
                method: "POST",
                //     headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    $('#simpan_transaksi').text('menyimpan...')
                    $('#simpan_transaksi').attr('disabled', true)
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        toastr.error('Data Gagal Di Simpan', 'Error Alert', {
                            timeOut: 5000
                        });
                    }
                    if (data.success) {
                        toastr.success('Data Berhasil Di Simpan', 'Success Alert', {
                            timeOut: 5000
                        });
                        $('#simpan_transaksi').text('Simpan');
                        $('#simpan_transaksi').attr('disabled', false);
                        $('#tambah_transaksi')[0].reset();
                        $('#daftar_transaksi').DataTable().ajax.reload();
                        $('#transaksi_tipelimbah').val('').change()
                        $('#transaksi_tahun').val(moment().format('YYYY'))
                        $('#transaksi_total').val('')
                        $('#transaksi_np').val('')
                        $('#transaksi_konsumsi').val('')

                    }
                }
            })
        })


        var table = $('#daftar_transaksi').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,

            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
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
                url: "{{ route('kontrakb3.daftar') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {

                    d.tahun = moment().format('YYYY');
                    // d.jenislimbah = $(":input[name=f_jenislimbah]").val();
                    // d.namalimbah = $(":input[name=f_nmlimbah]").val();
                    // d.tglinput = $('#f_tglinput').val();
                    // d.mutasi = $(":input[name=f_status]").val();
                    // d.fisik = $(":input[name=f_fisiklimbah]").val();
                    // d.asallimbah = $(":input[name=f_asallimbah]").val();
                    // d.tpslimbah = $(":input[name=f_tpslimbah]").val();
                    // d.limbah3r = $(":input[name=f_limbah3r]").val();


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
                    data: 'tipelimbah',
                    name: 'tipelimbah',

                },
                {
                    data: 'konsumsi',
                    name: 'konsumsi',
                    render: function (data, type, row) {
                        // var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)
                        return numberWithCommas(data)
                        // return data
                    }
                },
                {
                    data: 'tahun',
                    name: 'tahun',

                },
                {
                    data: 'np',
                    name: 'np',
                    render: function (data, type, row) {
                        // var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)

                        return data + ' - ' + row.nama

                    }
                },

                {
                    data: 'tgl_dibuat',
                    name: 'tgl_dibuat',
                    render: function (data, type, row) {
                        return moment(data).format('DD-MM-YYYY')
                    }

                },


                {
                    data: 'action',
                    name: 'action',

                },

            ],
            drawCallback: function (settings, json) {
                $('.edit').hide();
            }
        });
        
        var table_neraca = $('#neraca_anggaran').DataTable({
            processing: true,
            serverSide: true,
            // scrollCollapse: true,
            // scrollX: true,

            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
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
                url: "{{ route('neraca_kontrak.daftar') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {

                    d.tahun = moment().format('YYYY');
                    // d.jenislimbah = $(":input[name=f_jenislimbah]").val();
                    // d.namalimbah = $(":input[name=f_nmlimbah]").val();
                    // d.tglinput = $('#f_tglinput').val();
                    // d.mutasi = $(":input[name=f_status]").val();
                    // d.fisik = $(":input[name=f_fisiklimbah]").val();
                    // d.asallimbah = $(":input[name=f_asallimbah]").val();
                    // d.tpslimbah = $(":input[name=f_tpslimbah]").val();
                    // d.limbah3r = $(":input[name=f_limbah3r]").val();


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
                    data: 'tipelimbah',
                    name: 'tipelimbah',

                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    render: function (data, type, row) {
                        // var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)
                        return numberWithCommas(data)
                        // return data
                    }
                },
                {
                    data: 'jumlah_konsumsi',
                    name: 'jumlah_konsumsi',
                    render: function (data, type, row) {
                        // var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)
                        if (data == "" || data == null) {
                            return 0
                        } else {
                            return numberWithCommas(data)
                        }

                    }
                },
                {
                    data: 'sisa',
                    name: 'sisa',
                    render: function (data, type, row) {
                        // var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)
                        if (data == "" || data == null) {
                            return 0
                        } else {
                            return numberWithCommas(row.jumlah - row.jumlah_konsumsi)
                        }
                    }
                },

                {
                    data: 'tahun',
                    name: 'tahun'

                },

                {
                    data: 'sisa',
                    name: 'sisa',
                    render: function (data, type, row) {
                        // console.log(row.konsumsi)
                        var totalKuota = parseInt(row.konsumsi) + parseInt(row.sisa)
                        var kuota_danger = Math.round(parseInt(totalKuota) * parseInt(90) /
                            parseInt(100))
                        var kuota_warning = Math.round(parseInt(totalKuota) * parseInt(75) /
                            parseInt(100))

                        if (row.konsumsi == 0) {
                            return '<span class="badge badge-success">Aman</span>'
                        }

                        if (parseInt(row.konsumsi) >= kuota_warning && parseInt(row.konsumsi) <=
                            kuota_danger) {
                            return '<span class="badge badge-warning">Waspada</span>'
                        } else if (parseInt(row.konsumsi) > kuota_danger) {
                            return '<span class="badge badge-danger">Bahaya</span>'
                        } else {
                            return '<span class="badge badge-success">Aman</span>'
                        }



                    }
                },
                

            ]
        });

        table_neraca.columns.adjust().draw();





        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }


        // new $.fn.dataTable.FixedColumns(table, {
        //     leftColumns: 3,
        //     heightMatch: 'auto'
        // });



        $(document).on('click', '.delete', function () {
            user_id = $(this).data('id');
            $("#success-alert").hide();
            var data = table.row($(this).closest('tr')).data();

            $('#confirmModal').modal();

        });

        $('#ok_button').click(function () {
            // console.log(user_id)
            $.ajax({
                url: "/kontrakb3/destroy/" + user_id,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    toastr.success('Data Berhasil Di Hapus', 'Terhapus', {
                        timeOut: 5000
                    });
                    setTimeout(function () {
                        $('#ok_button').text('OK');
                        $('#confirmModal').modal('hide');
                        $('#daftar_transaksi').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });




    })

</script>
@endsection
