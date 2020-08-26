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
<title>Daftar Penghasil Limbah</title>
@section('title')
<h1>Daftar Penghasil Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Penghasil Limbah</li>
@endsection


@section('content')
<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_penghasil" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Unit Kerja</th>
                    <th>Nama Limbah</th>
                    <th>Jenis Limbah</th>
                    <th>Tipe Limbah</th>
                    <th>Jumlah</th>  
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

            $('#daftar_penghasil').DataTable().ajax.reload();

        })



        var table = $('#daftar_penghasil').DataTable({
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
                url: "{{ route('penghasil.daftar') }}",
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
                    data: 'seksi',
                    name: 'seksi',

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
                    data: 'tipelimbah',
                    name: 'tipelimbah',

                },
                
                 
                {
                    data: 'jumlah',
                    name: 'jumlah',

                },
               
                 

            ]
        });
          

    })

</script>
@endsection
