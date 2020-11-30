@extends('layouts.app') 
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar User Login</title>
@section('title')
<h1>Daftar User Login</h1>

@endsection
@section('content')

<div class="card card-info">
    <div class="card-header">
        <button type="button" name="tambahuser" id="tambahuser" class="btn btn-success"><i
            class="fa  fa-plus-circle"></i> Tambah User</button>
            <button type="button" name="refresh" id="refresh" class="btn btn-success"><i
                class="fa  fa-sync-alt"></i> Refresh</button>
    </div>
    <div class="card-body">
        <table id="tbluser" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Seksi</th>
                    <th>Email</th> 
                    <th>Role</th>
                    <th width="30%">Action</th>
                </tr>
            </thead>

        </table>
    </div>
</div>
@include('MasterData.f_add_user')
  

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmation</h2> --}}
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $("#show_hide_password button").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
 
        // var SITEURL = '{{URL::to('')}}';
        var tableUser = $('#tbluser').DataTable({
            processing: true,
            serverSide: true,
            scrollCollapse: true,
            scrollX: true,
            ajax: {

                url: "{{ route('user.list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },


            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                // {
                //     data: 'avatar',
                //     name: 'avatar',
                //     render: function (data, type, row) {
                       
                //         if (row.avatar == null || row.avatar == "") {
                           
                //             return '<span class="label bg-maroon"> Tidak Ada foto</span>'
                          
                //         } else {
                //             return '<img class="profile-user-img img-responsive img-circle" src ="{{ asset("/img")}}' +
                //                 '/' + row.avatar +
                //                 '" style="width:128px; height:129;">' 
                //                 //publish
                //                 // return '<img class="profile-user-img img-responsive img-circle" src ="{{ asset("project/public/img")}}' +
                //                 // '/' + row.avatar +
                //                 // '" style="width:128px; height:129;">'
                //         }
                //     }
                // },

                {
                    data: 'name',
                    name: 'name'

                },
                {
                    data: 'seksi',
                    name: 'seksi'

                },
                {
                    data: 'email',
                    name: 'email'
                },
                
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });


        $('#tambahuser').click(function () {
            $('.modal-title').text("Tambah User");
            $('#action_button').val("Simpan");
            $('#action').val("Add");
            $("#success-alert").hide();
            $('#formModal').modal('show');
        });
        $('#refresh').click(function () {
        $('#tbluser').DataTable().ajax.reload();
        })
        $('#formModal').on('hidden.bs.modal', function () {
            $('#sample_form')[0].reset();
        })

        $('body').on('click', '.edit', function () {
            $("#success-alert").hide();
            var id = $(this).data('id');
            var data = tableUser.row($(this).closest('tr')).data();
            console.log(data)
            $('.modal-title').text("Edit User");
            $('#userCrudModal').html("Edit User");
            $('#action').val("Edit");
            $('#action_button').val("Edit");
            $('#formModal').modal('show');
            $('#name').val(data.name);
            $('#email').val(data.email); 
           

            $('#roles').val(data.roles).trigger('change')
           
            $('#hidden_id').val(data.id);

        });

        



        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            console.log(new FormData(this))
            if ($('#action').val() == 'Add') {
                $.ajax({
                    url: "{{ route('user.store') }}",
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
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            toastr.success('Data Berhasil Di Simpan', 'Success Alert', {
                                timeOut: 5000
                            });
                            $('#sample_form')[0].reset();
                            $('#tbluser').DataTable().ajax.reload();
                            $('#action_button').val('Simpan');
                           

                        }

 
                    }
                })
            }

            if ($('#action').val() == "Edit") {
                $.ajax({
                    url: "{{ route('user.update') }}",
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
                            $('#action_button').val('Edit');
                        }
                        if (data.success) {
                            toastr.success('Data Berhasil Di Simpan', 'Tersimpan', {
                                timeOut: 5000
                            });
                            $('#sample_form')[0].reset();
                            $('#action_button').val('Edit');
                            $('#tbluser').DataTable().ajax.reload();

                            setTimeout(function () {
                                $('#formModal').modal('toggle');

                            }, 1000);
                        }
                    }
                });
            }
        })



        //delete
        var user_id;

        $(document).on('click', '.delete', function () {
            user_id = $(this).data('id');
            $("#success-alert").hide();
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function () {
            $.ajax({
                url: "user/destroy/" + user_id,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    toastr.success('Data Berhasil Di Hapus', 'Terhapus', {
                        timeOut: 5000
                    });
                    setTimeout(function () {
                        $('#ok_button').text('OK');
                        $('#confirmModal').modal('hide');
                        $('#tbluser').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });


    })

 
</script>
@endsection