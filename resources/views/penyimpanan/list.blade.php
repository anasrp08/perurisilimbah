@extends('layouts.app')

<style type="text/css">
    td {
        white-space: nowrap;
    }

    td.wrapok {
        white-space: normal
    }

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Limbah Masuk</title>
@section('title')
<h1>Daftar Limbah Masuk</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Limbah Masuk</li>
@endsection


@section('content')

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftar_masuk" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tgl. Permohonan Angkut</th>
                    <th>Nama Limbah</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Asal Limbah</th>
                    <th>Jenis Limbah (B3/Non)</th>
                    <th>Fisik</th>
                    <th>Status</th>
                    <th>Tgl. Proses Masuk</th>

                </tr>
            </thead>

        </table>
    </div>
</div>

<!-- modal -->
{{-- @include('layouts.edit_modal') --}}

@include('penyimpanan.f_confirmnp')



</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#entridate').datepicker({
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

            $('#daftar_masuk').DataTable().ajax.reload();

        })


        var table = $('#daftar_masuk').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            paging:true,
            dom: '<"right"B>rtipl<"clear">',
            buttons: [
                {
                    text: 'Packing',
                    className: 'btn btn-info',
                    action: function (e, dt, node, config) {
                        // $('#type').val('Padat')
                        $('#modalconfirm').modal('show')
                        
                    }
                },
 
                {
                    extend: "selectAll",
                    text: 'Pilih Semua',
                    className: 'btn btn-default',
                },
                {
                    extend: 'selectNone',
                    text: 'Batal Pilih Semua',
                    className: 'btn btn-default',
                },
            ],
            columnDefs: [{
                    className: 'text-center',
                    targets: [1,   3, 4, 6]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            select: {
                style: 'multi'
            },
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('penyimpanan.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) { 
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
                    data: 'tgl',
                    name: 'tgl',
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
                    name: 'namalimbah'
                },
                {
                    data: 'jumlah_in',
                    name: 'jumlah_in'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'seksi',
                    name: 'seksi'
                },
                {
                    data: 'jenislimbah',
                    name: 'jenislimbah',

                },
                {
                    data: 'fisik',
                    name: 'fisik',

                },

                // {
                //     data: 'limbah3r',
                //     name: 'limbah3r'

                // },

                {
                    data: 'keterangan',
                    name: 'keterangan',
                    render: function (data, type, row) {

                        if (data == 'Input') {
                            return '<span class="badge badge-info">' + data + '</span>'
                        } else {
                            return '<span class="badge badge-success">' + data + '</span>'
                        }
                    }
                },


                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function (data, type, row) {

                        return moment(data).format('DD/MM/YYYY');

                    }
                },

            ]
        });
        $('#submit').on('click', function () {
            if( $('#type').val()=='Padat'){
                formatedData('Padat')
            }else{
                formatedData('Cair')
            }
           
            

        })

        function formatedData(fisik) {
            var output = [];
            var jsonData = {}
            var dataSelected = []
            var data1 = table.rows({
                selected: true
            }).data()
            console.log(data1.toArray())
            if (data1.count() == 0) {
                toastr.warning('Belum Ada Item Yang Dipilih', 'Warning', {
                    timeOut: 5000
                });
            } else { 
                    for (i = 0; i < data1.count(); i++) {
                       
                            var obj = {};
                            obj.limbah3r = data1[i].limbah3r;
                            obj.tgl = data1[i].tgl;
                            obj.idheader = data1[i].id;
                            obj.id_transaksi = data1[i].id_transaksi;
                            obj.idasallimbah = data1[i].idasallimbah;
                            obj.idlimbah = data1[i].idlimbah;
                            obj.idstatus = 3;
                            obj.fisik = data1[i].fisik;
                            obj.tps = data1[i].tps;
                            obj.pack = data1[i].pack_in;
                            obj.packing_besar = data1[i].packing_besar;
                            obj.idjenislimbah = data1[i].idjenislimbah;
                            obj.jumlah = data1[i].jumlah_in; 
                            obj.idsatuan = data1[i].idsatuan; 
                            obj.max_packing = data1[i].max_packing; 
                            obj.np_packer = $('#np_packer').val();
                            output.push(obj)
                            
                    }
                    jsonData["Order"] = output
                    // console.log(jsonData)
                    packLimbah(jsonData)
            }
            $('#np').val('').change()
            $('#modalconfirm').modal('toggle')

        }

        function packLimbah(jsonData) {
            $.ajax({
                url: "{{ route('penyimpanan.updatepack') }}",
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
                        $('#daftar_masuk').DataTable().ajax.reload();
                       

                    }

                }
            })
        }

      
        $('#daftar_masuk tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });
        var user_id
        $(document).on('click', '.valid', function () {

            toastr.success('Data Berhasil Terupdate', {
                timeOut: 5000
            });
            user_id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
             

        }); 



    })

</script>
@endsection
