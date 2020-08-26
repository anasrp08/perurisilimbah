<form method="post" id="edit_limbah" enctype="multipart/form-data">
    @csrf
    <div class="box-body">
        <!-- jenis Uji -->
        <span id="form_result"></span>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="text" id="entridate" name="entridate" class="form-control float-right">
        </div>
        <div class="form-group">
            <label>Jenis Limbah</label>
            <select name="jenislimbah" id="jenislimbah" class="form-control select2bs4" style="width: 100%;">
                <option value="" disabled selected>-Pilih Jenis Limbah-</option>
                @foreach($jenisLimbah as $data)
                <option value="{{$data->jenislimbah}}">{{$data->jenislimbah}} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Limbah</label>
            <select name="namalimbah" id="namalimbah" class="form-control select2bs4" style="width: 100%;">
                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                <option value="" disabled selected>-Pilih Nama Limbah-</option>
                @foreach($namaLimbah as $data)
                <option value="{{$data->namalimbah}}">{{$data->namalimbah}} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Fisik Limbah</label>
            <select name="fisiklimbah" id="fisiklimbah" class="form-control select2bs4" style="width: 100%;">
                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                <option value="" disabled selected>-Pilih Fisik Limbah-</option>
                @foreach($tipeLimbah as $data)
                <option value="{{$data->tipelimbah}}">{{$data->tipelimbah}} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Asal Limbah</label>
            <select name="limbahasal" id="limbahasal" class="form-control select2bs4" style="width: 100%;">
                <option value="" disabled selected>-Pilih Asal Limbah-</option>
                @foreach($penghasilLimbah as $data)
                <option value="{{$data->seksi}}">{{$data->seksi}} ({{$data->departemen}}) </option>
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
        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan" id="satuan" class="form-control select2bs4" style="width: 100%;">
                {{-- <option value="-" selected="selected">Pilih Satuan</option> --}}
                <option value="" disabled selected>-Pilih Satuan-</option>
                @foreach($satuanLimbah as $data)
                <option value="{{$data->satuan}}">{{$data->satuan}} </option>
                @endforeach
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

        <div id="nonb3" class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Entri Data Non B3</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Limbah 3R</label>
                    <select name="limbah3r" id="limbah3r" class="form-control select2bs4" style="width: 100%;">
                        <option value="-" selected="selected">Pilih Satuan</option>
                        <option value="y">Iya</option>
                        <option value="t">Tidak</option>
                    </select>
                </div>
            </div>
        </div>

    </div>


    <div class="box-footer">
        <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Simpan" />
        {{-- <button id="submit" type="submit" class="btn btn-primary" >Submit</button> --}}
    </div>
</form>