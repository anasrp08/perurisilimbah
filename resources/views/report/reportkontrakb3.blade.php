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
<title>Report Kontrak Limbah</title>
@section('title')
<h1>Report Kontrak Limbah </h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Report Kontrak Limbah</li>
@endsection


@section('content')

 
<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
            <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
                Download Excel</button>
    </div>
    <div class="card-body">
        <table id="daftarlimbah" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No. </th> 
                    <th>Tipe Limbah</th>
                    <th>Kontrak</th>
                    <th>Konsumsi</th>
                    <th>Sisa</th> 
                    <th>Status</th> 
                    {{-- <th width="30%">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td> 
                    <td>Limbah Cair B3</td>
                    <td>7000000000</td>
                    <td>5000000000</td>
                    <td>2000000000</td>  
                    <td><span class="badge badge-success">Aman</span></td>
                </tr>
                <tr>
                    <td>2</td> 
                    <td>Limbah Sampah Kontaminasi</td>
                    <td>1110000000</td>
                    <td>1100000000</td>
                    <td>10000000</td>  
                    <td><span class="badge badge-warning">waspada</span></td> 
                </tr>
                <tr>
                    <td>3</td> 
                    <td>Sludge</td>
                    <td>1110000000</td>
                    <td>390000000</td>
                    <td>720000000</td>  
                    <td><span class="badge badge-danger">bahaya</span></td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

<!-- modal -->
@include('layouts.edit_modal')

@include('layouts.confimdelete')



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
        // $('.select2').select2()
        $('#jenislimbah').change(function () {
            if ($(this).val() == "Limbah B3") {
                $("#nonb3").hide();

            } else {
                $("#nonb3").show();

            }
        });
        $('input[name="f_tglinput"]').daterangepicker({
            format: 'DD/MM/YYYY',
            autoUpdateInput: false,
            autoclose: true,
            locale: {
                cancelLabel: 'Clear'
            }

        })
        $('input[name="f_tglinput"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
        // $('input[name="f_tgloutput"]').daterangepicker({
        //     format: 'DD/MM/YYYY',
        //     autoUpdateInput: false,
        //     autoclose: true,
        //     locale: {
        //         cancelLabel: 'Clear'
        //     }

        // })
        // $('input[name="f_tgloutput"]').on('apply.daterangepicker', function (ev, picker) {
        //     $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        // });

        //Date picker
        $('#entridate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });

        $('#refresh').click(function () {

            $('#daftarlimbah').DataTable().ajax.reload();

        })


        // var table = $('#daftarlimbah').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     scrollCollapse: true,
        //     scrollX: true,

        //     columnDefs: [{
        //             className: 'text-center',
        //             targets: [1, 2, 3, 4, 5, 6, 7, 8, 9]
        //         },
        //         {
        //             className: 'dt-body-nowrap',
        //             targets: -1
        //         }
        //     ],
        //     language: {
        //         emptyTable: "Tidak Ada Data"
        //     },
        //     search: {
        //         caseInsensitive: false
        //     },
        //     ajax: {
        //         url: "{{ route('limbah.list') }}",
        //         type: "POST",
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //         },
        //         data: function (d) {


        //             d.jenislimbah = $(":input[name=f_jenislimbah]").val();
        //             d.namalimbah = $(":input[name=f_nmlimbah]").val();
        //             d.tglinput = $('#f_tglinput').val();
        //             d.mutasi = $(":input[name=f_status]").val();
        //             d.fisik = $(":input[name=f_fisiklimbah]").val();
        //             d.asallimbah = $(":input[name=f_asallimbah]").val();
        //             d.tpslimbah = $(":input[name=f_tpslimbah]").val();
        //             d.limbah3r = $(":input[name=f_limbah3r]").val();


        //         }
        //     },
        //     bFilter: false,
        //     columns: [{
        //             data: 'DT_RowIndex',
        //             name: 'DT_RowIndex',
        //             orderable: false,
        //             searchable: false
        //         },
        //         {
        //             data: 'tgl',
        //             name: 'tgl',
        //             render: function (data, type, row) {
        //                 if (data == null || data == "-" || data == "0000-00-00 00:00:00" || data == "NULL") {
        //                     return '<span>-</span>'
        //                 } else {
        //                     return moment(data).format('DD/MM/YYYY');
        //                 }

        //             }
        //         },
        //         {
        //             data: 'namalimbah',
        //             name: 'namalimbah'
        //         },
        //         {
        //             data: 'jumlah',
        //             name: 'jumlah'
        //         },
        //         // {
        //         //     data: 'satuan',
        //         //     name: 'satuan'
        //         // },
        //         {
        //             data: 'jenislimbah',
        //             name: 'jenislimbah',

        //         },
        //         {
        //             data: 'fisik',
        //             name: 'fisik'

        //         },
        //         // {
        //         //     data: 'limbah3r',
        //         //     name: 'limbah3r'

        //         // },

        //         {
        //             data: 'mutasi',
        //             name: 'mutasi',
        //             render: function (data, type, row) {

        //                 if (data == 'Input') {
        //                     return '<span class="badge badge-info">' + data + '</span>'
        //                 } else {
        //                     return '<span class="badge badge-success">' + data + '</span>'
        //                 }
        //             }
        //         },
        //         {
        //             data: 'tps',
        //             name: 'tps',
                    
        //         },

        //         {
        //             data: 'created_at',
        //             name: 'created_at',
        //             render: function (data, type, row) {

        //                 return moment(data).format('DD/MM/YYYY');

        //             }
        //         },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false

        //         }
        //     ]
        // });

        // new $.fn.dataTable.FixedColumns(table, {
        //     leftColumns: 3,
        //     heightMatch: 'auto'
        // });



        $(document).on('click', '.delete', function () {
            user_id = $(this).data('id');
            $("#success-alert").hide();
            var data = table.row($(this).closest('tr')).data();

            $('#confirmModal').modal();

        });
        $(document).on('click', '.valid', function () {
            toastr.success('Data Berhasil Terupdate', {
                                timeOut: 5000
                            });

        });


        var user_id;
        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');
            var data = table.row($(this).closest('tr')).data();
            var tglCatat
            // var tglCatat = moment(data.tgl).format('DD/MM/YYYY');
            if (data.tgl == "-" || data.tgl == "0000-00-00 00:00:00" || data.tgl === null) {
                tglCatat = ""
            } else {
                tglCatat = moment(data.tgl).format('DD/MM/YYYY');
            }
            $('#jenislimbah').val(data.jenislimbah).change()
            $('#entridate').val(tglCatat)
            $('#satuan').val(data.satuan).change()
            $('#namalimbah').val(data.namalimbah).change()
            $('#fisiklimbah').val(data.fisik).change()
            $('#tps').val(data.tps).change()
            $('#limbahasal').val(data.asallimbah).change()
            $('#jmlhlimbah').val(data.jumlah)
            $('#limbah3r').val(data.limbah3r).change()
            $('#hidden_id').val(data.id)
            $('#jumlahlama').val(data.jumlah)
            $('#idnamalimbah').val(data.idnama)
             
            

            $('#formEdit').modal();




        });

        $('#edit_limbah').on('submit', function (event) {
            event.preventDefault();
            
                $.ajax({
                    url: "{{ route('limbah.update') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        $('#action_button').val('menyimpan...');
                    },
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div id=error class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_result').html(html);
                            $('#action_button').val('Simpan');
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Tersimpan', {
                                timeOut: 5000
                            });
                            $('#edit_limbah')[0].reset();
                            $('#action_button').val('Simpan');
                            $('#daftarlimbah').DataTable().ajax.reload();
                            setTimeout(function () {
                                $('#formEdit').modal('toggle');
                            }, 1000);
                        }
                    }
                });
            
        })



    })

</script>
@endsection
