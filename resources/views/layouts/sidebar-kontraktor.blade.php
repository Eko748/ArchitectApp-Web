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
            <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('kontraktor.dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Management</li>
            <li class=" {{ Request::segment(2) == 'lelang' ? 'active' : '' }}"><a class="nav-link"  href="{{ route('kontraktor.job') }}"><i class="far fa-images"></i><span>Find Work</span></a></li>
            <li class="nav-item dropdown  {{ in_array(Request::segment(3),['active-job','archived-job']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-users"></i><span>My Jobs</span></a> </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::segment(3) == 'active-job' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.job.active') }}">Active Jobs</a></li>
                    <li class="{{ Request::segment(3) == 'archived-job' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.job.archived') }}">Archived Jobs</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown  {{ in_array(Request::segment(3),['active','submit','archived']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-users"></i><span>My Proposal</span></a> </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::segment(3) == 'active' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.proposal.active') }}">Active Proposal</a></li>
                    <li class="{{ Request::segment(3) == 'submit' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.proposal.submit') }}">Submitted Proposal</a></li>
                    <li class="{{ Request::segment(3) == 'archived' ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('kontraktor.proposal.archived') }}">Archived Proposal</a></li>
                </ul>
            </li>
            <li class=" {{ Request::segment(2) == 'inbox' ? 'active' : '' }}"><a class="nav-link"  href=""><i class="far fa-images"></i><span>Message</span></a></li>
            <li class="menu-header">Setting</li>
            <li class="{{ Request::segment(2) == 'profile' ? 'active' : '' }} "><a class="nav-link"
                    href="{{ route('kontraktor.profile', Auth::user()->id) }}"> <i
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
