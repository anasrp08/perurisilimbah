
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Unit Kerja 
                </h3>
            
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label>Periode</label>
  
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control float-right" id="period">
                    </div>
                    <!-- /.input group -->
                  </div>
                 

                 
                {{-- <div class="tab-content p-0"> --}}
                    <!-- Morris chart - Sales -->
                    {{-- <div class="chart tab-pane active" id="revenue-chart" style="position: relative; "> --}}
                      <canvas id="penghasil_unit_kerja" style="height: 175px;"></canvas>
                    {{-- </div> --}}
                   
                {{-- </div> --}}
            </div><!-- /.card-body -->
        </div>
        {{-- <div class="row justify-content-center">
  
</div> --}}

    </section>

