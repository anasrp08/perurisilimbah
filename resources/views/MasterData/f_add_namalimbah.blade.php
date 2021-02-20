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
                <form method="post" id="f_namalimbah" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label">Jenis Limbah : </label>
                        <div class="col-md-12">
                            <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected>-Jenis Limbah-</option>
                                @foreach($jenisLimbah as $data)
                                <option value="{{$data->jenislimbah}}">{{$data->jenislimbah}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Nama Limbah : </label>
                        <div class="col-md-12">
                            <input type="text" name="namalimbah" id="namalimbah" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tipe Limbah : </label>
                        <div class="col-md-12">
                            <input type="text" name="tipelimbah" id="tipelimbah" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Fisik : </label>
                        <div class="col-md-12">
                            <select name="fisiklimbah" id="fisiklimbah" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected>-Fisik-</option>
                                <option value="Padat">Padat</option>
                                <option value="Cair">Cair</option>
                                {{-- @foreach($jenisLimbah as $data)
                                <option value="{{$data->id}}">{{$data->jenislimbah}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Satuan : </label>
                        <div class="col-md-12">
                            <select name="satuan" id="satuan" class="form-control select2bs4" style="width: 100%;">
                                <option value="" selected>-Satuan-</option>
                                @foreach($satuanLimbah as $data)
                                <option value="{{$data->satuan}}">{{$data->satuan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id='saldo_form' class="form-group" style='display:none;'>
                        <label class="control-label">Saldo : </label>
                        <div class="col-md-12">
                            <input type="number" name="saldo" id="saldo" class="form-control" />
                        </div>
                    </div>
                     

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
