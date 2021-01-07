@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

    #daftar_neraca tbody tr {

        cursor: pointer;
    }

    .pihakketiga {
        display: none;
    }

    .nonpihakketiga {
        display: none;
    }

    td.details-control {
        text-align: center;
        color: forestgreen;
        cursor: pointer;
    }

    tr.shown td.details-control {
        text-align: center;
        color: red;
    }

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Neraca Limbah</title>
@section('title')
<h1>Daftar Neraca Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Neraca Limbah</li>
@endsection


@section('content')
<div class="card card-info">
    <div class="card-header">
        {{-- <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button> --}}
    </div>
    <div class="card-body">
        <div class="form-group">

            <label>Bulan</label>
            <input type="text" id="f_date" name="f_date" class="entridate form-control float-right" autocomplete="off">
        </div>
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-sync"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                            href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                            aria-selected="true">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                            href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="false">Proses</a>
                    </li>


                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                        aria-labelledby="custom-tabs-one-home-tab">
                        <div class="row">
                            <!-- Left col -->
                            @include('report.tbl_masuk')



                        </div>
                        {{-- <div class="row">
                            <!-- Left col -->
                            @include('dashboard.kapasitastps')
    
    
                        </div> --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-one-profile-tab" style="position: relative;">

                        <div class="row">
                            @include('report.tbl_keluar')


                        </div>

                    </div>





                </div>
            </div>

        </div>
    </div>



    </section>

    @endsection

    @section('scripts')
    <script>
        $(document).ready(function () { 
            $('#f_date').datepicker({
                uiLibrary: 'bootstrap4',
                todayHighlight: true,
                format: "mm/yyyy",
                defaultDate: new Date(),
                viewMode: "months",
                minViewMode: "months"
            });
            $('#f_date').val(moment().format('MM/YYYY'))
            $('#refresh').click(function () {

                $('#daftar_neraca').DataTable().ajax.reload();
                $('#tbl_keluar').DataTable().ajax.reload();
                
            })

            function format(d) {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Sisa Bulan Lalu:</td>' +
                    '<td>' + d.sisaSaldo + ' (' + d.satuan + ')' + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Extension number:</td>' +
                    '<td>' + d.extn + '</td>' +
                    '</tr>' +
                    // '<tr>'+
                    //     '<td>Extra info:</td>'+
                    //     '<td>And any further details here (images etc)...</td>'+
                    // '</tr>'+
                    '</table>';
            }

            Datatable('#tbl_keluar')
            Datatable('#daftar_neraca')

            function Datatable(id){
                var mutasi=''
                if(id=='#tbl_keluar'){
                    mutasi='proses'
                }else{
                    mutasi='masuk'
                }

                var table = $(id).DataTable({
                processing: true,
                serverSide: true,
                // scrollCollapse: true,
                // scrollX: true,
                
                // dom: 'rti<"clear">',

                columnDefs: [{
                        className: 'text-center',
                        targets: [1, 2, 3, 4, 5]
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
                    url: "{{ route('neraca.daftar') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (d) {
                        d.period = $('#f_date').val()
                        d.mutasi = mutasi
                    }
                },
                order: [
                    // [2, 'asc'],
                    ['7', 'asc']

                ],

                rowGroup: {
                    // dataSrc: ['namalimbah','keterangan'],
                    dataSrc: ['mutasi'],
                    // endRender: function ( rows, group ) {
                    // var avg = rows
                    //     .data()
                    //     .pluck('jumlah2')
                    //     // console.log(avg)
                    //     .reduce(function (a, b) {
                    //         // console.log(a)
                    //         return a + b*1;
                    //     },0)

                    // // return 'Average salary in '+group+': '+
                    // //     $.fn.dataTable.render.number(',', '.', 0, '$').display( avg );
                    // //   sumJumlah=$.fn.dataTable.render.number(',', '.', 0, '$').display( avg );

                    //     return $('<tr/>')
                    //     .append( '<td colspan="4">Averages for '+group+'</td>' )
                    //     .append( '<td>'+avg+'</td>>' )
                    //     .append( '<td/>' )
                    //     .append( '<td/>' )
                    //     // .append( '</td>' )
                    //     // .append( '<td>'+avg+'</td>' )
                    // }
                },
                columnDefs: [{
                    targets: [6],
                    visible: false
                }],
                autoWidth: false,
                // bFilter: false,
                columns: [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                        width: "15px"
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'namalimbah',
                        name: 'namalimbah'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'jumlah2',
                        name: 'jumlah2',
                        render: function (data, type, row) {
                            return parseInt(data) + parseInt(row.sisaSaldo)


                        }
                    },
                    // {
                    //     data: 'sisaSaldo',
                    //     name: 'sisaSaldo'
                    // },
                    {
                        data: 'saldoLimbah',
                        name: 'saldoLimbah'
                    },

                    {
                        data: 'keterangan_mutasi',
                        name: 'keterangan_mutasi',
                        render: function (data, type, row) {
                            // console.log(data)
                            switch (row.idstatus) {
                                case 1:
                                    return '<span class="badge badge-warning">' + data +
                                        '</span>'
                                    break;
                                case 2:
                                    return '<span class="badge badge-success">' + data +
                                        '</span>'
                                    break;
                                case 3:
                                    return '<span class="badge badge-info">' + data + '</span>'
                                    break;
                                case 4:
                                    return '<span class="badge badge-secondary">' + data +
                                        '</span>'
                                    break;
                                case 5:
                                    return '<span class="badge badge-info">' + data + '</span>'
                                    break;
                                case 6:
                                    return '<span class="badge badge-primary">' + data +
                                        '</span>'
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
                                    break;


                                default:
                                    break;
                            }

                        }


                    },
                    {
                        data: 'mutasi',
                        name: 'mutasi',
                        render: function (data, type, row) {
                            switch (data) {
                                case "Masuk":
                                    return '<span class="badge badge-success">' + data +
                                        '</span>'
                                    break;
                                case "Proses":
                                    return '<span class="badge badge-primary">' + data +
                                        '</span>'
                                    break;


                                default:
                                    break;
                            }

                        }


                    },




                ]
            });

            table.columns.adjust().draw();
                $(id+' tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var rowData = row.data();
                var tdi = tr.find("i.fa");

                //get index to use for child table ID
                var index = row.index();

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    tdi.first().removeClass('fa-minus-square');
                    tdi.first().addClass('fa-plus-square');


                } else {
                    // Open this row
                    var paramData = {
                        idlimbah: rowData.idlimbah,
                        idstatus: rowData.idstatus,
                        isWiping: rowData.isWiping,
                        bulan: $('#f_date').val()
                    }
                    row.child(


                        '<table class="child_table" id = "child_details' + index +
                        '" cellpadding="5" cellspacing="0" border="0" style="padding-left:10px;">' +
                        '<thead><th>Tgl. Permohonan</th>' +
                        '<th>Nama Limbah</th> ' +
                        '<th>Jumlah</th>' +
                        // '<th>TPS</th>' +
                        // '<th>Status</th>' +
                        '<th>Tgl. Proses</th>' +
                        '</tr></thead><tbody>' +
                        '</tbody></table>').show();
                       
                    var childTable = $('#child_details' + index).DataTable({
                        ajax: function (data, callback, settings) {
                            $.ajax({
                                url: "{{ route('neraca.detail') }}",
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: paramData
                            }).then(function (json) {
                                // console.log(json)
                                // var data = JSON.parse(json);
                                data = json.data;

                                var display = [];
                                for (d = 0; d < data.length; d++) {
                                    if (data[d].position == rowData.position) {
                                        display.push(data[d]);
                                    }
                                }
                                callback({
                                    data: display
                                });

                            });
                        },
                        scrollCollapse: true,
                scrollX: true,
                        // rowGroup: {
                        //     dataSrc: ['namalimbah'],
                        //     startRender: function (rows, group) {
                        //         return $('<tr/>')
                        //             .append('<td colspan="2">Sisa Saldo :</td>')
                        //             .append('<td>' + rowData.saldoLimbah + ' ' + rowData
                        //                 .satuan + '</td>')
                        //             .append('<td/>')
                        //             .append('<td/>')
                        //             .append('<td/>')

                        //     }
                        // },
                        columnDefs: [
    { width: "30%", targets: 1 }
  ],
                        columns: [{
                                "data": "tgl",
                                render: function (data, type, row) {
                                    return moment(data).format('DD/MM/YYYY');
                                }
                            },
                            {
                                "data": "namalimbah"
                            },
                            {
                                "data": "jumlah",
                                render: function (data, type, row) {
                                    return data + ' ' + row.satuan
                                }
                            },
                            // {
                            //     "data": "namatps"
                            // },
                            // {
                            //     "data": "mutasi",
                            //     render: function (data, type, row) {
                            //         switch (data) {
                            //             case "Masuk":
                            //                 return '<span class="badge badge-success">' +
                            //                     data + '</span>'
                            //                 break;
                            //             case "Proses":
                            //                 return '<span class="badge badge-primary">' +
                            //                     data + '</span>'
                            //                 break;


                            //             default:
                            //                 break;
                            //         }
                            //     }
                            // },
                            {
                                "data": "created_at",
                                render: function (data, type, row) {
                                    return moment(data).format('DD/MM/YYYY');
                                }
                            },
                        ],
                        destroy: true,
                        scrollY: '500px'
                    });
                    childTable.columns.adjust().draw();
                
                    tr.addClass('shown');
                    tdi.first().removeClass('fa-plus-square');
                    tdi.first().addClass('fa-minus-square');
                }
            })
                table.columns.adjust().draw();
          

            table.on("user-select", function (e, dt, type, cell, originalEvent) {
                if ($(cell.node()).hasClass("details-control")) {
                    e.preventDefault();
                }
            });
            }


            
            


        })

    </script>
    @endsection
    {{-- // second option/
// $('#daftar_neraca tbody').on('click', 'td.details-control', function () {
//     var tr = $(this).closest('tr');
//     var tdi = tr.find("i.fa");
//     var row = table.row(tr);

//     if (row.child.isShown()) {
//         // This row is already open - close it
//         row.child.hide();
//         tr.removeClass('shown');
//         tdi.first().removeClass('fa-minus-square');
//         tdi.first().addClass('fa-plus-square');
//     } else {
//         // Open this row
//         row.child(format(row.data())).show();
//         tr.addClass('shown');
//         tdi.first().removeClass('fa-plus-square');
//         tdi.first().addClass('fa-minus-square');
//     }
// }); --}}
