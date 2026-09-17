<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-globe"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SDGs Desa</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manage Data
    </div>

    <li class="nav-item {{ request()->is('desa') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/desa') }}">
            <i class="fas fa-home"></i>
            <span>Desa</span></a>
    </li>

    <li class="nav-item {{ request()->is('data-rt.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/data-rt') }}">
            <i class="fas fa-users"></i>
            <span>Rukun Tetangga (RT)</span></a>
    </li>

    <li class="nav-item {{ request()->is('kg-p2.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/kg-p2') }}">
            <i class="fas fa-house-user"></i>
            <span>Keluarga</span></a>
    </li>

    <li class="nav-item {{ request()->is('idv-p1.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/idv-p1') }}">
            <i class="fas fa-user"></i>
            <span>Individu</span></a>
    </li> 

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-heading">
        Manage User
    </div>

    <li class="nav-item {{ request()->is('userweb') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/userweb') }}">
            <i class="fas fa-user-cog"></i>
            <span>User</span></a>
    </li>

    <li class="nav-item {{ request()->is('jabatan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/jabatan') }}">
            <i class="fas fa-briefcase"></i>
            <span>Jabatan</span></a>
    </li>

    <li class="nav-item {{ request()->is('survey') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/survey') }}">
            <i class="fas fa-poll"></i>
            <span>Survey</span></a>
    </li>

    {{-- <li class="nav-item {{ request()->is('lembaga') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/lembaga') }}">
            <i class="fas fa-building"></i>
            <span>Master Lembaga</span></a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->is('lembaga*') || request()->is('bencana*') || request()->is('gunasumber*') || request()->is('jenisindustri*') || request()->is('lingkungan*') || request()->is('operatorsinyal*') || request()->is('saranaekonomi*') || request()->is('tvradio*') || request()->is('apst*') || request()->is('faskes*') || request()->is('pendidikan*') || request()->is('penghasilan*') || request()->is('penyakit*') || request()->is('sarkes*') || request()->is('tenkes*') ? '' : '' }}"
            href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="{{ request()->is('lembaga*') || request()->is('apst*') || request()->is('faskes*') || request()->is('pendidikan*') || request()->is('penghasilan*') || request()->is('penyakit*') || request()->is('sarkes*') || request()->is('tenkes*') ? 'true' : 'false' }}"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Master</span>
        </a>

        <div id="collapsePages"
            class="collapse {{ request()->is('lembaga*') || request()->is('bencana*') || request()->is('gunasumber*') || request()->is('jenisindustri*') || request()->is('lingkungan*') || request()->is('operatorsinyal*') || request()->is('saranaekonomi*') || request()->is('tvradio*') || request()->is('apst*') || request()->is('faskes*') || request()->is('pendidikan*') || request()->is('penghasilan*') || request()->is('penyakit*') || request()->is('sarkes*') || request()->is('tenkes*') ? 'show' : '' }}"
            aria-labelledby="headingPages" data-parent="#accordionSidebar"
            style="color: whitesmoke !important;background: transparent !important;">

            <div class="bg-transparent text-white py-2 collapse-inner rounded"
                style="color: whitesmoke !important;background: transparent !important;">

                <a class="collapse-item link-dp {{ request()->is('lembaga*') ? 'active' : '' }}" href="{{ url('/lembaga') }}">
                    Lembaga
                </a>

                <a class="collapse-item link-dp {{ request()->is('bencana*') ? 'active' : '' }}" href="{{ url('/bencana') }}">
                    Bencana Alam
                </a>
                <a class="collapse-item link-dp {{ request()->is('gunasumber*') ? 'active' : '' }}" href="{{ url('/gunasumber') }}">
                    Penggunaan Sumber
                </a>
                <a class="collapse-item link-dp {{ request()->is('jenisindustri*') ? 'active' : '' }}"
                    href="{{ url('/jenisindustri') }}">
                    Jenis Industri
                </a>
                <a class="collapse-item link-dp {{ request()->is('operatorsinyal*') ? 'active' : '' }}"
                    href="{{ url('/operatorsinyal') }}">
                    Operator Sinyal
                </a>
                <a class="collapse-item link-dp {{ request()->is('lingkungan*') ? 'active' : '' }}" href="{{ url('/lingkungan') }}">
                    Jenis Lingkungan
                </a>
                <a class="collapse-item link-dp {{ request()->is('saranaekonomi*') ? 'active' : '' }}"
                    href="{{ url('/saranaekonomi') }}">
                    Sarana Ekonomi
                </a>
                <a class="collapse-item link-dp {{ request()->is('tvradio*') ? 'active' : '' }}" href="{{ url('/tvradio') }}">
                    Program Tv Radio
                </a>
                <a class="collapse-item link-dp {{ request()->is('apst*') ? 'active' : '' }}" href="{{ url('/apst') }}">
                    Akses Sarpras
                </a>
                <a class="collapse-item link-dp {{ request()->is('faskes*') ? 'active' : '' }}" href="{{ url('/faskes') }}">
                    Fasilitas Kesehatan
                </a>
                <a class="collapse-item link-dp {{ request()->is('pendidikan*') ? 'active' : '' }}" href="{{ url('/pendidikan') }}">
                    Pendidikan
                </a>
                <a class="collapse-item link-dp {{ request()->is('tenkes*') ? 'active' : '' }}" href="{{ url('/tenkes') }}">
                    Tenaga Kesehatan
                </a>
                <a class="collapse-item link-dp {{ request()->is('penghasilan*') ? 'active' : '' }}"
                    href="{{ url('/penghasilan') }}">
                    Penghasilan
                </a>
                <a class="collapse-item link-dp {{ request()->is('penyakit*') ? 'active' : '' }}" href="{{ url('/penyakit') }}">
                    Penyakit
                </a>
                <a class="collapse-item link-dp {{ request()->is('sarkes*') ? 'active' : '' }}" href="{{ url('/sarkes') }}">
                    Sarana Kesehatan
                </a>


            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ request()->is('laporan-rekap/download') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/laporan-rekap/download') }}">
            <i class="fas fa-poll"></i>
            <span>Download Laporan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/form/Form-Desa.pdf') }}" target="_blank">
            <i class="fas fa-poll"></i>
            <span>Download Form Desa</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/form/Form-RT.pdf') }}" target="_blank">
            <i class="fas fa-poll"></i>
            <span>Download Form RT</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/form/Form-Keluarga.pdf') }}" target="_blank">
            <i class="fas fa-poll"></i>
            <span>Download Form Keluarga</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/form/Form-Individu.pdf') }}" target="_blank">
            <i class="fas fa-poll"></i>
            <span>Download Form Individu</span>
        </a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->
