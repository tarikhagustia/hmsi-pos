<form class="form-inline mr-auto" action="">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">Hai, {{auth()->user()->name}}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">{{ auth()->user()->branch->name ?? 'Kamu adalah Admin' }}</div>
            <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Pengaturan
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item has-icon text-danger" onclick="$('#form-logout').submit()">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            <form id="form-logout" method="post" action="{{route('logout')}}">
                @csrf
            </form>
        </div>
    </li>
</ul>
