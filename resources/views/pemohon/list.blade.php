@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

    .modal-lg {
        max-width: 80% !important;
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
@role(['admin','operator','pengawas'])
@include('pemohon.f_filter')
@endrole

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
                    <th>ID</th>
                    <th>Status</th>
                    <th>No. Surat</th>
                    <th>Tanggal</th>
                    <th>Nama Limbah</th>
                    <th>Jumlah</th>
                    {{-- <th>Satuan</th> --}}
                    <th>Asal Limbah</th>
                    <th>Jenis Limbah (B3/Non)</th>

                    <th>Diterima Oleh</th>
                    <th>Tgl. Validasi</th>
                    <th>Divalidasi Oleh</th>
                </tr>
            </thead>

        </table>
    </div>
</div>

<!-- modal -->
@include('pemohon.f_revisi')
@include('pemohon.f_proses_lgsg')
@include('pemohon.f_tolak')
@include('pemohon.f_confirmnp')


{{-- @include('layouts.confimdelete') --}}



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var seksi = '<?php echo $username->seksi ?>'
        $('#entridate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('input[name="f_date"]').daterangepicker({
            format: 'DD/MM/YYYY',
            autoUpdateInput: false,
            autoclose: true,
            todayHighlight: true,
            locale: {
                cancelLabel: 'Clear'
            }

        })
        $('input[name="f_date"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                'DD/MM/YYYY'));
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#filter').click(function () {
            $('#daftar_pemohon').DataTable().draw(true);
        })

        $('#nonb3').hide()
        $('#jenislimbah').change(function () {
            if ($(this).val() == "Limbah B3") {
                $("#nonb3").hide();

            } else {
                $("#nonb3").show();

            }
        });
        $('.nonpihakketiga').show()
        $('.pihakketiga').hide()
        $('#prosesdate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });


        $('#nonb3').hide()
        $('#jenislimbah').change(function () {
            if ($(this).val() == "Limbah B3") {
                $("#nonb3").hide();

            } else {
                $("#nonb3").show();

            }
        });
        $("input[name='r1']").change(function () {

            switch ($(this).val()) {
                case 'incinerator':
                    $('.nonpihakketiga').show()
                    $('.pihakketiga').hide()
                    break;
                case 'netralisir':
                    $('.nonpihakketiga').show()
                    $('.pihakketiga').hide()
                    break;
                case 'evaporator':
                    $('.nonpihakketiga').show()
                    $('.pihakketiga').hide()
                    break;
                case 'incinerator_statis':
                    $('.nonpihakketiga').show()
                    $('.pihakketiga').hide()
                    break;

                default:
                    $('.pihakketiga').show()
                    $('.nonpihakketiga').show()
                    break;
            }
        });
        $('#submit_proses').click(function () {
            // var data = $('#detail_pack').DataTable().rows().data()
            var data = table.rows({
                selected: true
            }).data()
            var radio

            var arrValue = []
            var date = $('#prosesdate').val()
            arrValue.push(moment(date, 'DD-MM-YYYY').format('YYYY-MM-DD'))
            arrValue.push($('#vendor').val())
            arrValue.push($('#nomanifest').val())
            arrValue.push($('#nokendaraan').val())
            arrValue.push($('#nospbe').val())

            if ($('#radioPrimary1').is(':checked')) {
                radio = $('#radioPrimary1').val()
            } else if ($('#radioPrimary2').is(':checked')) {
                radio = $('#radioPrimary2').val()
            } else if ($('#radioPrimary3').is(':checked')) {
                radio = $('#radioPrimary3').val()
            } else if ($('#radioPrimary4').is(':checked')) {
                radio = $('#radioPrimary4').val()
            } else if ($('#radioPrimary5').is(':checked')) {
                radio = $('#radioPrimary5').val()
            }
            // console.log(radio)
            switch (radio) {
                case 'ketiga':
                    arrValue.push(5)
                    break;
                case 'incinerator':
                    arrValue.push(6)
                    break;
                case 'netralisir':
                    arrValue.push(7)
                    break;
                case 'evaporator':
                    arrValue.push(8)
                    break;
                case 'incinerator_statis':
                    arrValue.push(9)
                    break;
                default:
                    // arrValue.push(7)
                    break;
            }

            formatedData(data, arrValue)

        })

        function formatedData(data, arrValue) {
            var output = [];
            var jsonData = {}
            var dataNonInput = []
            var output1 = []
            var isEmptyCounter = 0
            console.log(arrValue)
            var countData = data.count()

            for (i = 0; i < data.count(); i++) {
                var obj = {};
                obj.limbah3r = data[i].limbah3r;
                obj.tgl = data[i].tgl;
                obj.id_transaksi = data[i].id_transaksi;
                obj.idheader = data[i].id;
                obj.idasallimbah = data[i].idasallimbah;
                obj.idsatuan = data[i].idsatuan;
                obj.idlimbah = data[i].idlimbah;
                obj.idstatus = arrValue[5];
                obj.fisik = data[i].fisik;
                obj.idtps = data[i].idtps;
                obj.no_packing = data[i].no_packing;
                obj.tipelimbah = data[i].tipelimbah;
                obj.idjenislimbah = data[i].idjenislimbah;
                obj.jumlah = data[i].jumlah_in;
                obj.pack = data[i].pack_in;
                obj.hiddenTransaksi = 'proses'
                obj.limbah3r = data[i].limbah3r;
                obj.tglproses = arrValue[0];
                obj.idvendor = arrValue[1];
                obj.nomanifest = arrValue[2];
                obj.nokendaraan = arrValue[3];
                obj.nospbe = arrValue[4];
                obj.status_lama = data[i].idstatus;
                obj.np_pemroses = $('#np_pemroses').val();
                obj.idmutasi = data[i].id;
                obj.keterangan_proses = $('#keterangan_proses').val();
                output.push(obj);
                jsonData["Order"] = output




            }
            console.log(jsonData)
            packLimbah(jsonData)



        }

        function packLimbah(jsonData) {
            $.ajax({
                url: "{{ route('pemohon.updatevalid') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                data: JSON.stringify(jsonData),
                beforeSend: function () {
                    $('#submit_proses').text('proses menyimpan...');
                    $('#submit_proses').prop('disable', true);
                },
                success: function (data) {
                    if (data.error) {
                        toastr.error(data.error, 'Error', {
                            closeButton: true,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width"
                        });
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Success', {
                            timeOut: 5000,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width"
                        });
                        $('#modalproses').modal('toggle')
                        $('#daftar_pemohon').DataTable().ajax.reload();
                        $('.formproses').val('');
                        $('.radioPilihan').prop('checked', false);
                        $('#np_pemroses').val('').change();


                    }
                    $('#submit_proses').text('Proses');
                    $('#submit_proses').prop('disable', false);

                }
            })
        }


        $('#refresh').click(function () {

            $('#daftar_pemohon').DataTable().ajax.reload();

        })
        if (seksi == 'pengawas' || seksi == 'operator') {
            var handle = setInterval(setNotification, 180000);
        }

        function setNotification() {
            $('#daftar_pemohon').DataTable().ajax.reload();
        }

        var table = $('#daftar_pemohon').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            paging: true,
            dom: '<"right"B>frtipl<"clear">',
            buttons: [{
                    text: 'Terima',
                    className: 'terima btn btn-success',
                    action: function (e, dt, node, config) {
                        var dataSelected = table.rows({
                            selected: true
                        }).data() 
                        var isProsesLgsg = false

                        // for (i = 0; i < dataSelected.count(); i++) {
                        //     if (dataSelected[i].is_lgsg_proses == '1') {

                        //         toastr.warning(
                        //             'Ada limbah yang harus diproses langsung',
                        //             'Perhatian', {
                        //                 timeOut: 5000
                        //             });
                        //         isProsesLgsg = true
                        //         break;
                        //     }
                        // }


                        if (dataSelected.count() > 1 || dataSelected.count() == 0) {
                            toastr.warning('Harus pilih salah satu', 'Warning', {
                                timeOut: 5000
                            });
                        } else if (dataSelected.count() == 1) {
                            if (dataSelected[0].is_lgsg_proses == '1') {
                                    toastr.warning(
                                    'Ada limbah yang harus diproses langsung',
                                    'Perhatian', {
                                        timeOut: 5000
                                    });
                                }else{
                                    $('#title_konfirmasi').text('Diterima Oleh: ')
                                    $('#hidden_transaksi').val('terima')
                                    $('#modalconfirm').modal('show') 
                                    if (dataSelected[0].konversi_kuota != '-' && dataSelected[0].konversi_satuan_kecil !=
                                    '-' && dataSelected[0].harga_satuan_konversi != '-') {
                                    $('#input_massa').css('display', 'block')
                                }else{
                                    $('#input_massa').css('display', 'none')
                                }

                                }

                              

                                

                        }

                        // if (!isProsesLgsg) {
                        //     $('#title_konfirmasi').text('Diterima Oleh: ')
                        //     $('#hidden_transaksi').val('terima')
                        //     $('#modalconfirm').modal('show')
                        // } else {

                        // }


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
                    text: 'Revisi',
                    className: 'revisi btn btn-info',
                    action: function (e, dt, node, config) {

                        var data = table.rows({
                            selected: true
                        }).data()
                        console.log(data)
                        if (data.count() > 1 || data.count() == 0) {
                            toastr.warning('Harus pilih salah satu', 'Warning', {
                                timeOut: 5000
                            });
                        } else if (data.count() == 1) {

                            if (data.konversi_kuota != '-' && data.konversi_satuan_kecil !=
                                '-' && data.harga_satuan_konversi != '-') {
                                $('#input_massa').css('display', 'block')
                            }
                            $('#title_revisi').text('Revisi Permohonan')
                            $('#hidden_transaksi').val('revisi')
                            $('#np_pemohon').val(data[0].np_pemohon)
                            var tglEntri = moment(data[0].tgl).format('DD/MM/YYYY');
                            $('#entridate').val(tglEntri);
                            $('#jmlhlimbah').val(data[0].jumlah_in);
                            $('#satuan').val(data[0].idsatuan).change();
                            $('#keterangan').val(data[0].keterangan);
                            $('#jenislimbah').val(data[0].idjenislimbah).change();
                            $('#limbahasal').val(data[0].idasallimbah).change();
                            $('#maksud').val(data[0].maksud);
                            $('#namalimbah').val(data[0].idlimbah).change();
                            if (data[0].limbah3r == '') {
                                $('#nonb3').css('display', 'none')
                            } else {
                                $('#limbah3r').val(data[0].limbah3r).change();
                            }
                            $('#hidden_transaksi').val('revisi')
                            $('#hidden_id').val(data[0].idheader)
                            $('#modalrevisi').modal('show')
                        }


                    }


                },
                {
                    text: 'Proses Langsung',
                    className: 'proses btn btn-warning',
                    action: function (e, dt, node, config) {
                        var dataSelected = table.rows({
                            selected: true
                        }).data()

                        var isProsesLgsg1 = true
                        for (i = 0; i < dataSelected.count(); i++) {
                            if (dataSelected[i].is_lgsg_proses == '' || dataSelected[i]
                                .is_lgsg_proses == null || dataSelected[i].is_lgsg_proses ==
                                'NULL') {

                                toastr.warning(
                                    'Ada limbah yang tidak diijinkan untuk proses langsung',
                                    'Perhatian', {
                                        timeOut: 5000
                                    });
                                isProsesLgsg1 = false
                                break;
                            }
                        }
                        if (isProsesLgsg1) {
                            $('#title_konfirmasi').text('Di Proses Langsung Oleh: ')
                            $('#hidden_transaksi').val('proses')
                            $('#modalproses').modal('show')
                        } else {

                        }
                    }
                },
                {
                    text: 'Tolak Permohonan',
                    className: 'tolak btn btn-danger',
                    action: function (e, dt, node, config) {
                        var dataSelected = table.rows({
                            selected: true
                        }).data()
                        if (dataSelected.count() > 1) {
                            toastr.error(
                                'Hanya Boleh Pilih 1 Permohonan',
                                'Perhatian', {
                                    timeOut: 3000
                                });
                        } else if (dataSelected.idstatus == 11 || dataSelected.idstatus == 10) {
                            toastr.error(
                                'Tidak Diizinkan',
                                'Perhatian', {
                                    timeOut: 3000
                                });
                        } else {
                            console.log(dataSelected)
                            $('#title_tolak').text('Permohonan Ditolak')
                            $('#hidden_transaksi').val('tolak')
                            $('#hidden_id_tolak').val(dataSelected[0].idheader)
                            $('#modaltolak').modal('show')
                        }
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
                    targets: [1, 2, 4, 5, 8, 9]
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
                    d.idasallimbah = seksi
                    // d.status=$('#status').val()
                    d.namalimbah = $('#f_namalimbah').val()
                    d.jenislimbah = $('#f_jenislimbah').val()
                    d.limbahasal = $('#f_limbahasal').val()
                    d.f_date = $('#f_date').val()




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
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {

                        switch (row.idstatus) {
                            case 1:
                                return '<span class="badge badge-warning">' + data + '</span>'
                                break;
                            case 2:
                                return '<span class="badge badge-success">' + data + '</span>'
                                break;
                            case 3:
                                return '<span class="badge badge-info">' + data + '</span>'
                                break;
                            case 4:
                                return '<span class="badge badge-secondary">' + data + '</span>'
                                break;
                            case 5:
                                return '<span class="badge badge-info">' + data + '</span>'
                                break;
                            case 6:
                                return '<span class="badge badge-primary">' + data + '</span>'
                                break;
                            case 7:
                                return '<span class="badge bg-gray">' + data + '</span>'
                                break;
                            case 8:
                                return '<span class="badge bg-indigo">' + data + '</span>'
                                break;
                            case 9:
                                return '<span class="badge bg-teal">' + data + '</span>'
                                break;
                            case 10:
                                return '<span class="badge bg-fuchsia">' + data + '</span>'
                            case 11:
                                return '<span class="badge badge-danger">' + data + '<br>' +
                                    'Oleh: ' + row.np_penolak + '</span><br>Alasan: ' + row
                                    .alasan_tolak
                                break;
                            default:
                                break;
                        }
                    }
                },
                {
                    data: 'no_surat',
                    name: 'no_surat',
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
                    data: 'jumlah_in',
                    name: 'jumlah_in',
                    render: function (data, type, row) {
                        return data + ' (' + row.satuan + ')'
                    }

                },
                // {
                //     data: 'satuan',
                //     name: 'satuan'
                // },
                {
                    data: 'seksi',
                    name: 'seksi'
                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

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
                        if (data == null) {
                            return '<span class="badge badge-info">Belum Validasi</span>'
                        } else {
                            return data
                        }
                    }

                },

            ]
        });
        var buttonTerima = table.buttons(['.terima']);
        var buttonValidasi = table.buttons(['.validasi']);
        var buttonRevisi = table.buttons(['.revisi']);
        var buttonProsesLangsung = table.buttons(['.proses']);
        var buttonTolak = table.buttons(['.tolak']);
        var buttonDatatable = table.buttons(['.batal', '.semua']);
        var roleUser = '<?php echo Laratrust::hasRole("admin") ?>'
        var roleUnitKerja = '<?php echo Laratrust::hasRole("unit kerja") ?>'
        var rolePengawas = '<?php echo Laratrust::hasRole("pengawas") ?>'
        var roleOperator = '<?php echo Laratrust::hasRole("operator") ?>'

        if (roleUnitKerja == 1) {
            buttonTerima.nodes().css("display", "none");
            buttonValidasi.nodes().css("display", "none");
            buttonDatatable.nodes().css("display", "none");
            buttonRevisi.nodes().css("display", "none");
            buttonProsesLangsung.nodes().css("display", "none");
            buttonTolak.nodes().css("display", "none");
        } else if (rolePengawas == 1) {
            buttonTerima.nodes().css("display", "none");
            buttonRevisi.nodes().css("display", "none");
            buttonProsesLangsung.nodes().css("display", "none");
            buttonTolak.nodes().css("display", "none");
        } else if (roleOperator == 1) {
            buttonValidasi.nodes().css("display", "none");
            buttonTolak.nodes().css("display", "none");
        }
        $('#form_revisi').on('submit', function (event) {
            event.preventDefault();
            url = "{{ route('history.update') }}"
            $.ajax({
                url: url,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
                contentType: false,
                // cache: false,
                processData: false,
                // dataType: "json",
                beforeSend: function () {
                    $('#simpan').text('proses menyimpan...');
                    $('#simpan').prop('disabled', true);
                },
                success: function (data) {
                    // console.log(data)
                    if (data.error) {

                        toastr.error(data.error, 'Error', {
                            closeButton: true,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width",
                        });
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Success', {
                            timeOut: 5000,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width",
                        });
                        // $('#np').val('').change() 
                        $('#modalrevisi').modal('toggle')
                        $('#daftar_pemohon').DataTable().ajax.reload();

                    }
                    $('#simpan').text('Submit');
                    $('#simpan').prop('disabled', false);
                }
            })
        })

        $('#form_tolak').on('submit', function (event) {
            event.preventDefault();
            url = "{{ route('history.update_tolak') }}"
            $.ajax({
                url: url,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#simpan').text('proses menyimpan...');
                    $('#simpan').prop('disabled', true);
                },
                success: function (data) {
                    if (data.error) {

                        toastr.error(data.error, 'Error', {
                            closeButton: true,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width",
                        });
                    }
                    if (data.success) {
                        toastr.success(data.success, 'Success', {
                            timeOut: 5000,
                            newestOnTop: false,
                            positionClass: "toast-top-full-width",
                        });
                        $('#form_tolak')[0].reset();
                        $('#modaltolak').modal('toggle')
                        $('#daftar_pemohon').DataTable().ajax.reload();

                    }
                    $('#simpan').text('Submit');
                    $('#simpan').prop('disabled', false);
                }
            })


        })
        $('#massa').keypress(function (evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        });
        $('#modalconfirm').on('hidden.bs.modal', function (e) {
            $('#np').val('').change()
            $('#massa').val('')
        })
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
            if ($('#np').val() == '') {
                toastr.warning('Semua Field Harus Diisi', 'Warning', {
                    timeOut: 5000
                });
            } else {
                if (data1.count() == 0) {
                    toastr.warning('Ada Order Yang Belum Dipilih', 'Warning', {
                        timeOut: 5000
                    });
                } else if (data1.count() > 1) {
                    toastr.warning('Pilih Salah Satu Item', 'Warning', {
                        timeOut: 5000
                    });

                } else {
                    for (i = 0; i < data1.count(); i++) {

                        var obj = {};
                        obj.idheader = data1[i].id;
                        obj.limbah3r = data1[i].limbah3r;
                        obj.limbah3r = data1[i].limbah3r;
                        obj.tgl = data1[i].tgl;
                        obj.id_transaksi = data1[i].id_transaksi;
                        obj.idmutasi = data1[i].idmutasi;
                        obj.idasallimbah = data1[i].idasallimbah;
                        obj.idlimbah = data1[i].idlimbah;
                        obj.idstatus = data1[i].idstatus;
                        obj.idjenislimbah = data1[i].idjenislimbah;
                        obj.jumlah = data1[i].jumlah_in;
                        obj.satuan = data1[i].idsatuan;
                        obj.np = $('#np').val();
                        obj.massa = $('#massa').val();
                        obj.hiddenTransaksi = $('#hidden_transaksi').val();
                        output.push(obj);
                        jsonData["Order"] = output

                    }
                    var url = ''


                    console.log(jsonData)
                    url = "{{ route('pemohon.updatevalid') }}"
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
                            $('#submit').text('proses menyimpan...');
                            $('#submit').prop('disabled', true);
                        },
                        success: function (data) {
                            if (data.error) {

                                toastr.error(data.error, 'Error', {
                                    closeButton: true,
                                    newestOnTop: false,
                                    positionClass: "toast-top-full-width",
                                });
                            }
                            if (data.success) {
                                toastr.success(data.success, 'Success', {
                                    timeOut: 5000,
                                    newestOnTop: false,
                                    positionClass: "toast-top-full-width",
                                });
                                $('#daftar_pemohon').DataTable().ajax.reload();

                            }
                            $('#np').val('').change();
                            $('#massa').val('');
                            $('#submit').text('Submit');
                            $('#submit').prop('disabled', false);

                        }
                    })
                    $('#np').val('').change()
                    $('#modalconfirm').modal('toggle')

                }
            }

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
