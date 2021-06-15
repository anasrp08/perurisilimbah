<div class="card card-info">
    <div class="card-header">
        <h4>Pencatatan Kontrak Limbah</h4>
        {{-- <button type="button" name="download" id="download" class="btn btn-success "><i class="fa  fa-refresh"></i>
        Download Excel</button> --}}
        {{-- <button type="button" name="tambah" id="tambah" class="btn btn-success "><i class="fa  fa-plus"></i>
            Tambah Master Data Kuota Anggaran</button> --}}
        {{-- <button type="button" name="transaksi" id="transaksi" class="btn btn-success "><i class="fa  fa-save"></i>
        Transaksi Konsumsi Anggaran</button> --}}
    </div>
    <div class="card-body"> 
        <form id="tambah_transaksi" enctype="multipart/form-data" method="post">
            @csrf
            <div class="form-group nonpihakketiga">
                <label>Tipe Limbah</label>
                <select name="transaksi_tipelimbah" id="transaksi_tipelimbah" class="formproses form-control select2bs4"
                    style="width: 100%;">
                    {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                    <option value=""  selected>-</option>
                    @foreach($tipeLimbah as $data)
                    <option value="{{$data->id}}">{{$data->tipelimbah}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tahun</label>
                <input type="number" id="transaksi_tahun" name="transaksi_tahun"
                    class="formproses form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Total Kuota Anggaran</label>
                <input type="text" id="transaksi_total" name="transaksi_total"
                    class="numberinput formproses form-control " autocomplete="off">
            </div> 
            <div class="form-group">
                <label id='labelharga'>xxx</label>
                <input type="text" id="dataharga" name="dataharga" class="numberinput formproses form-control "
                    autocomplete="off">
            </div>
            <div class="form-group">
                <label>Jumlah (Gunakan . untuk desimal)</label>
                <div class="input-group input-group mb-3">
                    <input type="text" name="jmlhlimbah" id="jmlhlimbah" class=" form-control">

                </div>
            </div> 
           
            
            <div class="form-group pihakketiga">
                <label>Total Konsumsi</label>
                <input type="text" id="transaksi_konsumsi" name="transaksi_konsumsi"
                    class="numberinput formproses form-control " autocomplete="off">
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



            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" id="simpan_transaksi">Simpan</button>
                {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
            </div>
        </form>
    </div>
</div>
