@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Entri Data Limbah</title>
@section('title')
<h1>Entri Permohonan Angkut Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Entri Data</li>

@endsection

@section('content')



<div class="row">
    @include('pemohon.f_pemohon')
    @include('pemohon.tbl_pemohon')
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () { 
        $('#nonb3').hide() 
        var counter = 1;
        // if (lastNumber != 0) {
        //     counter = lastNumber + 1;
        // }
        $('#jenislimbah').change(function () {
            if ($("#jenislimbah option:selected").index() == 1) {
                $("#nonb3").hide();
            } else {
                $("#nonb3").show();

            }
        });

        $('#entridate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd/mm/yyyy',
            todayHighlight: true
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        function isEmpty(comp) {
            if ($("#" + comp).val() == "") {
                var html = '';
                html = '<div class="alert alert-danger">' +
                    '<p>Form ' + comp + ' kosong</p>' +

                    '</div>';
                $('#form_result').html(html);
                return false
            } else {
                return true
            }
        }
        $("#jenislimbah").change(function () {
            getDropdown('{{ route("limbah.getnama")}}', "", $(this).val(), "namalimbah")

        });
     
        $("#namalimbah").change(function () {
            getDropdown('{{ route("limbah.getsatuan")}}', "", $(this).val(), "satuan")

        });
 
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
                        console.log(data)
                        // if(data==''){

                        // }
                        $("#" + idkomponen).html(data.html);
                    }
                });
            } else {
                paramData = {
                    idlimbah: param2

                }
                 console.log(param2)
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
        var table = $('#tbl_pemohon').DataTable({

            scrollX: true,
            searching: false,
            scrollY: "300px",
            scrollCollapse: true,
            paging: false,
            ordering: false,
            dom: 'Bfrtip',
            language: {
                emptyTable: "Tidak Ada Data Permohonan"
            },
            select: {
                style: 'multi'
            },
//             createdRow: function ( row, data, index ) {
//                 $('.select2bs4').select2({
//                 theme: 'bootstrap4'
//             })
//         },
//         drawCallback: function() {
//             $('.select2bs4').select2({
//                 theme: 'bootstrap4'
//             })
//   },
            buttons: [

                {
                    text: '<h6 style="color:white"> Hapus Baris</h6>',
                    className: 'btn-info btn-sm',
                    action: function (e, dt, node, config) {

                        var selectedLength = table.rows('.selected').data().length
                        if (selectedLength != 0) {
                            for (i = 0; i < selectedLength; i++) {
                                table.row('.selected').remove().draw(false);
                                // counter= counter - (t.rows('.selected').data().length)
                            }
                            counter = counter - (selectedLength)
                            // table.cell({row:2, column:0}).data(counter);
                        }
                    }
                }

            ],

            order: [
                [0, 'asc']
            ],

        });

        function assignToInput(collectid, counter) {

            var valWarna;

            var getValueInput = [
                $("#entridate").val(),
                $("#jmlhlimbah").val(),
                $("#keterangan").val(),
                // valWarna
            ]


            var getSelected = [
                $("#np").val(),
                $("#jenislimbah").val(),
                $("#namalimbah").val(),
                $("#limbahasal").val(),
                $("#limbah3r").val(),

            ]



            for (i = 0; i < collectid[0].length; i++) {

                $("#id" + collectid[0][i] + counter).val(getValueInput[i])

            }
            // console.log(getSelected)
            for (j = 0; j < collectid[1].length; j++) {

                $('select[name=' + collectid[1][j]+']').find('option[value="' + getSelected[j] +'"]').attr("selected", true).change();
                // document.getElementById("id" + collectid[1][j] + counter).selectedIndex = getSelected[j];
            }
            // selectbs4()
        }


        function createInputTextEnabled(id, counter, data) {
            return '<input style="width:auto;"type="text" name="' + id + '"  id="id' + id + counter +
                '" class="form-control" value="' + data + '" >'
        }



        function createDropdown(id, counter, option) {
            // selectbs4()
            return '<select name="' + id+ '" id="' + id + counter +  '" class="form-control select2bs4" style="width: auto;">' +
                option + '</select>'


        }
        $('#copy').on('click', function () {
            // selectbs4()
            console.log($("#namalimbah").val())
            collectid = [
                [
                    "tgl",
                    "jmlhlimbah",
                    "keterangan"

                ],
                [
                    "np",
                    "jenis_limbah",
                    "nama_limbah",
                    "asal_limbah",
                    "limbah_3r",
                ]

            ]

            table.row.add([
                //id table
                counter,

                // createInputTextDisabled("uji", counter, counter), 
                createDropdown("np", counter,
                    ' <option value="" disabled selected>-</option>' +
                    '@foreach($np as $data)' +
                    '<option value="{{$data->id}}" >{{$data->np}}</option>' +
                    '@endforeach' +
                    '</select>'),
                createInputTextEnabled("tgl", counter, ""),
                createDropdown("nama_limbah", counter,
                    '<option value="" disabled selected>-</option>' +
                    '@foreach($namaLimbah as $data)' +
                    '<option value="{{$data->id}}" >{{$data->namalimbah}}</option>' +
                    '@endforeach' +
                    '</select>'),

                createDropdown("jenis_limbah", counter,
                    ' <option value="" disabled selected>-</option> ' +
                    '@foreach($jenisLimbah  as $data)' +
                    '<option value="{{$data->id}}">{{$data->jenislimbah}} </option>' +
                    '@endforeach' +
                    '</select>'),


                createDropdown("asal_limbah", counter,
                    ' <option value="" disabled selected>-</option>' +
                    '@foreach($penghasilLimbah as $data)' +
                    '<option value="{{$data->id}}" >{{$data->seksi}}</option>' +
                    '@endforeach' +
                    '</select>'),

                createInputTextEnabled("jmlhlimbah", counter, ""),
                createDropdown("limbah_3r", counter,
                    '<option value="" selected="selected">-</option>' +
                    '<option value="Ya">Ya</option>' +
                    '<option value="Tidak">Tidak</option>'),
                createInputTextEnabled("keterangan", counter, ""),

            ]).draw(false);

            assignToInput(collectid, counter);
            counter++;
            selectbs4()


        });
        

        function selectbs4() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        }

        $('#save').click(function () { 
            var myTable = $("#tbl_pemohon").DataTable();
            var form_data = myTable.rows().data();
            console.log(form_data)
            if (table.rows().count() == 0) {
                toastr.warning('Tidak ada inputan hasil uji pita cukai', 'Hasil Uji Kosong', {
                    timeOut: 5000
                });
            } else {

                var output = [];
                var jsonData = {}

                $("tbody tr").each(function () {
                     
                    if ($(":input[name=tgl]", this).val() == undefined) {

                    } else {
                        var obj = {};
                        obj.tgl = $(":input[name=tgl]", this).val();
                        obj.nama_limbah = $("select[name=nama_limbah]", this).val();
                        obj.jenis_limbah = $("select[name=jenis_limbah]", this).val();
                        obj.asal_limbah = $("select[name=asal_limbah]", this).val();
                        obj.jmlhlimbah = $(":input[name=jmlhlimbah]", this).val();
                        obj.limbah_3r = $("select[name=limbah_3r]", this).val();
                        obj.np = $(":input[name=np]", this).val();
                        obj.keterangan = $(":input[name=keterangan]", this).val();
                        // console.log(obj)
                        output.push(obj);
                    }

                });

                // var idJadwal = {
                //     idjadwal: idjadwal
                // }
                jsonData["Data"] = output
                // jsonData["idJadwal"] = idJadwal
                console.log(jsonData)


                $.ajax({
                    url: "{{ route('pemohon.store') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(jsonData),
                    // contentType: "json",
                    // cache: false,
                    // processData: false,
                    // dataType: "json",
                    beforeSend: function () {
                        // $('#saveentri').text('proses menyimpan...');
                    },
                    success: function (data) {

                        if (data.errors) {
                            toastr.error(data.errors, 'Error', {
                                timeOut: 5000
                            });
                        }
                        if (data.success) {
                            toastr.success(data.success, 'Tersimpan', {
                                timeOut: 5000
                            });
                            // $('#counterentries').text(data.count);

                            // $('#saveentri').text('Simpan');

                            location.reload();

                        }

                    }
                })
            }

        });


    })

</script>
@endsection
