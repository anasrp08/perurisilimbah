<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label">Unit Kerja : </label>
                        <div class="col-md-12">
                            <select name="unit_kerja" id="unit_kerja" class="form-control select2bs4" style="width: 100%;">
                                <option selected>-Pilih Unit Kerja-</option>
                                @foreach($unit_kerja as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nama User : </label>
                        <div class="col-md-12">
                            <input type="text" name="name" id="name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username Email : </label>
                        <div class="col-md-12">
                            <input type="text" name="email" id="email" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password : </label>

                        <div class="col-md-12">
                            <div class="input-group" id="show_hide_password">
                                <input class="form-control" type="password" name="password" id="password">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fa fa-eye-slash"
                                            aria-hidden="true"></i></button>
                                </div>
                            </div>
                             
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label class="control-label col-md-4">Instansi : </label>
                        <div class="col-md-8">
                            <select name="instansi" id="instansi" class="form-control select2" style="width: 100%;">
                                <option selected="selected">Pilih Salah Satu</option>
                                <option value="Peruri">Peruri</option>
                                <option value="PT. Pura Nusapersada">PT. Pura Nusapersada</option>
                                <option value="PT. Kertas Padalarang">PT. Kertas Padalarang</option>
                                <option value="Admin">Admin</option>
                                <option value="Beacukai">Beacukai</option>
                            </select>

                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label class="control-label">Role : </label>
                        <div class="col-md-12">
                            <select name="roles" id="roles" class="form-control select2" style="width: 100%;">
                                <option selected>-Pilih Role-</option>
                                @foreach($roles as $data)
                                <option value="{{$data->display_name}}">{{$data->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label class="control-label">Upload Foto : </label>
                        <div class="col-md-12">
                            <input type="file" name="avatar" id="avatar" class="form-control" />
                        </div> --}}
                        {{-- <p class="help-block">file surat perintah</p> --}}

                    {{-- </div> --}}

                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                            value="Add" />
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
