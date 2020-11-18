<div class="modal fade" id="modaldetail">
    <div class="modal-dialog modal-lg" style="width:100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pack</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="detail_pack" class="table table-hover table-bordered" >
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Limbah</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Tipe Limbah</th>
                            <th>Jenis Limbah</th>
                            <th>Jumlah Proses</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="text-align:right">Total:</th>
                            <th><th/>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- radio -->
                        <label for="radioPrimary1">
                            Pemrosesan Limbah
                        </label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary1" name="r1" value='incinerator'>
                                <label for="radioPrimary1">
                                    Incinerator
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="r1" value='netralisir'>
                                <label for="radioPrimary2">
                                    Netralisir
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary3" name="r1" value='ketiga'>
                                <label for="radioPrimary3">
                                    Pihak Ketiga
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group nonpihakketiga">
                                    <label>Tanggal Proses</label>
                                    <input type="text" id="prosesdate" name="prosesdate"
                                        class="formproses form-control float-right" autocomplete="off">
                                </div>
                                <div class="form-group pihakketiga">
                                    <label>No. Manifest</label>
                                    <input type="text" id="nomanifest" name="nomanifest"
                                        class="formproses form-control float-right" autocomplete="off">
                                </div>


                            </div>
                            <div class="col-sm-4">
                                <div class="form-group nonpihakketiga">
                                    <label>Nomor Pegawai</label>
                                    <select name="np" id="np" class="formproses form-control select2bs4"
                                        style="width: 100%;">
                                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                        <option value="" disabled selected>-</option>
                                        @foreach($np as $data)
                                        <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group pihakketiga">
                                    <label>Vendor Pengangkut</label>
                                    <select name="vendor" id="vendor" class="formproses form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="" disabled selected>-Pilih Vendor-</option>
                                        @foreach($vendor as $data)
                                        <option value="{{$data->id}}">{{$data->namavendor}} </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group pihakketiga">
                                    <label>No. Kendaraan</label>
                                    <input type="text" id="nokendaraan" name="nokendaraan"
                                        class="formproses form-control float-right" autocomplete="off">
                                </div>
                                <div class="form-group pihakketiga" style="margin-top: 3.4rem;">
                                    <label>No. SPBE</label>
                                    <input type="text" id="nospbe" name="nospbe"
                                        class="formproses form-control float-right" autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>

            <div class="modal-footer justify-content-between">

                <button type="button" class="btn btn-primary" id="proses">Proses</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
