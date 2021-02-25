<div class="modal fade" id="transaksiKuota">
    <div class="modal-dialog modal-lg" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transaksi Kuota Anggaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group nonpihakketiga">
                    <label>Tipe Limbah</label>
                    <select name="transaksi_tipelimbah" id="transaksi_tipelimbah" class="formproses form-control select2bs4" style="width: 100%;">
                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                        <option value="" disabled >-</option>
                        @foreach($tipeLimbah as $data)
                        <option value="{{$data->id}}">{{$data->tipelimbah}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group pihakketiga">
                    <label>Tahun</label>
                    <input type="number" id="transaksi_tahun" name="transaksi_tahun"
                        class="formproses form-control float-right" autocomplete="off">
                </div>
                <div class="form-group pihakketiga">
                    <label>Total Kuota Anggaran</label>
                    <input type="text" id="transaksi_total" name="transaksi_total"
                        class="numberinput formproses form-control " autocomplete="off">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div  class="form-group"> 
                            <label for="nosurat">Jumlah</label>
                            <div class="input-group input-group mb-3">
                                <input type="text" name="jmlhlimbah" id="jmlhlimbah" class="numberinput form-control">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label id='labelharga'></label>
                            <input type="text" id="dataharga" name="dataharga" class="numberinput formproses form-control "
                        autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group pihakketiga">
                            <label>Total Konsumsi</label>
                            <input type="text" id="transaksi_konsumsi" name="transaksi_konsumsi" class="numberinput formproses form-control "
                                autocomplete="off">
                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="anggaran_id" name="anggaran_id">
                <div class="form-group nonpihakketiga">
                    <label>Diinput Oleh</label>
                    <select name="transaksi_np" id="transaksi_np" class="formproses form-control select2bs4"
                        style="width: 100%;">
                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                        <option value="" disabled selected>-</option>
                        @foreach($np as $data)
                        <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" id="simpan_transaksi">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
