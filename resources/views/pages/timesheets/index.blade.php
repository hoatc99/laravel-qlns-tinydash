@extends('layouts.master')

@section('title', 'Quản lý chấm công')

@section('header', 'Quản lý chấm công')

@section('content')
    <div class="row my-4">
        <div class="col-12">
            <form action="">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Chọn tháng</label>
                        <input type="month" class="form-control" name="thang_nam" value="{{ \Request::get('thang_nam') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Chọn phòng ban</label>
                        <select class="form-control select2" name="phong_ban">
                            <option value="">Tất cả phòng ban</option>
                            @foreach (\App\Models\Department::all() as $department)
                                <option value="{{ $department->name }}"
                                    {{ \Request::get('phong_ban') == $department->name ? 'selected' : '' }}>
                                    {{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Xem bảng chấm công</button>
            </form>
        </div>
    </div>
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
                                <th>Mã NV</th>
                                <th>Tên NV</th>
                                <th>Phòng ban</th>
                                <th>Chức vụ</th>
                                <th>Ngày công</th>
                                <th>Có phép</th>
                                <th>Không phép</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheets as $key => $timesheet)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>NV{{ $timesheet->employee->id }}</td>
                                    <td>{{ $timesheet->employee->fullname }}</td>
                                    <td>{{ $timesheet->department->name }}</td>
                                    <td>{{ $timesheet->position->name }}</td>
                                    <td>{{ $timesheet->working_days }}</td>
                                    <td>{{ $timesheet->leave_days }}</td>
                                    <td>{{ $timesheet->unauthorized_leave_days }}</td>
                                    <td>{{ date('d/m/Y h:i:s', strtotime($timesheet->created_at)) }}</td>
                                    <td>
                                        <div class="badge badge-{{ $timesheet->is_closed ? 'success' : 'danger' }}">
                                            {{ $timesheet->is_closed ? 'Đã chốt' : 'Chưa chốt' }}</div>
                                    </td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if (!$timesheet->is_closed)
                                                <a class="dropdown-item"
                                                    href="{{ route('timesheets.edit', $timesheet->id) }}">Sửa bảng công</a>
                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                                    data-target="#chotbangcongModal{{ $timesheet->id }}">Chốt bảng
                                                    công</button>
                                            @endif
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#xembangcongModal{{ $timesheet->id }}">Xem bảng công</button>
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
    @foreach ($timesheets as $key => $timesheet)
        {{-- <div class="modal fade" id="chotbangcongModal{{ $timesheet->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Chốt bảng công</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bạn có thực sự muốn chốt bảng công của nhân viên <b>{{ $timesheet->employee->fullname }}
                            (NV{{ $timesheet->employee->id }})
                        </b>. Bảng công sau khi chốt sẽ không thể thay đổi nữa.
                    </div>
                    <div class="modal-footer">
                        <a href="print_single" class="btn mb-2 btn-primary">Đồng ý</a>
                        <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="xembangcongModal{{ $timesheet->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Bảng công</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label>Mã bảng công</label>
                                <h6>{{ $timesheet->id }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Trạng thái</label>
                                <h6>
                                    <div class="badge badge-{{ $timesheet->is_closed ? 'success' : 'danger' }}">
                                        {{ $timesheet->is_closed ? 'Đã chốt' : 'Chưa chốt' }}</div>
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Mã NV</label>
                                <h6>NV{{ $timesheet->employee->id }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Họ tên</label>
                                <h6>{{ $timesheet->employee->fullname }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phòng ban</label>
                                <h6>{{ $timesheet->department->name }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Chức vụ</label>
                                <h6>{{ $timesheet->position->name }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tháng năm</label>
                                <h6>{{ date('m/Y', strtotime($timesheet->year_month)) }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Ngày chấm công</label>
                                <h6>{{ date('d/m/Y', strtotime($timesheet->created_at)) }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Ngày công chuẩn</label>
                                <h6>{{ $timesheet->business_days }}
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Số ngày làm việc</label>
                                <h6>{{ $timesheet->working_days }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Số ngày nghỉ có phép</label>
                                <h6>{{ $timesheet->leave_days }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Số ngày nghỉ không phép</label>
                                <h6>{{ $timesheet->unauthorized_leave_days }}</h6>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Lý do nghỉ</label>
                                <h6>{{ $timesheet->note }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <a href="print_single" class="btn mb-2 btn-primary">In bảng công</a> --}}
                        <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
