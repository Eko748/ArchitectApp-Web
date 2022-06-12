<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">KONSULTAN</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">KS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::segment(3) == 'dashboard' ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('konsultan.dashboard') }}"><i class="fas fa-fire"></i><span>Home</span></a></li>
            <li class="menu-header">Product</li>
            <li class=" {{ Request::segment(3) == 'project' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('konsultan.project') }}"><i class="far fa-images"></i><span>Desain Saya</span></a></li>
            {{-- <li class=" {{ Request::segment(2) == 'lelang-konsultan' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('konsultan.lelang-konsultan') }}"><i class="far fa-images"></i><span>Lelang Saya</span></a></li> --}}
            <li class="menu-header">Management</li>
            <li class=" {{ Request::segment(3) == 'lelang' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('konsultan.find') }}"><i class="far fa-images"></i><span>Lelang Owner</span></a></li>
            <li class="nav-item dropdown  {{ in_array(Request::segment(3),['active-job','archived-job']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-users"></i><span>Project</span></a> </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::segment(3) == 'active-job' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.job.active') }}">Active Project</a></li>
                    <li class="{{ Request::segment(3) == 'archived-job' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.job.archived') }}">Archived Project</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown  {{ in_array(Request::segment(3),['active','submit','archived']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-users"></i><span>Proposal</span></a> </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::segment(3) == 'active' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.proposal.active') }}">Active Proposal</a></li>
                    <li class="{{ Request::segment(3) == 'submit' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.proposal.submit') }}">Submitted Proposal</a></li>
                    <li class="{{ Request::segment(3) == 'archived' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('konsultan.proposal.archived') }}">Archived Proposal</a></li>
                </ul>
            </li>
            <li class=" {{ Request::segment(2) == 'inbox' ? 'active' : '' }}"><a class="nav-link"  href=""><i class="far fa-images"></i><span>Message</span></a></li>
            <li class="menu-header">Setting</li>
            <li class="{{ Request::segment(2) == 'profile' ? 'active' : '' }} "><a class="nav-link"
                    href="{{ route('konsultan.profile', Auth::user()->id) }}"> <i
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
