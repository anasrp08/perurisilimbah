<div class="modal fade" id="modalconfirm">
    <div class="modal-dialog modal-lg" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pack</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="type" name="type" >
                <div class="form-group">
                    <label>Nomor Pegawai</label>
                    <select name="np_packer" id="np_packer" class="form-control select2bs4"
                        style="width: 100%;">
                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                        <option value="" disabled selected>-</option>
                        @foreach($np as $data)
                        <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="box-footer">
                    <button name="submit" id="submit" class="btn btn-primary">Submit</button>
                  
                </div>
            </div>
        </div>
    </div>
</div>