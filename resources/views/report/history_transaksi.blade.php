@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

    #daftar_penghasil tbody tr {

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
<title>Histori Transaksi</title>
@section('title')
<h1>Histori Transaksi</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Histori Transaksi</li>
@endsection


@section('content')
<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_histori" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal</th>
                    <th>Nama Limbah</th>
                    <th>Asal Limbah</th>
                    <th>Jenis Limbah</th>
                    <th>Tipe Limbah</th>
                    {{-- <th>TPS</th> --}}
                    <th>Jumlah</th>  
                    <th>Proses Oleh</th>  
                    <th>Status</th> 
                    <th>Keterangan</th>  
                     
                </tr>
            </thead>

        </table>
    </div>
</div> 



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#refresh').click(function () {

            $('#daftar_penghasil').DataTable().ajax.reload(); 
        })



        var table = $('#daftar_histori').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            dom: 'rti<"clear">',

            columnDefs: [{
                    className: 'text-center',
                    targets: [1,4,5,6,7]
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
                url: "{{ route('history.data') }}",
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
                    name: 'namalimbah',

                },
                {
                    data: 'seksi',
                    name: 'seksi',

                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                {
                    data: 'tipelimbah',
                    name: 'tipelimbah',

                },
                // {
                //     data: 'namatps',
                //     name: 'namatps',

                // },
                 
                {
                    data: 'jumlah',
                    name: 'jumlah',

                },
                {
                    data: 'np',
                    name: 'np',

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
                                break;

                            default:
                                break;
                        }
                    }

                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                   

                },
                
               
                 

            ]
        });
          

    })

</script>
@endsection
