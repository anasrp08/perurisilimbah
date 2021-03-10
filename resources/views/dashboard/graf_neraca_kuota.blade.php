<!-- Left col -->
<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Grafik Neraca Kuota Anggaran
            </h3>

        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tahun Anggaran</label>
                        <select name="tahun_kuota" id="tahun_kuota" class="form-control select2bs4"
                            style="width: 100%;">
                            <option value="" disabled selected>-Tahun-</option>
                            {{-- <option value="2021">2021</option>
                        <option value="2020">2020</option> --}}
                            @foreach($tahun as $data)
                            <option value="{{$data}}">{{$data}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>


                <div class="col-md-1">
                    <button style="position: absolute;bottom: 17px;" name="display_kuota" id="display_kuota"
                        class="btn btn-primary">Tampilkan</button>



                </div>
                {{-- <div class="col-md-3">
                    <button style="position: absolute;bottom: 17px;" name="lihat_detail" id="lihat_detail"
                        class="btn btn-success">Lihat Detail</button>



                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="chart tab-pane" id="revenue-chart" style="position: relative;">
                        <canvas id="graf_kuota_cair"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart tab-pane" id="revenue-chart" style="position: relative;">
                        <canvas id="cair"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="graf_kuota_sk"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="sk"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="graf_kuota_sludge"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="sludge"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="graf_kuota_abu"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="abu"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="graf_kuota_TL"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                        <canvas id="lamputl"></canvas>
                        <div id="js-legend" class="chart-legend"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="tab-content p-0"> --}}
        <!-- Morris chart - Sales -->
        {{-- <div class="chart tab-pane active" id="revenue-chart" style="position: relative; "> --}}

        {{-- </div> --}}

        {{-- </div> --}}
    </div><!-- /.card-body -->
    </div>
    {{-- <div class="row justify-content-center">
  
</div> --}}

</section>
