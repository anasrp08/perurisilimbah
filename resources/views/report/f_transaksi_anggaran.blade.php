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
                    <input type="number" id="transaksi_total" name="transaksi_total"
                        class="formproses form-control float-right" autocomplete="off">
                </div>
                <div class="form-group pihakketiga">
                    <label>Konsumsi</label>
                    <input type="number" id="transaksi_konsumsi" name="transaksi_konsumsi" class="formproses form-control float-right"
                        autocomplete="off">
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
