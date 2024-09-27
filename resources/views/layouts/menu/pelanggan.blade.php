<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/status_kendaraan') }}" class="nav-link {{ request()->is('pelanggan/status_kendaraan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck-moving"></i>
        <p>Monitoring Kendaraan</p>
    </a>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/profile') }}" class="nav-link {{ request()->is('pelanggan/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
