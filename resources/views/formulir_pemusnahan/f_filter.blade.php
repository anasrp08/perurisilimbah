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
                    <div class="col-md-6"> 
                        <div class="form-group">
                            <label>Tanggal Pemusnahan </label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    {{-- <i class="fa fa-calendar"></i> --}}
                                </div>
                                <input type="text" name="f_date" id="f_date" class="form-control pull-right"
                                    autocomplete="off">
                            </div>
                        </div>
                        @role(['admin','operator','pengawas'])
                        <div class="form-group">
                            <label>Asal Limbah</label>
                            <select name="f_limbahasal" id="f_limbahasal" class="form-control select2bs4"
                                style="width: 100%;">
                                <option value="" selected>-</option>
                                @foreach($penghasilLimbah as $data)
                                <option value="{{$data->id}}">{{$data->seksi}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endrole
                    </div>


                    <div class="col-md-6"> 
                        <div class="form-group">
                            <label>Nama Limbah</label>
                            <select name="f_namalimbah" id="f_namalimbah" class="form-control select2bs4"
                                style="width: 100%;">
                                {{-- <option value="-" selected="selected">Pilih Salah Satu</option> --}}
                                <option value="" selected>-</option>
                                @foreach($namaLimbah as $data)
                                <option value="{{$data->id}}">{{$data->namalimbah}} </option>
                                @endforeach
                            </select>
                        </div> 
 

                    </div>




                </div>


                <div class="text-center">
                    <button name="filter" id="filter" class="btn btn-primary">Filter</button>

                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
