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


<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
        {{-- <button type="button" name="download" id="download" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Download Excel</button> --}}
        <button type="button" name="tambah" id="tambah" class="btn btn-success "><i class="fa  fa-plus"></i>
            Tambah Master Data Kuota Anggaran</button>
        {{-- <button type="button" name="transaksi" id="transaksi" class="btn btn-success "><i class="fa  fa-save"></i>
            Transaksi Konsumsi Anggaran</button> --}}
    </div>
    <div class="card-body">
        <table id="daftar_kuota" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tipe Limbah</th>
                    <th>Total</th>
                    <th>Konsumsi</th>
                    <th>Sisa</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th width="30%">Action</th>
                </tr>
            </thead>

        </table>
    </div>
</div>

<!-- modal -->
@include('report.f_edit_data')
@include('report.f_tambah_data')
@include('report.f_transaksi_anggaran')
@include('layouts.confimdelete')



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
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


        $('#refresh').click(function () {

            $('#daftar_kuota').DataTable().ajax.reload();
        })
        $('#tambah').click(function () {
            $('#tambahData').modal();
        })
        // $('#download').click(function () {})
        $(document).on('click', '.edit', function () {
            user_id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            $('#tipelimbah').val(data.tipe_limbah).change()
            $('#tahun').val(data.tahun)
            var addSeparator = numberWithCommas(data.jumlah)
            $('#total').val(addSeparator)
            $('#np').val(data.np).change()
            $('#hidden_id').val(data.id)

            $('#modalEdit').modal();

        });


        $(document).on('click', '.transaksi', function () {
            user_id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            // var addSeparator=numberWithCommas(data.jumlah)
            var dataParam = {
                idtipe: data.idtipe
            }
            $.ajax({
                url: "{{ route('kontrak.editdata') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: dataParam,
                // contentType: false,
                // cache: false,
                // processData: false,
                // dataType: "json",

                success: function (result) {
                    $('#transaksi_konsumsi').val('')
                    $('#transaksi_tipelimbah').val(data.tipe_limbah).change()
                    $('#transaksi_tahun').val(data.tahun)
                    $('#transaksi_total').val(numberWithCommas(data.jumlah))
                    $('#dataharga').val(result.dataHarga)
                    $('#transaksi_np').val(data.np).change()
                    $('#anggaran_id').val(data.id)
                    $('#labelharga').text('Harga / ' + result.dataSatuan)

                    $('#transaksi_tipelimbah').prop('disabled', 'disabled')
                    $('#transaksi_tahun').prop('disabled', true)
                    $('#transaksi_total').prop('disabled', true)
                    $('#transaksiKuota').modal();
                }
            });
        });
        $('#transaksiKuota').on('hidden.bs.modal', function (e) {
            // do something…
            $('#jmlhlimbah').val('')
            $('#transaksi_konsumsi').val('')
        })
        $('#modalEdit').on('hidden.bs.modal', function (e) {
            // do something…
            $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
            // $('#total').val('') 
        })

        $('#jmlhlimbah').on('change', function () {
            // console.log(this)
            var valJumlah = $(this).val()
            var harga = $('#dataharga').val()
            var result = parseInt(valJumlah) * parseInt(harga)
            $('#transaksi_konsumsi').val(result)
        })
        $('#simpan_transaksi').click(function () {
            var paramData = {
                konsumsi: $('#transaksi_konsumsi').val(),

                np: $('#transaksi_np').val(),
                id: $('#anggaran_id').val(),
            }
            $.ajax({
                url: "{{ route('kontrak.konsumsi_anggaran') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: paramData,
                // contentType: false,
                // cache: false,
                // processData: false,
                // dataType: "json",
                beforeSend: function () {
                    $('#simpan_transaksi').text('menyimpan...');
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        toastr.error(data.errors, 'Gagal Simpan', {
                            timeOut: 5000
                        });
                        $('#form_result').html(html);
                        $('#simpan_transaksi').text('Simpan');
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Tersimpan', {
                            timeOut: 2000
                        });
                        $('#transaksi_tipelimbah').val('').change()
                        $('#transaksi_tahun').val('')
                        $('#transaksi_total').val('')
                        $('#transaksi_np').val('')
                        $('#transaksi_konsumsi').val('')

                        $('#simpan_transaksi').text('Simpan');
                        $('#daftar_kuota').DataTable().ajax.reload();
                        setTimeout(function () {
                            $('#transaksiKuota').modal('toggle');
                        }, 1000);
                    }
                }
            });
            // $('#daftarlimbah').DataTable().ajax.reload();

        })
        $('#simpan_data').click(function () {
            var paramData = {
                tipelimbah: $('#add_tipelimbah').val(),
                tahun: $('#add_tahun').val(),
                total: $('#add_total').val(),
                np: $('#add_np').val()
            }
            $.ajax({
                url: "{{ route('kontrak.save_anggaran') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: paramData,
                // contentType: false,
                // cache: false,
                // processData: false,
                // dataType: "json",
                beforeSend: function () {
                    $('#simpan_data').text('menyimpan...');
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        toastr.error(data.errors, 'Gagal Simpan', {
                            timeOut: 5000
                        });
                        $('#form_result').html(html);
                        $('#simpan_data').text('Simpan');
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Tersimpan', {
                            timeOut: 2000
                        });
                        $('#add_tipelimbah').val('').change()
                        $('#add_tahun').val('')
                        $('#add_total').val('')
                        $('#add_np').val('').change()
                        $('#simpan_data').text('Simpan');
                        $('#daftar_kuota').DataTable().ajax.reload();
                        setTimeout(function () {
                            $('#tambahData').modal('toggle');
                        }, 1000);
                    }
                }
            });
            // $('#daftarlimbah').DataTable().ajax.reload();

        })

        $('#simpan_edit').click(function () {
            var paramData = {
                tipelimbah: $('#tipelimbah').val(),
                tahun: $('#tahun').val(),
                total: $('#total').val(),
                np: $('#np').val(),
                id: $('#hidden_id').val(),
            }
            $.ajax({
                url: "{{ route('kontrak.update_anggaran') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: paramData,
                // contentType: false,
                // cache: false,
                // processData: false,
                // dataType: "json",
                beforeSend: function () {
                    $('#simpan_edit').text('menyimpan...');
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        toastr.error(data.errors, 'Gagal Simpan', {
                            timeOut: 5000
                        });
                        $('#form_result').html(html);
                        $('#simpan_edit').text('Simpan');
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Tersimpan', {
                            timeOut: 2000
                        });
                        $('#tipelimbah').val('').change()
                        $('#tahun').val('')
                        $('#total').val('')
                        $('#np').val('')
                        $('#hidden_id').val('')
                        $('#simpan_edit').text('Simpan');
                        $('#daftar_kuota').DataTable().ajax.reload();
                        setTimeout(function () {
                            $('#modalEdit').modal('toggle');
                        }, 1000);
                    }
                }
            });
            // $('#daftarlimbah').DataTable().ajax.reload();

        })
        $('#tambah_kuota').on('submit', function (event) {})


        $('#tambah_kuota').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('limbah.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    $('#action_button').val('menyimpan...');
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div id=error class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                        $('#form_result').html(html);
                        $('#action_button').val('Simpan');
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Tersimpan', {
                            timeOut: 5000
                        });
                        $('#edit_limbah')[0].reset();
                        $('#action_button').val('Simpan');
                        $('#daftarlimbah').DataTable().ajax.reload();
                        setTimeout(function () {
                            $('#formEdit').modal('toggle');
                        }, 1000);
                    }
                }
            });

        })

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        var table = $('#daftar_kuota').DataTable({
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
                url: "{{ route('kontrak.data') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {


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
                    data: 'konsumsi',
                    name: 'konsumsi',
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
                            return numberWithCommas(data)
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
                {
                    data: 'action',
                    name: 'action',

                },

            ]
        });

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
        $(document).on('click', '.valid', function () {
            toastr.success('Data Berhasil Terupdate', {
                timeOut: 5000
            });

        });


        var user_id;
        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            var tglCatat
            // var tglCatat = moment(data.tgl).format('DD/MM/YYYY');
            if (data.tgl == "-" || data.tgl == "0000-00-00 00:00:00" || data.tgl === null) {
                tglCatat = ""
            } else {
                tglCatat = moment(data.tgl).format('DD/MM/YYYY');
            }
            $('#jenislimbah').val(data.jenislimbah).change()
            $('#entridate').val(tglCatat)
            $('#satuan').val(data.satuan).change()
            $('#namalimbah').val(data.namalimbah).change()
            $('#fisiklimbah').val(data.fisik).change()
            $('#tps').val(data.tps).change()
            $('#limbahasal').val(data.asallimbah).change()
            $('#jmlhlimbah').val(data.jumlah)
            $('#limbah3r').val(data.limbah3r).change()
            $('#hidden_id').val(data.id)
            $('#jumlahlama').val(data.jumlah)
            $('#idnamalimbah').val(data.idnama)



            $('#formEdit').modal();




        });

        $('#edit_limbah').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('limbah.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                beforeSend: function () {
                    $('#action_button').val('menyimpan...');
                },
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div id=error class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                        $('#form_result').html(html);
                        $('#action_button').val('Simpan');
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Tersimpan', {
                            timeOut: 5000
                        });
                        $('#edit_limbah')[0].reset();
                        $('#action_button').val('Simpan');
                        $('#daftarlimbah').DataTable().ajax.reload();
                        setTimeout(function () {
                            $('#formEdit').modal('toggle');
                        }, 1000);
                    }
                }
            });

        })



    })

</script>
@endsection
