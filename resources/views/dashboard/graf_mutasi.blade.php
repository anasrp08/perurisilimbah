<!-- Left col -->
<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Neraca Limbah
            </h3>

        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tahun Periode</label>
                        <select name="tahun_neraca" id="tahun_neraca" class="form-control select2bs4" style="width: 100%;">
                            <option value="" disabled selected>-Tahun-</option>
                            @foreach($tahun as $data)
                            <option value="{{$data}}">{{$data}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            
             
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nama Limbah</label>
                    <select name="namalimbah_neraca" id="namalimbah_neraca" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Pilih Nama Limbah-</option>
                        @foreach($namaLimbah as $data)
                        <option value="{{$data->id}}">{{$data->namalimbah}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4" style="positio:relatve;">
                <div class="text-bottom">               
               
                <button style="position: absolute;bottom: 17px;" name="display_neraca" id="display_neraca" class="btn btn-primary">Tampilkan</button>
            
            </div>
        </div> 
        </div>
            {{-- <div class="tab-content p-0"> --}}
            <!-- Morris chart - Sales -->
            {{-- <div class="chart tab-pane active" id="revenue-chart" style="position: relative; "> --}}
            <canvas id="graf_mutasi" style="height: 175px;"></canvas>
            {{-- </div> --}}

            {{-- </div> --}}
        </div><!-- /.card-body -->
    </div>
    {{-- <div class="row justify-content-center">
  
</div> --}}

</section>
