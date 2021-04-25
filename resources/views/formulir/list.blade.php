@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Formulir Limbah</title>
@section('title')
<h1>Daftar Formulir Serah Terima Limbah</h1>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
<li class="breadcrumb-item active">Daftar Formulir Serah Terima Limbah</li>

@endsection

@section('content')



<div class="row">

    @include('formulir.f_filter')

    @include('formulir.tbl_formulir')
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var seksi = '<?php echo $username->seksi ?>'
        $('input[name="f_date"]').daterangepicker({
            format: 'DD/MM/YYYY',
            autoUpdateInput: false,
            autoclose: true,
            todayHighlight: true,
            locale: {
                cancelLabel: 'Clear'
            }

        })
        $('input[name="f_date"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                'DD/MM/YYYY'));
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#filter').click(function () {
            // console.log('tes')
            $('#tbl_formulir').DataTable().ajax.reload();
        })

        $('#refresh').click(function () {

            $('#tbl_formulir').DataTable().ajax.reload();

        })
        var table = $('#tbl_formulir').DataTable({

            // columnDefs: [{
            //         className: 'text-center',
            //         targets: [1, 2, 3]
            //     },
            //     {
            //         className: 'dt-body-nowrap',
            //         targets: -1
            //     }
            // ],
            columnDefs: [{
                    className: 'text-center',
                    targets: [1, 4, 5, 6]
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
                data: function (d) {
                    d.idasallimbah = seksi
                    d.namalimbah = $('#f_namalimbah').val()
                    d.limbahasal = $('#f_limbahasal').val()
                    d.f_date = $('#f_date').val()
                }
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
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'idmutasi',
                    name: 'idmutasi'
                },
                {
                    data: 'no_surat',
                    name: 'no_surat'
                },
                {
                    data: 'namalimbah',
                    name: 'namalimbah'
                },
                {
                    data: 'tgl',
                    name: 'tgl',
                    render: function (data, type, row) {
                        if (data == null || data == "" || data == "NULL") {
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
                // {
                //     data: 'jenislimbah',
                //     name: 'jenislimbah'
                // },
                // {
                // data: 'limbah3r',
                // name: 'limbah3r',
                // render: function (data, type, row) {
                // if (data == null || data == "" ||
                // data == "NULL") {
                // return '-'
                // } else {
                // return data
                // }

                // }
                // },
                {
                    data: 'keterangan',
                    name: 'keterangan',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ]

        });
        $('#tbl_formulir tbody').on('click', '.download', function () {

            var dataRow = table.row($(this).parents('tr')).data();

            if (seksi == dataRow.idasallimbah || seksi == 'admin' || seksi == 'operator' || seksi ==
                'pengawas') {
                var url = '{{ route("formulir.cetak",[":id_transaksi",":asal"])}}';
                url = url.replace(":id_transaksi", dataRow.id);
                url = url.replace(":asal", dataRow.idasallimbah);
                document.location.href = url;
            } else {
                toastr.warning('User yang dipakai tidak diijinkan', 'Perhatian', {
                    timeOut: 5000
                });
            }




        });



    })

</script>
@endsection
