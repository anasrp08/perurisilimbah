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
<li class="breadcrumb-item active">Report Penghasil Limbah</li>
@endsection


@section('content')
<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        @include('report.f_filter_penghasil')

        <table id="daftar_penghasil" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Unit Kerja</th>
                    <th>Nama Limbah</th>
                    <th>Jenis Limbah</th>
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


        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#refresh').click(function () {

            $('#daftar_penghasil').DataTable().ajax.reload();

        })
        // $("#jenislimbah").change(function () {
        //     console.log($(this).val())
        //     getDropdown('{{ route("limbah.getnama")}}', "", $(this).val(), "namalimbah")

        // });
        $('#filter').click(function () {
            $('#daftar_penghasil').DataTable().draw(true);
        })

        function getDropdown(paramUrl, param1, param2, idkomponen) {

            var paramData
            if (idkomponen == 'namalimbah') {
                // console.log(param1)
                paramData = {
                    jenis: param2,
                    // fisik: param2
                }
                $.ajax({
                    url: paramUrl,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: paramData,
                    success: function (data) {
                        // if(data==''){

                        // }
                        $("#" + idkomponen).html(data.html);
                    }
                });
            } else {
                paramData = {
                    idlimbah: param2

                }
                $.ajax({
                    url: paramUrl,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: paramData,
                    success: function (data) {
                        $("#" + idkomponen).text(data.satuan);
                    }
                });
            }
        }

        var table = $('#daftar_penghasil').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            dom: '<lfr<t>ip>',

            columnDefs: [{
                    className: 'text-left',
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
                data: function (d) {
                    d.namalimbah = $('#namalimbah').val()
                    d.jenislimbah = $('#jenislimbah').val()
                    d.limbahasal = $('#limbahasal').val()
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
                    data: 'jumlah',
                    name: 'jumlah',

                },



            ]
        });


    })

</script>
@endsection
