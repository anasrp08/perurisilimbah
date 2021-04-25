@if (Auth::check())
@role(['admin'])
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
        <i class="nav-icon fas fa-industry"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemohon.entri') }}" class="nav-link">
                <i class="fas fa-pencil-square nav-icon"></i>
                <p>Buat Permohonan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
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
        <i class="nav-icon fas fa-archive"></i>
        <p>
            Penyimpanan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('penyimpanan.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
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
        <i class="nav-icon fas fa-truck"></i>
        <p>
            Pemrosesan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemrosesan.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Proses Limbah</p>
            </a>
        </li>
        
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('lain.listview') }}" class="nav-link">
                <i class="fas fa-list nav-icon"></i>
                <p>Proses Limbah Lain-Lain</p>
            </a>
        </li>
        
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Anggaran Kontrak B3
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('kontrakb3.view') }}" class="nav-link">
                <i class="fas fa-pencil-square nav-icon"></i>
                <p>Pencatatan Anggaran</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('kontrak.listview') }}" class="nav-link">
                <i class="fas fa-list nav-icon"></i>
                <p>Neraca Anggaran</p>
            </a>
        </li>
    </ul>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('kontrak.listview') }}" class="nav-link">
        <i class="far fa-envelope nav-icon"></i>
        <p>Kuota Anggaran B3</p>
    </a>
     
</li>  --}}
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Fomulir Limbah
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir Serah Terima</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ba_pemusnahan.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir BA Pemusnahan</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th-list"></i>
        <p>
            Report Monitoring
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route("neraca_tahunan.list") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Neraca Limbah</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('history.listview') }}" class="nav-link">
                <i class="far fa-list-alt  nav-icon"></i>
                <p>Histori Transaksi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('neraca.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Report Mutasi Limbah</p>
            </a>
        </li>
       
        <li class="nav-item">
            <a href="{{ route('kapasitas.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Report Kapasitas</p>
            </a>
        </li>
        
       
        <li class="nav-item">
            <a href="{{ route('penghasil.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Report Penghasil Limbah</p>
            </a>
        </li>
    </ul>
</li>  
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
  
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <span>User Login</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nama_limbah.index') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <span>Nama Limbah</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('vendor.index') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <span>Vendor Limbah</span>
            </a>
        </li> 
        
         <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Kontrak B3</span>
            </a>
        </li>
    </ul>
</li> 

{{-- 
<li class="treeview {!! Request::is('settings/*') ? 'active' : '' !!}">
    <a href="#">
        <i class="fa fa-gear"></i> <span>Pengaturan</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{!! Request::is('settings/profil*') ? 'active' : '' !!}">
            <a href="{{ url('/settings/profile/') }}">
                <i class="fa fa-user-o"></i> Profil
            </a>
        </li>
        <li class="{!! Request::is('settings/password') ? 'active' : '' !!}">
            <a href="{{ url('/settings/password') }}">
                <i class="fa fa-lock"></i> Ubah Password
            </a>
        </li>
    </ul>
</li> --}}

@endrole
@role(['operator'])
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Fomulir Limbah
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir Serah Terima</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ba_pemusnahan.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir BA Pemusnahan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-industry"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemohon.entri') }}" class="nav-link">
                <i class="fas fa-pencil-square nav-icon"></i>
                <p>Buat Permohonan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Daftar Permohonan</p>
                {{-- <span class="badge badge-info right"></span> --}}
            </a>
        </li>

    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-archive"></i>
        <p>
            Penyimpanan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('penyimpanan.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Packing Limbah</p>
            </a>
        </li> 
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-truck"></i>
        <p>
            Pemrosesan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemrosesan.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Proses Limbah</p>
            </a>
        </li>
        
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('lain.listview') }}" class="nav-link">
                <i class="fas fa-list nav-icon"></i>
                <p>Proses Limbah Lain-Lain</p>
            </a>
        </li>
        
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th-list"></i>
        <p>
            Report Monitoring
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
         
        <li class="nav-item">
            <a href="{{ route('history.listview') }}" class="nav-link">
                <i class="far fa-list-alt  nav-icon"></i>
                <p>Histori Transaksi</p>
            </a>
        </li>
         
    </ul>
</li>  
@endrole
@role(['unit kerja'])
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Fomulir Limbah
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir Serah Terima</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ba_pemusnahan.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir BA Pemusnahan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-industry"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pemohon.entri') }}" class="nav-link">
                <i class="fas fa-pencil-square nav-icon"></i>
                <p>Buat Permohonan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
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
        <i class="nav-icon fas fa-copy"></i>
        <p>
            Fomulir Limbah
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formulir.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir Serah Terima</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ba_pemusnahan.listview') }}" class="nav-link">
                <i class="far fa-file-text nav-icon"></i>
                <p>Fomulir BA Pemusnahan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-industry"></i>
        <p>
            Pengangkutan
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">6</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
       
        
        <li class="nav-item">
            <a href="{{ route('pemohon.listview') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <p>Daftar Permohonan</p>
                {{-- <span class="badge badge-info right"></span> --}}
            </a>
        </li>

    </ul>
</li>
 
@endrole
<li class="nav-item has-treeview {!! Request::is('settings/*') ? 'active' : '' !!}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
           Pengaturan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
  
    <ul class="nav nav-treeview">
        {{-- <li class="nav-item {!! Request::is('settings/profil*') ? 'active' : '' !!}">
            <a href="{{ url('/settings/profile/') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <span>Profile</span>
            </a>
        </li> --}}
        <li class="nav-item {!! Request::is('settings/password') ? 'active' : '' !!}">
            <a href="{{ url('/settings/password') }}" class="nav-link">
                <i class="far fa-list-alt nav-icon"></i>
                <span>Ubah Password</span>
            </a>
        </li>
       
    </ul>
</li> 
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
  
