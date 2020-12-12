<div class="modal fade" id="modalrevisi">
    <div class="modal-dialog modal-lg" style="width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='title_revisi' class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_revisi" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label>Tanggal Permohonan</label>
                            <input type="text" id="entridate" name="entridate"
                                class="entridate form-control float-right" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div id="formnosurat" class="form-group"> 
                                    <label for="nosurat">Jumlah Limbah</label>
                                    <div class="input-group input-group mb-3">
                                        <input type="number" name="jmlhlimbah" id="jmlhlimbah" class="form-control">
 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div id="formnosurat" class="form-group">
                                    <label>Satuan</label>
                                    <select name="satuan" id="satuan" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="" disabled selected>-Pilih Satuan-</option>
                                        @foreach($satuanLimbah as $data)
                                        <option value="{{$data->id}}">{{$data->satuan}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div id="formnosurat" class="form-group">
                            <label for="nosurat">Jumlah Limbah</label>
                            <div class="input-group input-group">
                                <input type="number" name="jmlhlimbah" id="jmlhlimbah" class="form-control">
                                <span class="input-group-append">
                                    <span id='satuan' class="input-group-text">-</span>
                                </span>
                            </div>

                        </div> --}}
                        <div id="formnosurat" class="form-group">
                            <label for="nosurat">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control"
                                placeholder="Keterangan">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>
                        
                        <div id="formnosurat" class="form-group">
                            <label for="nosurat">Alasan Revisi</label>
                            <input type="text" name="alasan" id="alasan" class="form-control"
                                placeholder="Keterangan">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>



                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Limbah</label>
                            <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" disabled selected>-Pilih Jenis Limbah-</option>
                                @foreach($jenisLimbah as $data)
                                <option value="{{$data->id}}">{{$data->jenislimbah}} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Asal Limbah</label>
                            <select name="limbahasal" id="limbahasal" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" disabled selected>-Pilih Asal Limbah-</option>
                                @foreach($penghasilLimbah as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="formnosurat" class="form-group">
                            <label for="nosurat">Maksud</label>
                            <input type="text" name="maksud" id="maksud" class="form-control" placeholder="Maksud">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>

                        <!-- no surat -->

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Nama Limbah</label>
                            <select name="namalimbah" id="namalimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value="" disabled selected>-Pilih Nama Limbah-</option>
                                @foreach($namaLimbah as $data)
                                <option value="{{$data->id}}">{{$data->namalimbah}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nomor Pegawai</label>
                            <select name="np" id="np" class="form-control select2bs4"
                            style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value="" disabled selected>-</option>
                                @foreach($np as $data)
                                <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                                @endforeach
                            </select>
                        </div>





                        <div id="nonb3" class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Entri Data Non B3</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Limbah 3R</label>
                                    <select name="limbah3r" id="limbah3r" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="-" selected="selected">Pilih Satuan</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                
                <input type="hidden" id="hidden_transaksi" name="hidden_transaksi" >
                <input type="hidden" id="hidden_id" name="hidden_id" >
                <div class="box-footer">
                    <button name="simpan" id="simpan" class="btn btn-primary">Submit</button>
                    {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>