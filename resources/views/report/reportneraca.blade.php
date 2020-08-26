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
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_neraca" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Limbah</th>
                    <th>Jenis Limbah</th>
                    <th>Penghasil Limbah</th>
                    <th>TPS</th>
                    <th>Tanggal Proses</th>
                    <th>Status</th> 
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
        



        $('#refresh').click(function () {

            $('#daftar_neraca').DataTable().ajax.reload();

        })



        var table = $('#daftar_neraca').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            dom: 'rti<"clear">',

            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
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
                    data: 'namalimbah',
                    name: 'namalimbah',

                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                {
                    data: 'seksi',
                    name: 'seksi',

                },
                {
                    data: 'namatps',
                    name: 'namatps',

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
                // {
                //     data: 'namalimbah',
                //     name: 'namalimbah'
                // },
                // {
                //     data: 'jumlah',
                //     name: 'jumlah'
                // },
                 

            ]
        });
          

    })

</script>
@endsection
