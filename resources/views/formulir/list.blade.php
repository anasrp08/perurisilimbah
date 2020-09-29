@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Formulir Limbah</title>
@section('title')
<h1>Daftar Formulir Angkut Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Formulir</li>

@endsection

@section('content')



<div class="row">
    {{-- @include('pemohon.f_pemohon') --}}
    @include('formulir.tbl_formulir')
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () { 
        var table = $('#tbl_formulir').DataTable({
 
            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],  
            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3, 4]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('formulir.daftar') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {}
            },
            // dom: 'Bfrti',
            language: {
                emptyTable: "Tidak Ada Data Formulir"
            }, 
            order: [
                [0, 'asc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_surat',
                    name: 'no_surat'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data, type, row) {
                        if (data == null || data == ""|| data == "NULL") {
                            return '-'
                        } else {
                            return moment(data).format('DD/MM/YYYY');
                        }

                    }
                    
                },
                {
                    data: 'seksi',
                    name: 'seksi'
                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah'
                },
                {
                    data: 'limbah3r',
                    name: 'limbah3r',
                    render: function (data, type, row) {
                        if (data == null || data == ""||
                            data == "NULL") {
                            return '-'
                        } else {
                           return data
                        }

                    }
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },

            ]

        });
        $('#tbl_formulir tbody').on('click', '.download', function () {

            var dataRow = table.row($(this).parents('tr')).data();
            console.log(dataRow)
            var url =
                '{{ route("formulir.cetak",[":id"])}}';
            url = url.replace(":id", dataRow.id_transaksi);
           

            document.location.href = url;



        });



    })

</script>
@endsection
