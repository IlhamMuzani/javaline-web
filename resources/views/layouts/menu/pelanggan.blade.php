<li class="nav-header">
    Dashboard</li>
<li class="nav-item">
    <a href="{{ url('pelanggan') }}" class="nav-link {{ request()->is('pelanggan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/monitoring-kendaraan') }}"
        class="nav-link {{ request()->is('pelanggan/monitoring-kendaraan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck-moving"></i>
        <p>Monitoring Kendaraan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/monitoring-suratjalan') }}"
        class="nav-link {{ request()->is('pelanggan/monitoring-suratjalan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Monitoring Surat Jalan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/history-suratjalan') }}"
        class="nav-link {{ request()->is('pelanggan/history-suratjalan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>History Surat Jalan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/faktur-ekspedisi') }}"
        class="nav-link {{ request()->is('pelanggan/faktur-ekspedisi') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Faktur Ekspedisi</p>
    </a>
</li>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/profile') }}"
        class="nav-link {{ request()->is('pelanggan/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
