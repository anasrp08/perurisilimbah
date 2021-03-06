@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

    #daftar_kapasitas tbody tr {

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
<title>Report Kapasitas</title>
@section('title')
<h1>Report Kapasitas</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Report Kapasitas</li>
@endsection


@section('content')
<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_kapasitas" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama TPS</th>
                    <th>Jenis Limbah</th>  
                    <th>Kapasitas Jumlah</th>
                    <th>Saldo</th> 
                    <th>Status</th> 
                    <th>Tgl. Update</th> 
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

            $('#daftar_kapasitas').DataTable().ajax.reload();

        })



        var table = $('#daftar_kapasitas').DataTable({
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
                url: "{{ route('kapasitas.daftar') }}",
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
                    data: 'namatps',
                    name: 'namatps',

                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                
                {
                    data: 'kapasitasjumlah',
                    name: 'kapasitasjumlah',
                    render: function (data, type, row) {
                        return data +' '+ row.satuan2
                    }

                },
                {
                    data: 'saldo',
                    name: 'saldo',
                    render: function (data, type, row) {
                        return data +' '+ row.satuan2
                    }

                },
                {
                    data: 'saldo',
                    name: 'saldo',
                    render: function (data, type, row) {
                        // console.log()
                        var kap_danger=Math.round(parseInt(row.kapasitasjumlah) * parseInt(90) / parseInt(100))
                        var kap_warning=Math.round(parseInt(row.kapasitasjumlah) * parseInt(75) / parseInt(100))
                        // console.log(kap_danger)
                        console.log(kap_warning)
                        // console.log(parseInt(row.saldo) > kap_warning && (row.saldo < kap_danger ) )
                        if(parseInt(row.saldo) >= kap_warning && row.saldo <= kap_danger ){
                            return '<span class="badge badge-warning">Waspada</span>' 
                        }else if(parseInt(row.saldo) > kap_danger){
                            return '<span class="badge badge-danger">Bahaya</span>'
                        }else{
                            return '<span class="badge badge-success">Aman</span>'
                        }

                         

                    }

                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function (data, type, row) {
                        // console.log()
                        return moment(data).format('DD/MM/YYYY');

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
