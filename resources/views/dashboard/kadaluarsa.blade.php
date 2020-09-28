
     <!-- TABLE: LATEST ORDERS -->
     <section class="col-lg-12 connectedSortable">
     <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">Limbah Akan Kadaluarsa</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <table id="datakadaluarsa" class="table table-bordered table-striped" style="width:100%;" >
            <thead>
                <tr>
                  <th>Nama Limbah</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Sekarang</th>
                  <th>Tanggal Kadaluarsa</th>
                  <th>TPS</th>
                  <th>Status</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
             
        </table>
    </div>
      
      {{-- <div class="card-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
      </div> --}}
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
     </section>