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
<title>Report Neraca Tahunan</title>
@section('title')
<h1>Report Neraca Tahunan</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Report Neraca Tahunan</li>
@endsection


@section('content')

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tahun Anggaran</label>
                    <select name="tahun_neraca" id="tahun_neraca" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Tahun-</option>
                        {{-- <option value="2021">2021</option>
                    <option value="2020">2020</option> --}}
                        @foreach($tahun as $data)
                        <option value="{{$data}}">{{$data}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Nama Limbah</label>
                    <select name="namalimbah" id="namalimbah" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-</option>
                        <option value="1,2,3">Limbah Wiping Solution</option>
                        <option value="7">Tinta Ex Cetak Dalam Kemesan Drum @ 200 Liter</option>
                        <option value="8">Limbah Sisiran LKU (Potongan Karung)</option>
                        <option value="9">Limbah Punch Bintang</option>
                        <option value="25">Lembar Kertas Sementara (LKS)</option>
                        <option value="34">Sludge IPAL</option>
                        <option value="35">Kain majun bekas (used rags) dan yang sejenis</option>
                        <option value="38">Slag atau bottom ash insinerator</option>
                        <option value="39">Lampu TL, Printer, PCB</option>
                        {{-- <option value="2021">2021</option>
                    <option value="2020">2020</option> --}}
                        {{-- @foreach($tahun as $data)
                        <option value="{{$data}}">{{$data}}</option>
                        @endforeach --}}
                    </select>
                </div>

            </div>

            <div class="col-md-1">
                <button style="position: absolute;bottom: 17px;" name="filter" id="filter"
                    class="btn btn-primary">Tampilkan</button>
            </div>

        </div>
        <table id="report_neraca" class="table table-hover" style="width:100%;">
        </table>
    </div>

</div>



{{-- @include('pemrosesan.detail_pack')  --}}



</section>

@endsection

@section('scripts')
{{-- <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script> --}}
<script src="{{ asset('/adminlte3/plugins/datatables/dataTables.rowsGroup.js') }}"></script>
<script>
    $(document).ready(function () {
 
        $('#tahun_neraca').val(moment().format('YYYY')).change()
         


        $('#refresh').click(function () {

            $('#report_neraca').DataTable().ajax.reload();

        })
        // $('#filter').click(function () {

        //     $('#report_neraca').DataTable().ajax.reload();

        // })
        $('#filter').click(function () {
            console.log($('#namalimbah').val())
            if($('#namalimbah').val() ==null){
                toastr.warning('Belum Memilih Nama Limbah', 'Peringatan', {
                            timeOut: 5000
                        });
            }else{
                packLimbah(function (data) { 
            var columns = []; 
            columnNames = data.column;
            var dataRow = data.dataRow 
            for (var i in dataRow) {
                dataRow[i];
            }
            for (var i in columnNames) {
                columns.push({
                    title: columnNames[i], 
                    name:columnNames[i]
                });
            }
 
            $('#report_neraca').DataTable({
                scrollCollapse: true,
                scrollX: true,
                autoWidth: true,
                dom: '<"right"B>frtipl<"clear">',
                // buttons: [  'excel', 'pdf' ],
                buttons: [
            {
                // https://codepen.io/RedJokingInn/pen/XMVoXL
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Laporan Neraca Limbah Periode '+  $('#tahun_neraca').val(),
                download: 'open',
                // exportOptions: {
				// 		columns: ':visible',
					 
				// 	},
            },
            {
                extend: 'excel',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Laporan Neraca Limbah Periode '+  $('#tahun_neraca').val(),
                download: 'open'
            },
            
        ],
                columns: columns,
                ordering: false,
                "bDestroy": true,
                data: dataRow,
                rowsGroup: [  
                    0,
                    1,
                    2,
                    3,
                    37
                    
                ],
            });

        });
            }
            

})
 
        

        function packLimbah(data) {
            // console.log($('#namalimbah').text())
            var paramData = {
                tahun: $('#tahun_neraca').val(),
                namalimbah: $('#namalimbah').val()
            }
            $.ajax({
                url: "{{ route('neraca_tahunan.data') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                data: paramData,
                beforeSend: function () {
                    $('#saveentri').text('proses menyimpan...');
                },
                success: data
            })
        }





    })

</script>
@endsection
