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
                    <th>Tanggal Proses</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Kode Pack</th>
                    <th>TPS</th>
                    <th>Tipe Limbah</th>
                    <th>Status</th>
                   

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
                    targets: [1, 2, 3, 4, 5, 6]
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
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data, type, row) {
                        // console.log()
                        return moment(data).format('DD/MM/YYYY');

                    }
                },
                {
                    data: 'kadaluarsa',
                    name: 'kadaluarsa',
                    render: function (data, type, row) {
                        var currDate=moment().format('DD/MM/YYYY');
                        var day7=moment(data).subtract(7,'d').format('DD/MM/YYYY');
                        
                        var day3=moment(data).subtract(3,'d').format('DD/MM/YYYY');
                        // console.log(currDate.to(day3));
                        // console.log(currDate)
                        if(currDate==day7){
                            return '<h5><span class="badge badge-warning">'+moment(data).format('DD/MM/YYYY')+'</span></h5>'
                        }else if(currDate==day3){
                            return '<h5><span class="badge badge-danger">'+moment(data).format('DD/MM/YYYY')+'</span></h5>'
                        }else{
                            return moment(data).format('DD/MM/YYYY');
                        }

                        

                    }
                },
                {
                    data: 'kode_pack',
                    name: 'kode_pack',

                },
                // {
                //     data: 'namalimbah',
                //     name: 'namalimbah'
                // },
                // {
                //     data: 'jumlah',
                //     name: 'jumlah'
                // },
                {
                    data: 'namatps',
                    name: 'namatps'
                },
                {
                    data: 'tipelimbah',
                    name: 'tipelimbah',

                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    render: function (data, type, row) {
                        // console.log()
                        switch (row.idstatus) {
                            case "1":
                                return '<span class="badge badge-warning">'+data+'</span>'
                                break;
                                case "2":
                                return '<span class="badge badge-success">'+data+'</span>'
                                break;
                                case "3":
                                return '<span class="badge badge-info">'+data+'</span>'
                                break;
                                case "4":
                                return '<span class="badge badge-secondary">'+data+'</span>'
                                break;  
                                case "5":
                                return '<span class="badge badge-info">'+data+'</span>'
                                break;
                                case "6":
                                return '<span class="badge badge-primary">'+data+'</span>'
                                break;
                                case "7":
                                return '<span class="badge badge-danger">'+data+'</span>'
                                break; 
                        
                            default:
                                break;
                        }
                         
                         

                    }

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

                ajax: {
                    url: '{{ route("pemrosesan.detaillist")}}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        d.kodepack = data.kode_pack
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        data: 'tipelimbah',
                        name: 'tipelimbah'
                    },
                    {
                        data: 'jenislimbah',
                        name: 'jenislimbah'
                    },

                ]

            })
            $('#modaldetail').modal('show')

        })
        $('#proses').click(function () {
            var data = $('#detail_pack').DataTable().rows().data()
            var radio
            
            
            var arrValue=[]
            
                arrValue.push($('#prosesdate').val())
                arrValue.push($('#vendor').val())
                arrValue.push($('#nomanifest').val())
                arrValue.push($('#nokendaraan').val())
                
                arrValue.push($('#nospbe').val())
                
                if($('#radioPrimary1').is(':checked')) { 
                    radio= $('#radioPrimary1').val()
                    }else if($('#radioPrimary2').is(':checked')){
                        radio=$('#radioPrimary2').val()
                    }else if($('#radioPrimary3').is(':checked')){
                        radio=$('#radioPrimary3').val()
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
                    default:
                    // arrValue.push(7)
                        break;
                }
             

            formatedData(data,arrValue)

        })

        function formatedData(data,arrValue) {
            var output = [];
            var jsonData = {}
            var dataSelected = []
            console.log(arrValue)
            console.log(data.toArray())


            for (i = 0; i < data.count(); i++) {

                var obj = {};
                // console.log(value)
                obj.limbah3r = data[i].limbah3r;
                obj.tgl = data[i].tgl;
                obj.id_transaksi = data[i].id_transaksi;
                obj.idmutasi = data[i].idmutasi;
                obj.idasallimbah = data[i].idasallimbah;
                obj.idlimbah = data[i].idlimbah;
                obj.idstatus = arrValue[5];
                obj.fisik = data[i].fisik;
                obj.idtps = data[i].idtps;
                obj.no_packing = data[i].no_packing;
                obj.tipelimbah = data[i].tipelimbah;
                obj.idjenislimbah = data[i].idjenislimbah;
                obj.jumlah = data[i].jumlah;
                obj.limbah3r = data[i].limbah3r;
                obj.tglproses = arrValue[0];
                obj.idvendor = arrValue[1];
                obj.nomanifest = arrValue[2];
                obj.nokendaraan = arrValue[3];
                obj.nospbe = arrValue[4];
                obj.np = $('#np').val();
                output.push(obj);
                jsonData["detail"] = output 
            }
            console.log(jsonData)
            packLimbah(jsonData)
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
