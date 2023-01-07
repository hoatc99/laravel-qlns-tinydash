@php
    $employee = \App\Models\Employee::find(Auth::user()->employee_id);
@endphp

<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>
    <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"
            placeholder="Tìm kiếm..." aria-label="Search">
    </form>
    <ul class="nav">
        <li class="nav-item my-3 text-muted">{{ date('d/m/Y', strtotime(\App\Models\Setting::first()->virtual_today)) }}</li>
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
                <span class="fe fe-grid fe-16"></span>
            </a>
        </li>
        <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
                <span class="fe fe-bell fe-16"></span>
                <span class="dot dot-md bg-success"></span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ asset('upload/avatars/' . $employee->avatar_url) }}" alt="..."
                        class="avatar-img rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <span class="dropdown-item" disabled>{{ $employee->fullname }}</span>
                <span class="dropdown-item"
                    disabled>Tên phòng ban</span>
                <span class="dropdown-item"
                    disabled>Tên chức vụ</span>
                <hr class="mt-1 mb-2">
                <a class="dropdown-item" href="#">Thông tin cá nhân</a>
                <a class="dropdown-item" href="{{ route('settings') }}">Cài đặt</a>
                <a class="dropdown-item" href="#">Hoạt động</a>
                <hr class="mt-1 mb-2">
                <a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng xuất</a>
            </div>
        </li>
    </ul>
</nav>
