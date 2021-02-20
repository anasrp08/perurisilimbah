<div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Header Data</h3>
        </div>
        <div class="card-body">
            {{-- <form id="input_limbah" enctype="multipart/form-data">
                @csrf --}}
            <div class="box-body">
                <!-- jenis Uji -->
                <span id="form_result"></span>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label>1. Tanggal Permohonan</label>
                            <input type="text" id="entridate" name="entridate"
                                class="entridate form-control float-right" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div id="formnosurat" class="form-group"> 
                                    <label for="nosurat">4. Jumlah Limbah</label>
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
                            <label for="nosurat">7. Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control"
                                placeholder="Keterangan">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>



                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>2. Jenis Limbah</label>
                            <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" disabled selected>-Pilih Jenis Limbah-</option>
                                {{-- <option value="1">Limbah B3  --}}
                                @foreach($jenisLimbah as $data)
                                <option value="{{$data->id}}">{{$data->jenislimbah}} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label>5. Asal Limbah</label>
                            <select name="limbahasal" id="limbahasal" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" disabled selected>-Pilih Asal Limbah-</option>
                                @foreach($penghasilLimbah as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="formnosurat" class="form-group">
                            <label for="nosurat">8. Maksud</label>
                            <input type="text" name="maksud" id="maksud" class="form-control" placeholder="Maksud">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>

                        <!-- no surat -->

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label>3. Nama Limbah</label>
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
                            <label>6. NP Pemohon</label>
                            <select name="np_pemohon" id="np_pemohon" class="form-control select2bs4" style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value="" disabled selected>-</option>
                                @foreach($np as $data)
                                <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                                @endforeach
                            </select>
                        </div>





                        <div id="nonb3" class="card card-danger" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Entri Data Non B3</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Limbah 3R</label>
                                    <select name="limbah3r" id="limbah3r" class="form-control select2bs4"
                                        style="width: 100%;">
                                        <option value="-"="selected">Pilih Satuan</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak" selected>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="box-footer">
                    <button name="copy" id="copy" class="btn btn-primary">Copy</button>
                    {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
