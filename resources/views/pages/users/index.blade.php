@extends('layouts.master')

@section('title', 'Quản lý tài khoản')

@section('header', 'Quản lý tài khoản')

@section('hbuttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taotaikhoanModal">Tạo
        tài khoản</button>
@endsection

@section('content')
    <div class="row my-4">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên tài khoản</th>
                                <th>Mã NV</th>
                                <th>Tên NV</th>
                                <th>Phòng ban</th>
                                <th>Chức vụ</th>
                                <th>Ngày tạo</th>
                                <th>Quyền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>NV{{ $user->employee->id }}</td>
                                    <td>{{ $user->employee->fullname }}</td>
                                    <td>{{ @$user->assignment->department->name }}</td>
                                    <td>{{ @$user->assignment->position->name }}</td>
                                    <td>{{ date('d/m/Y h:i:s', strtotime($user->created_at)) }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                            {{ $user->is_active ? 'Đang hoạt động' : 'Đã tạm khóa' }}</div>
                                    </td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($user->is_active)
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#phanquyenModal{{ $user->id }}">Phân quyền</button>
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#khoiphucmatkhauModal{{ $user->id }}">Khôi phục mật
                                                    khẩu</button>
                                                {{-- <a class="dropdown-item" href="">Khôi phục mật khẩu</a> --}}
                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                                    data-target="#khoataikhoanModal{{ $user->id }}">Khóa tài
                                                    khoản</button>
                                            @else
                                                <button type="button" class="dropdown-item text-warning"
                                                    data-toggle="modal"
                                                    data-target="#mokhoataikhoanModal{{ $user->id }}">Mở khóa tài
                                                    khoản</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="taotaikhoanModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Tạo tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Tên tài khoản</label>
                                <input type="text" class="form-control" name="ten_tai_khoan" placeholder="Tên tài khoản"
                                    required autofocus>
                                <div class="invalid-feedback">Vui lòng nhập tên tài khoản</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Mật khẩu</label>
                                <input type="password" class="form-control" name="mat_khau" placeholder="Mật khẩu" required>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="xac_nhan_mat_khau"
                                    placeholder="Xác nhận mật khẩu" required>
                                <div class="invalid-feedback">Vui lòng xác nhận mật khẩu</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Chọn nhân viên</label>
                                <select class="form-control select2" name="ma_nhan_vien" required>
                                    @foreach (\App\Models\Employee::whereNotIn('id', \App\Models\User::pluck('employee_id'))->get() as $employee)
                                        <option value="{{ $employee->id }}">NV{{ $employee->id }} -
                                            {{ $employee->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Chọn quyền</label>
                                <select class="form-control select2" name="quyen" required>
                                    <option value="">Không có quyền</option>
                                    <option value="hr">Nhân sự</option>
                                    <option value="accounting">Kế toán</option>
                                    <option value="it">IT</option>
                                    <option value="view">Xem</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn mb-2 btn-primary">Lưu thông tin</button>
                        <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach ($users as $user)
        <div class="modal fade" id="phanquyenModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('users.set_permission', $user->id) }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Phân quyền</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Mã NV</label>
                                    <h6>NV{{ $user->employee->id }}</h6>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Họ và tên</label>
                                    <h6>{{ $user->employee->fullname }}</h6>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Phòng ban</label>
                                    <h6>{{ @$user->assignment->department->id }}</h6>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Chức vụ</label>
                                    <h6>{{ @$user->assignment->position->id }}</h6>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Chọn quyền</label>
                                    <select class="form-control select2" name="quyen" required>
                                        <option value="" {{ $user->role == '' ? 'selected' : '' }}>Không có quyền</option>
                                        <option value="hr" {{ $user->role == 'hr' ? 'selected' : '' }}>Nhân sự</option>
                                        <option value="accounting" {{ $user->role == 'accounting' ? 'selected' : '' }}>Kế toán</option>
                                        <option value="it" {{ $user->role == 'admin' ? 'selected' : '' }}>IT</option>
                                        <option value="view" {{ $user->role == 'view' ? 'selected' : '' }}>Xem</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn mb-2 btn-primary">Cập nhật</button>
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="khoataikhoanModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('users.lock', $user->id) }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Khóa tài khoản</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có thực sự muốn khóa tài khoản của nhân viên <b>{{ $user->employee->fullname }}
                                (NV{{ $user->employee->id }})
                            </b>. Nhân viên này sẽ bị mất quyền truy cập vào tài khoản.
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn mb-2 btn-danger">Tôi đồng ý</button>
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="mokhoataikhoanModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('users.unlock', $user->id) }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Mở khóa tài khoản</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có thực sự muốn mở khóa tài khoản của nhân viên <b>{{ $user->employee->fullname }}
                                (NV{{ $user->employee->id }})</b>. Nhân viên này có quyền
                            truy cập vào tài khoản.
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn mb-2 btn-warning">Tôi đồng ý</button>
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
