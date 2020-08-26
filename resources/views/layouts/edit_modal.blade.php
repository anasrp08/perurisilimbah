<div id="formEdit" class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit_limbah" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <!-- jenis Uji -->
                        <span id="form_result"></span>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="text" id="entridate" name="entridate" class="form-control float-right">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Limbah</label>
                                    <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="" disabled selected>-Pilih Jenis Limbah-</option>
                                        @foreach($jenisLimbah as $data)
                                        <option value="{{$data->jenislimbah}}">{{$data->jenislimbah}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select name="satuan" id="satuan" class="form-control select2bs4"
                                        style="width: 100%;">
                                        {{-- <option value="-" selected="selected">Pilih Satuan</option> --}}
                                        <option value="" disabled selected>-Pilih Satuan-</option>
                                        @foreach($satuanLimbah as $data)
                                        <option value="{{$data->satuan}}">{{$data->satuan}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Limbah</label>
                                    <select name="namalimbah" id="namalimbah" class="form-control select2bs4"
                                        style="width: 100%;">
                                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                        <option value="" disabled selected>-Pilih Nama Limbah-</option>
                                        @foreach($namaLimbah as $data)
                                        <option value="{{$data->namalimbah}}">{{$data->namalimbah}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Fisik Limbah</label>
                                    <select name="fisiklimbah" id="fisiklimbah" class="form-control select2bs4"
                                        style="width: 100%;">
                                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                        <option value="" disabled selected>-Pilih Fisik Limbah-</option>
                                         
                                        <option value="Cair">Cair</option>
                                        <option value="Padat">Padat</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>TPS</label>
                                    <select name="tps" id="tps" class="form-control select2bs4" style="width: 100%;">
                                        {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                        <option value="" disabled selected>-Pilih TPS-</option>
                                        @foreach($tpsLimbah as $data)
                                        <option value="{{$data->namatps}}">{{$data->namatps}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Asal Limbah</label>
                                    <select name="limbahasal" id="limbahasal" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="" disabled selected>-Pilih Asal Limbah-</option>
                                        @foreach($penghasilLimbah as $data)
                                        <option value="{{$data->seksi}}">{{$data->seksi}} ({{$data->departemen}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- no surat -->
                                <div id="formnosurat" class="form-group">
                                    <label for="nosurat">Jumlah Limbah</label>
                                    <input type="text" name="jmlhlimbah" id="jmlhlimbah" class="form-control"
                                        placeholder="Jumlah Limbah">
                                    {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                                </div>

                                <div id="nonb3" class="form-group">
                                    <label>Limbah 3R</label>
                                    <select name="limbah3r" id="limbah3r" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="-" selected="selected">Pilih Satuan</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="hidden" name="jumlahlama" id="jumlahlama" />
                                <input type="hidden" name="idnamalimbah" id="idnamalimbah" />

                            </div>

                        </div>

                    </div>







            </div>
            <div class="modal-footer justify-content-between">
                <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Simpan" />
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{--   --}}
