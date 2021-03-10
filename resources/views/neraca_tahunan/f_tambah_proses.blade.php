<div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Proses</h3>
        </div>
        <div class="card-body">
            <form id="input_proseslain" enctype="multipart/form-data"method="post">
                @csrf
            <div class="box-body">
                <!-- jenis Uji -->
                <span id="form_result"></span>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Limbah</label>
                            <input type="text" id="nama_limbah" name="nama_limbah" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Permohonan</label>
                            <input type="text" id="tgl_proses" name="tgl_proses"
                                class="tgl_proses form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control"
                                placeholder="Keterangan">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>

                        <div class="form-group" id="alasan" style="display: none;">
                            <label >Alasan Revisi</label>
                            <input type="text" name="alasan" id="alasan" class="form-control"
                                placeholder="Alasan Revisi">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>
                       
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Limbah</label>
                            <div class="input-group input-group mb-3">
                                <input type="number" name="jmlh" id="jmlh" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Asal Limbah</label>
                            <input type="text" id="unit_penghasil" name="unit_penghasil" class="form-control"
                                autocomplete="off">
                            {{-- <select name="unit_penghasil" id="unit_penghasil" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" disabled selected>-Pilih Asal Limbah-</option>
                                @foreach($penghasilLimbah as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="form-group">
                            <label>Treatmen Proses Limbah</label>
                            <input type="text" name="treatmen" id="treatmen" class="form-control"
                                placeholder="Treatmen Proses Limbah">
                            {{-- <small class="text-danger">{{ $errors->nosurat->first() }}</small> --}}
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" id="satuan" name="satuan" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>NP Pemroses</label>
                            <select name="np_pemroses" id="np_pemroses" class="form-control select2bs4"
                                style="width: 100%;">
                               
                                <option value="" disabled selected>-</option>
                                @foreach($np as $data)
                                <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Upload File</label>
                            <br>
                            <input type="file" name="file" id="file">
                        </div>
                    </div> 

                </div>
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="transaksi" id="transaksi" />
                {{-- <input type="hidden" name="jumlahlama" id="jumlahlama" /> --}}

                <div class="box-footer text-center">
                    <button name="submit" id="submit" class="btn btn-primary">Submit</button>
                    
                    {{-- <button id="update" name="update" type="submit" class="btn btn-warning" disabled>Update</button> --}}
                    {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
                </div>
                </form>
                
            </div>
        </div>
    </div>
