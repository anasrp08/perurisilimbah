<section class="col-lg-12 connectedSortable">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Kuota Limbah B3
            </h3>
            <div class="card-tools">
                {{-- <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul> --}}
            </div>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="chart tab-pane" id="revenue-chart" style="position: relative;">
                            <canvas id="cair"></canvas>
                            <div id="js-legend" class="chart-legend"></div>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                            <canvas id="sludge"></canvas>
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
            </div>
        </div><!-- /.card-body -->
    </div>
</section>
