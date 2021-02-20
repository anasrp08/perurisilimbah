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

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_pack" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th> 
                    <th>Nama Limbah</th> 
                    <th>Jumlah</th>
                    <th>Jenis Limbah</th>
                    {{-- <th>Packing</th> --}}
                    <th>TPS</th>
                    
                </tr>
            </thead>

        </table>
    </div>
</div>

<!-- modal -->
{{-- @include('layouts.edit_modal') --}}

@include('pemrosesan.detail_pack')
{{-- @include('pemrosesan.f_confirmnp') --}}



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.nonpihakketiga').show()
        $('.pihakketiga').hide()
        $('#prosesdate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#nonb3').hide()
        $('#jenislimbah').change(function () {
            if ($(this).val() == "Limbah B3") {
                $("#nonb3").hide();

            } else {
                $("#nonb3").show();

            }
        });



        $('#refresh').click(function () {

            $('#daftar_pack').DataTable().ajax.reload();

        })



        var table = $('#daftar_pack').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            //    dom: '<"right"B>rtipl<"clear">',

            columnDefs: [{
                    className: 'text-center',
                    targets: [0,2,3 ]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            select: true,
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('pemrosesan.list') }}",
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
                // {
                //     data: 'created_at',
                //     name: 'created_at',
                //     render: function (data, type, row) {
                //         // console.log()
                //         return moment(data).format('DD/MM/YYYY');

                //     }
                // },
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
                    data: 'namalimbah',
                    name: 'namalimbah',

                },
                {
                    data: 'total_saldo',
                    name: 'total_saldo',
                    render: function (data, type, row) { 
                        return data+' '+row.satuan ;
                        //tambah menu, dashboard, proses pengurangan saldo TPS (by query)

                    }
                    
                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                // {
                //     data: 'namalimbah',
                //     name: 'namalimbah'
                // },
                // {
                //     data: 'packing_besar',
                //     name: 'packing_besar'
                // },
                {
                    data: 'namatps',
                    name: 'namatps'
                },
                
            ]
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
        $('#daftar_pack').on('click', 'tbody tr', function () {
            var data = table.row(this).data()
            console.log(data)
            table1 = $('#detail_pack').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                // select: true,
                language: {
                    emptyTable: "Tidak Ada Detail Data"
                },
                // scrollY: "300px",
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
                ajax: {
                    url: '{{ route("pemrosesan.detaillist")}}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        d.packing_besar = data.packing_besar
                        d.idlimbah = data.idlimbah
                    }
                }, 
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tgl_permohonan',
                        name: 'tgl_permohonan',
                        render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY');
                        }
                    },

                    {
                    data: 'kadaluarsa',
                    name: 'kadaluarsa',
                    render: function (data, type, row) {
                        var currDate = moment().format('DD/MM/YYYY');
                        var day7 = moment(data).subtract(7, 'd').format('DD/MM/YYYY');

                        var day3 = moment(data).subtract(3, 'd').format('DD/MM/YYYY');
                        // console.log(currDate.to(day3));
                        // console.log(currDate)
                        if (currDate == day7) {
                            return '<h5><span class="badge badge-warning">' + moment(data)
                                .format('DD/MM/YYYY') + '</span></h5>'
                        } else if (currDate == day3) {
                            return '<h5><span class="badge badge-danger">' + moment(data)
                                .format('DD/MM/YYYY') + '</span></h5>'
                        } else {
                            return moment(data).format('DD/MM/YYYY');
                        } 
                    }
                },
                    {
                        data: 'namalimbah',
                        name: 'namalimbah'
                    },

                    // {
                    //     data: 'total_pack',
                    //     name: 'total_pack',
                    //     render: function (data, type, row) {
                    //     return data +' ('+row.packing_besar+')'
                    //     }
                    // },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);



                    // Update footer
                    $(api.column(2).footer()).html(
                        total
                    );
                }

            })
            $('#modaldetail').modal('show')

        })
        $('#proses').click(function () {
            var data = $('#detail_pack').DataTable().rows().data()
            var radio


            var arrValue = []

            arrValue.push($('#prosesdate').val())
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
            }else if ($('#radioPrimary4').is(':checked')) {
                radio = $('#radioPrimary4').val()
            }else if ($('#radioPrimary5').is(':checked')) {
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
            var isEmptyCounter=0
            // console.log(arrValue)
            console.log(data.toArray())

            var countData=data.count()
            $("#detail_pack tbody tr").each(function () {
                var obj = {};
                //memasukkan jmlh proses yang isi nya kosong
                if($(":input[name=jmlh_proses]", this).val()==""){
                    isEmptyCounter++

                }
                obj.jmlh_proses = $(":input[name=jmlh_proses]", this).val();
            
                output1.push(obj);
                // dataNonInput
            })

            if(countData == isEmptyCounter){
                toastr.warning('Belum Ada Jumlah Yang Di Proses', 'Perhatian', {
                            timeOut: 5000
                        });
            }else{
                for (i = 0; i < data.count(); i++) {
                var obj = {};
                console.log(output1[i].jmlh_proses)
                if (output1[i].jmlh_proses == '' || output1[i].jmlh_proses == 0) {
                    continue;
                } else {
                    obj.limbah3r = data[i].limbah3r;
                    obj.tgl = data[i].tgl;
                    obj.id_transaksi = data[i].id_transaksi;
                    obj.idmutasi = data[i].idmutasi;
                    obj.idasallimbah = data[i].idasallimbah;
                    obj.idsatuan = data[i].idsatuan;
                    obj.idlimbah = data[i].idlimbah;
                    obj.idstatus = arrValue[5];
                    obj.fisik = data[i].fisik;
                    obj.idtps = data[i].idtps;
                    obj.no_packing = data[i].no_packing;
                    obj.tipelimbah = data[i].tipelimbah;
                    obj.idjenislimbah = data[i].idjenislimbah;
                    obj.jumlah = data[i].jumlah;
                    obj.jmlh_proses = output1[i].jmlh_proses;
                    obj.limbah3r = data[i].limbah3r;
                    obj.tglproses = arrValue[0];
                    obj.idvendor = arrValue[1];
                    obj.nomanifest = arrValue[2];
                    obj.nokendaraan = arrValue[3];
                    obj.nospbe = arrValue[4];
                    obj.status_lama = data[i].idstatus;
                    // obj.jumlah_lama = data[i].idstatus;

                    obj.np_pemroses = $('#np_pemroses').val();
                    output.push(obj);
                    jsonData["detail"] = output
                }

                // console.log(value)


            }
            console.log(jsonData)
            packLimbah(jsonData)
            }

            
        }

        function packLimbah(jsonData) {
            $.ajax({
                url: "{{ route('pemrosesan.proses') }}",
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
                        $('#modaldetail').modal('toggle')
                        $('#daftar_pack').DataTable().ajax.reload();
                        $('.formproses').val('');
                        $('.radioPilihan').prop('checked', false); 
                        $('#np_pemroses').val('').change();
                        // $('#counterentries').text(data.count);

                        // $('#saveentri').text('Simpan');
                        // $('#tblorder').DataTable().ajax.reload();
                        // renderTgl()

                    }

                }
            })
        }

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
        // $('#daftar_pack tbody').on('click', 'tr', function () {
        //     $(this).toggleClass('selected');
        // });
        var user_id




    })

</script>
@endsection
