@php $role = Auth::user()->role @endphp

<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">HoaBinhGroup</a>
        </div>
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand navbar-brand-sm mt-2 mx-auto flex-fill text-center"
                href="{{ route('home') }}">HBG</a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Trang chủ</span>
                </a>
            </li>
        </ul>
        @if ($role == 'admin' || $role == 'hr' || $role == 'accounting')
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Nhân sự</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                @if ($role == 'admin' || $role == 'hr')
                    <li class="nav-item w-100">
                        <a href="{{ route('employees.index') }}" class="nav-link">
                            <i class="fe fe-info fe-16"></i>
                            <span class="ml-3 item-text">Quản lý Hồ sơ</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#ql-chamcong" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle nav-link">
                            <i class="fe fe-clock fe-16"></i>
                            <span class="ml-3 item-text">Quản lý Chấm công</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="ql-chamcong">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('timesheets.index') }}">
                                    <span class="ml-1 item-text">Danh sách bảng công</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('timesheets.show_timesheets_to_close') }}">
                                    <span class="ml-1 item-text">Chốt bảng công</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('timesheets.timekeeping') }}">
                                    <span class="ml-1 item-text">Chấm công</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#ql-hopdong" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle nav-link">
                            <i class="fe fe-archive fe-16"></i>
                            <span class="ml-3 item-text">Quản lý Hợp đồng LĐ</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="ql-hopdong">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('labor-contracts.index') }}">
                                    <span class="ml-1 item-text">Danh sách hợp đồng</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'admin' || $role == 'accounting')
                    <li class="nav-item dropdown">
                        <a href="#ql-luongthuong" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle nav-link">
                            <i class="fe fe-dollar-sign fe-16"></i>
                            <span class="ml-3 item-text">Quản lý Lương thưởng</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="ql-luongthuong">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('payrolls.index') }}">
                                    <span class="ml-1 item-text">Danh sách bảng lương</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('payrolls.calculate') }}">
                                    <span class="ml-1 item-text">Tính lương</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#ql-phucloi" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle nav-link">
                            <i class="fe fe-shield fe-16"></i>
                            <span class="ml-3 item-text">Quản lý Phúc lợi</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="ql-phucloi">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('insurance-pays.index') }}">
                                    <span class="ml-1 item-text">Đóng Bảo hiểm</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('payoffs.index') }}">
                                    <span class="ml-1 item-text">Thưởng Phạt</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{ route('advances.index') }}">
                                    <span class="ml-1 item-text">Tạm ứng</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        @endif

        @if ($role == 'admin' || $role == 'it')
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Quản trị</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="fe fe-user-check fe-16"></i>
                        <span class="ml-3 item-text">Quản lý Tài khoản</span>
                    </a>
                </li>
            </ul>
        @endif

        @if ($role == 'admin' || $role == 'hr')
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Hệ thống</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a href="{{ route('departments.index') }}" class="nav-link">
                        <i class="fe fe-map fe-16"></i>
                        <span class="ml-3 item-text">Quản lý Phòng ban</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a href="{{ route('positions.index') }}" class="nav-link">
                        <i class="fe fe-map-pin fe-16"></i>
                        <span class="ml-3 item-text">Quản lý Chức vụ</span>
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</aside>
