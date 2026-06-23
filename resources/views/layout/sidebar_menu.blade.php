<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/images/login_user.jpeg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('data.name') }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>

            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>DASHBOARD</span></a></li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>MASTER DATA</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if (auth()->user()->hasRole('admin'))
                        <li><a href="{{ route('guru') }}"><i class="fa fa-graduation-cap"></i> DATA GURU</a></li>
                        <li><a href="{{ route('siswa') }}"><i class="fa fa-users"></i> DATA SISWA</a></li>
                        <li><a href="{{ route('mapel') }}"><i class="fa fa-book"></i> DATA MAPEL</a></li>
                        <li><a href="{{ route('kelas') }}"><i class="fa fa-home"></i> KELAS</a></li>
                    @endif
                    @if (auth()->user()->hasRole(['admin', 'guru_piket']))
                        <li><a href="{{ route('jadwal-piket') }}"><i class="fa fa-calendar"></i> JADWAL PIKET</a></li>
                    @endif
                    {{-- <li><a href="{{ route('mapel-detail') }}"><i class="fa fa-home"></i> KELAS</a></li> --}}
                </ul>
            </li>
            @if (auth()->user()->hasRole(['guru_piket', 'guru_bk', 'wali_kelas']))
                <li><a href="{{ route('rekap-piket') }}"><i class="fa fa-calendar"></i> <span>PIKET</span></a></li>
                <li><a href="{{ route('pelanggaran') }}"><i class="fa fa-ban"></i> <span>PELANGGARAN</span></a></li>
            @endif
            @if (auth()->user()->hasRole(['guru_mapel']))
                <li><a href=""><i class="fa fa-users"></i> <span>ABSEN SISWA</span></a></li>
            @endif;

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
