@if (Auth::check())
@role(['admin','operator'])
<li class="nav-item">
    <a href="{{ url('/') }}" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
{{-- @endrole --}}
{{-- @role(['admin','operator']) --}}
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemohon.entri') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Buat Permohonan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Permohonan</p>
                {{-- <span class="badge badge-info right"></span> --}}
            </a>
        </li>

    </ul>
</li>
{{-- @endrole --}}
{{-- @role(['admin']) --}}
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Penyimpanan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('penyimpanan.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Packing Limbah</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('limbah.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Packing</p>
            </a>
        </li>  --}}

    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Pemrosesan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemrosesan.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Proses Limbah</p>
            </a>
        </li>
        
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('lain.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Proses Limbah Lain-Lain</p>
            </a>
        </li>
        
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('kontrak.listview') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Kuota Anggaran B3</p>
    </a>
     
</li> 
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Cetak Fomulir
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Formulir Limbah</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Report Monitoring
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Formulir Limbah</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('history.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Histori Transaksi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('neraca.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Neraca Limbah</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('kadaluarsa.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Limbah Kadaluarsa</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('kapasitas.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Kapasitas</p>
            </a>
        </li>
        
       
        <li class="nav-item">
            <a href="{{ route('penghasil.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Penghasil Limbah</p>
            </a>
        </li>
    </ul>
</li>  
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
  
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>User Login</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nama_limbah.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Nama Limbah</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vendor.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Vendor Limbah</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('neraca.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Master Data Nama Limbah</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('kapasitas.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Kapasitas</p>
            </a>
        </li>
        
       
        <li class="nav-item">
            <a href="{{ route('penghasil.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Penghasil Limbah</p>
            </a>
        </li> --}}
    </ul>
</li> 

@endrole
@role(['unit kerja'])
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Fomulir Serah Terima
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Formulir Limbah</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemohon.entri') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Buat Permohonan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Permohonan</p>
                {{-- <span class="badge badge-info right"></span> --}}
            </a>
        </li>

    </ul>
</li>
@endrole
@role(['pengawas'])
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Fomulir Serah Terima
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Formulir Limbah</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
       
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Permohonan</p>
                {{-- <span class="badge badge-info right"></span> --}}
            </a>
        </li>

    </ul>
</li>
@endrole
  
    <li class="nav-item">
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
          {{-- <i class="fa fa-sign-out"></i> --}}
          <i class="nav-icon fas fa-tree"></i>
          {{-- <i class="far fa-circle nav-icon"></i> --}}
          <p>Logout</p>
      </a>
  
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
  </li>
  @endif
  
