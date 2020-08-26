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
<title>Daftar Record Limbah</title>
@section('title')
<h1>Daftar Record Limbah limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Limbah</li>
@endsection


@section('content')

<!-- Main content --
<!-- Default box -->
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Filter Data</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div id="formkantor" class="form-group">
                    <label>Nama Limbah</label>
                    <select name="f_nmlimbah" id="f_nmlimbah" class="form-control select2bs4" style="width: 100%;">

                        <option value="" disabled selected>-Pilih Nama Limbah-</option>
                        @foreach($namaLimbah as $data)
                        <option value="{{$data->namalimbah}}">{{$data->namalimbah}} </option>
                        @endforeach
                    </select>
                </div>

                <div id="formkantor" class="form-group">
                    <label>Jenis Limbah</label>
                    <select name="f_jenislimbah" id="f_jenislimbah" class="form-control select2bs4"
                        style="width: 100%;">
                        <option value="" disabled selected>-Pilih Jenis Limbah-</option>
                        @foreach($jenisLimbah as $data)
                        <option value="{{$data->jenislimbah}}">{{$data->jenislimbah}} </option>
                        @endforeach
                    </select>
                </div>
                <div id="formkantor" class="form-group">
                    <label>Fisik Limbah</label>
                    <select name="f_fisiklimbah" id="f_fisiklimbah" class="form-control select2bs4"
                        style="width: 100%;">
                        <option value="" disabled selected>-Pilih Fisik Limbah-</option>
                        @foreach($tipeLimbah as $data)
                        <option value="{{$data->tipelimbah}}">{{$data->tipelimbah}} </option>
                        @endforeach
                    </select>
                </div>


            </div>
            <!-- no surat -->
            <div class="col-md-4">

                <div class="form-group">
                    <label>Tanggal Mutasi Input </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" name="f_tglinput" id="f_tglinput">
                    </div>

                </div>

                <div id="formkantor" class="form-group">
                    <label>Asal Limbah</label>
                    <select name="f_asallimbah" id="f_asallimbah" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Pilih Asal Limbah-</option>
                        @foreach($penghasilLimbah as $data)
                        <option value="{{$data->seksi}}">{{$data->seksi}} ({{$data->departemen}}) </option>
                        @endforeach}}
                    </select>
                </div>
                <div id="formkantor" class="form-group">
                    <label>TPS Limbah</label>
                    <select name="f_tpslimbah" id="f_tpslimbah" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Pilih TPS-</option>
                        @foreach($tpsLimbah as $data)
                        <option value="{{$data->namatps}}">{{$data->namatps}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">

                <div id="formkantor" class="form-group">
                    <label>Mutasi</label>
                    <select name="f_mutasi" id="f_mutasi" class="form-control select2bs4" style="width: 100%;">

                    </select>
                </div>
                <div id="formkantor" class="form-group">
                    <label>Limbah 3R</label>
                    <select name="f_limbah3r" id="f_limbah3r" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Pilih Limbah 3R-</option>

                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>

                    </select>
                </div>

            </div>
            <div class="card-footer">
                <button type="button" name="search" id="search" class="btn btn-success "><i class="fa  fa-search"></i>
                    Filter</button>
            </div>


        </div>
    </div>
    <!-- /.box-body -->
</div>

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="refresh" id="refresh" class="btn btn-success "><i class="fa  fa-refresh"></i>
            Refresh</button>
    </div>
    <div class="card-body">
        <table id="daftarlimbah" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal</th>
                    <th>Nama Limbah</th>
                    <th>Jumlah</th>
                    {{-- <th>Satuan</th> --}}
                    <th>Jenis Limbah (B3/Non)</th>
                    <th>Fisik</th>
                    {{-- <th>Limbah 3R</th> --}}
                    <th>Status</th>
                    <th>TPS</th>
                    <th>Tanggal Dibuat</th>
                    
                    {{-- <th width="30%">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>07/08/2020</td>
                    <td>Limbah Sludge</td>
                    <td>300 karung</td>
                    <td>Limbah B3</td>
                    <td>Padat</td>
                    <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                    <td>TPS IV</td>
                    <td>07/08/2020</td>
                    
                </tr>
                <td>1</td>
                <td>07/08/2020</td>
                <td>Limbah Sludge</td>
                <td>300 karung</td>
                <td>Limbah B3</td>
                <td>Padat</td>
                <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                <td>TPS I</td>
                <td>07/08/2020</td>
                </tr>
                <td>1</td>
                <td>07/08/2020</td>
                <td>Limbah Sludge</td>
                <td>300 karung</td>
                <td>Limbah B3</td>
                <td>Padat</td>
                <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                <td>TPS II</td>
                <td>07/08/2020</td>
                </tr>
                <td>1</td>
                <td>07/08/2020</td>
                <td>Limbah Sludge</td>
                <td>300 karung</td>
                <td>Limbah B3</td>
                <td>Padat</td>
                <td><span class="badge badge-warning">Permohonan Angkut</span></td>
                <td>TPS III</td>
                <td>07/08/2020</td>
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
