<div class="modal fade" id="modalEdit">
    <div class="modal-dialog modal-lg" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Kuota Anggaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="form-group nonpihakketiga">
                    <label>Tipe Limbah</label>
                    <select name="tipelimbah" id="tipelimbah" class="formproses form-control select2bs4" style="width: 100%;">
                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                        <option value="" disabled >-</option>
                        @foreach($tipeLimbah as $data)
                        <option value="{{$data->id}}">{{$data->tipelimbah}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group pihakketiga">
                    <label>Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="formproses form-control float-right"
                        autocomplete="off">
                </div>
                <div class="form-group pihakketiga">
                    <label>Total</label>
                    <input type="text" id="total" name="total" class="numberinput formproses form-control float-right"
                        autocomplete="off">
                </div>
                <div class="form-group nonpihakketiga">
                    <label>Diinput Oleh</label>
                    <select name="np" id="np" class="formproses form-control select2bs4" style="width: 100%;">
                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                        <option value="" disabled>-</option>
                        @foreach($np as $data)
                        <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="hidden_id" name="hidden_id">

            </div>

            <div class="modal-footer justify-content-between">

                <button type="button" class="btn btn-primary" id="simpan_edit">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
