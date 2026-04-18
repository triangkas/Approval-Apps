<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            <i class="far fa-user ml-2"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <li class="user-header text-bg-primary">
                <i class="far fa-user fa-3x mt-4"></i>
                <p>
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->email }}</small>
                </p>
            </li>
            <li class="user-body">
                <div class="row">
                    <div class="col-6 text-center"><a href="{{ route('profile.edit', 'account') }}">{{ __('Profile') }}</a></div>
                    <div class="col-6 text-center ">
                        <a href="#" onclick="event.preventDefault(); $('#logout').submit();">Logout</a>
                        <form id="logout" method="POST" action="{{ route('logout') }}">@csrf</form>
                    </div>
                </div>
            </li>
        </ul>
    </li>
</ul>