<li class="nav-header">
    Dashboard</li>
<li class="nav-item">
    <a href="{{ url('driver') }}" class="nav-link {{ request()->is('driver') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Search</li>

<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>
<li class="nav-header">Menu</li>
<li class="nav-item {{ request()->is('driver/km*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('driver/km*') ? 'active' : '' }}">

        <i class="nav-icon fas fa-users-cog"></i>
        <p>
            <strong style="color: rgb(255, 255, 255);"> OPERASIONAL</strong>
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('driver/km') }}" class="nav-link {{ request()->is('driver/km*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                <p style="font-size: 14px;">Update KM</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('driver/profile') }}" class="nav-link {{ request()->is('driver/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
