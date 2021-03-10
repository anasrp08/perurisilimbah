<div class="col-md-12">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
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

                            <label>Tanggal Permohonan</label>
                            <input type="text" id="entridate" name="entridate"
                                class="entridate form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Asal Limbah</label>
                            <select name="limbahasal" id="limbahasal" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value=""  selected>-</option>
                                @foreach($penghasilLimbah as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Limbah</label>
                            <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" selected>-</option>
                                @foreach($jenisLimbah as $data)
                                <option value="{{$data->id}}">{{$data->jenislimbah}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control select2bs4" style="width: 100%;">
                                <option value=""  selected>-</option>
                                @foreach($status as $data)
                                <option value="{{$data->id}}">{{$data->keterangan}} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>Nomor Pegawai</label>
                            <select name="np" id="np" class="form-control select2bs4" style="width: 100%;">
                                <option value="-" selected="selected">Pilih Salah Satu</option>
                                <option value="" disabled selected>-</option>
                                @foreach($np as $data)
                                <option value="{{$data->np}}">{{$data->np}}-{{$data->nama}} </option>
                                @endforeach
                            </select>
                        </div> --}}




                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Nama Limbah</label>
                            <select name="namalimbah" id="namalimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value=""  selected>-</option>
                                @foreach($namaLimbah as $data)
                                <option value="{{$data->id}}">{{$data->namalimbah}} </option>
                                @endforeach
                            </select>
                        </div>
                       


                    </div>


                </div>


                <div class="text-center">
                    <button name="filter" id="filter" class="btn btn-primary">Filter</button>
                    {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
