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
        <table id="daftarlimbah" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. </th> 
                    <th>Tipe Limbah</th>
                    <th>Total</th>
                    <th>Konsumsi</th>
                    <th>Sisa</th>
                    <th>Tahun</th> 
                    <th>Status</th> 
                    {{-- <th width="30%">Action</th> --}}
                </tr>
            </thead>
             
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


        var table = $('#daftarlimbah').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,

            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 2, 3]
                },
                {
                    className: 'dt-body-nowrap',
                    targets: -1
                }
            ],
            language: {
                emptyTable: "Tidak Ada Data"
            },
            search: {
                caseInsensitive: false
            },
            ajax: {
                url: "{{ route('kontrak.data') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {


                    // d.jenislimbah = $(":input[name=f_jenislimbah]").val();
                    // d.namalimbah = $(":input[name=f_nmlimbah]").val();
                    // d.tglinput = $('#f_tglinput').val();
                    // d.mutasi = $(":input[name=f_status]").val();
                    // d.fisik = $(":input[name=f_fisiklimbah]").val();
                    // d.asallimbah = $(":input[name=f_asallimbah]").val();
                    // d.tpslimbah = $(":input[name=f_tpslimbah]").val();
                    // d.limbah3r = $(":input[name=f_limbah3r]").val();


                }
            },
            bFilter: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tipe_limbah',
                    name: 'tipe_limbah',
                    
                },
                {
                    data: 'konsumsi',
                    name: 'konsumsi',
                    render: function (data, type, row) {
                        var totalKuota=parseInt(row.konsumsi) + parseInt(row.sisa)
                        return totalKuota
                    }
                },
                {
                    data: 'konsumsi',
                    name: 'konsumsi'
                },
                {
                    data: 'sisa',
                    name: 'sisa'
                },
                
                {
                    data: 'tahun',
                    name: 'tahun'

                },

                {
                    data: 'sisa',
                    name: 'sisa',
                    render: function (data, type, row) {
                        var totalKuota=parseInt(row.konsumsi) + parseInt(row.sisa)
                        var kuota_danger=Math.round(parseInt(totalKuota) * parseInt(90) / parseInt(100))
                        var kuota_warning=Math.round(parseInt(totalKuota) * parseInt(75) / parseInt(100))
                        if(parseInt(row.konsumsi) >= kuota_warning && parseInt(row.konsumsi) <= kuota_danger ){
                            return '<span class="badge badge-warning">Waspada</span>' 
                        }else if(parseInt(row.konsumsi) > kuota_danger){
                            return '<span class="badge badge-danger">Bahaya</span>'
                        }else{
                            return '<span class="badge badge-success">Aman</span>'
                        }

                         
                    }
                },
                
            ]
        });

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
