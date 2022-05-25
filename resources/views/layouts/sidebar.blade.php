<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">ADMIN</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">ADM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
                    <li class="menu-header">Management</li>
                    <li class="{{ Request::segment(1) == 'tender' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('admin.tender') }}"><i class="fas fa-clipboard-list"></i><span>Data Tender Win</span></a></li>
                    <li class="{{ Request::segment(1) == 'verify' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('admin.verify') }}"><i class="fas fa-clipboard-list"></i><span>Verifikasi Pembayaran</span></a></li>
            <li class="nav-item dropdown  {{ in_array(Request::segment(1),['konsultan','owner','kontraktor']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i><span>User</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::segment(1) == 'konsultan' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.page') }}">Konsultan</a></li>
                    <li class="{{ Request::segment(1) == 'kontraktor' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.page') }}">Kontraktor</a></li>
                    <li class="{{ Request::segment(1) == 'owner' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('owner.page') }}">Owner</a></li>
                </ul>
            </li>
            <li class="menu-header">Setting</li>
            <li class="{{ Request::segment(1) == 'my' ? 'active' : '' }} "><a class="nav-link"
                    href="{{ route('profile', Auth::user()->id) }}"> <i
                        class="fas fa-user"></i><span>Profile</span></a>
            </li>
            <li><a class="nav-link sidebar-brand sidebar-brand-sm mt-4 logout"><i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <button class="btn btn-danger btn-lg btn-block btn-icon-split logout">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </aside>
</div>

<form method="POST" action="{{ route('logout') }}" id="formLogout">
    @csrf
</form>
