<!-- Left col -->
<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Penghasil Limbah
            </h3>

        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">

                        <label>Periode</label>
                        <input type="text" id="period" name="period" class="entridate form-control float-right"
                            autocomplete="off">
                    </div>
                </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Asal Limbah</label>
                    <select name="limbahasal" id="limbahasal" class="form-control select2bs4" style="width: 100%;">
                        <option value="" disabled selected>-Pilih Asal Limbah-</option>
                        @foreach($penghasilLimbah as $data)
                        <option value="{{$data->id}}">{{$data->seksi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
            {{-- <div class="tab-content p-0"> --}}
            <!-- Morris chart - Sales -->
            {{-- <div class="chart tab-pane active" id="revenue-chart" style="position: relative; "> --}}
            <canvas id="penghasil_all" style="height: 175px;"></canvas>
            {{-- </div> --}}

            {{-- </div> --}}
        </div><!-- /.card-body -->
    </div>
    {{-- <div class="row justify-content-center">
  
</div> --}}

</section>
