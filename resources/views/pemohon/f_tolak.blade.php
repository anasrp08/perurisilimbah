<div class="modal fade" id="modaltolak">
    <div class="modal-dialog modal-lg" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='title_tolak' class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_tolak" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-md-4">
                         
                        
                        <div id="formnosurat" class="form-group">
                            <label for="nosurat">Alasan Ditolak</label>
                            <input type="text" name="alasan_tolak" id="alasan_tolak" class="form-control"
                                placeholder="Alasan Ditolak">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div> 
                    </div>
 
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <label>NP Perevisi</label>
                            <select name="np_penolak" id="np_penolak" class="form-control select2bs4"
                            style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value="" disabled selected>-</option>
                                @foreach($np as $data)
                                <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                                @endforeach
                            </select>
                        </div> 
                    </div> 
                </div>
                
                <input type="hidden" id="hidden_transaksi_tolak" name="hidden_transaksi_tolak" >
                <input type="hidden" id="hidden_id_tolak" name="hidden_id_tolak" > 
                <div class="box-footer">
                    <button name="simpan" id="simpan" class="btn btn-primary">Submit</button>
                    {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>