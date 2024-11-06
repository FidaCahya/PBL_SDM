<!-- Sidebar -->
<div class="sidebar">
    <!-- Profile Section -->
    <div class="user-profile text-center mt-3 mb-3">
        <img src="{{ asset('adminlte/dist/img/profile-picture.jpg') }}" alt="Profile Picture" class="img-circle elevation-2" style="width: 50px; height: 50px;">
        <p class="user-name" style="color: #ffffff; font-weight: bold;">Nama Pengguna</p>
    </div>
    
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header" style="color: #ffffff;">Features</li>
            <li class="nav-item">
                <a href="{{ url('/kelola') }}" class="nav-link {{ ($activeMenu == 'kelola') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Kelola Kegiatan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/administrasi') }}" class="nav-link {{ ($activeMenu == 'administrasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>Administrasi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'statistik') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Statistik</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengaturan') }}" class="nav-link {{ ($activeMenu == 'pengaturan') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>Pengaturan</p>
                </a>
            </li>
            <!-- Menu Logout, diposisikan di bagian bawah -->
            <li class="nav-item logout-item mt-auto">
                <a href="{{ url('/logout') }}" class="nav-link logout-link {{ ($activeMenu == 'logout') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</div>