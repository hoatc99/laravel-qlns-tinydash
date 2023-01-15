@extends('layouts.master')

@section('title', 'Quản lý bảng lương')

@section('header', 'Quản lý bảng lương')

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
                        <select class="form-control select2" name="phong_ban" required>
                            <option value="Tất cả phòng ban">Tất cả phòng ban</option>
                            @foreach (\App\Models\Department::all() as $department)
                                <option value="{{ $department->name }}"
                                    {{ \Request::get('phong_ban') == $department->name ? 'selected' : '' }}>
                                    {{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Xem bảng lương</button>
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
                                <th>Tổng lương</th>
                                <th>Tổng trừ</th>
                                <th>Thực lãnh</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $key => $payroll)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>NV{{ $payroll->employee->id }}</td>
                                    <td>{{ $payroll->employee->fullname }}</td>
                                    <td>{{ $payroll->department->name }}</td>
                                    <td>{{ $payroll->position->name }}</td>
                                    <td>{{ number_format($payroll->sum_of_payrolls_amount) }}</td>
                                    <td>{{ number_format($payroll->advance_amount) }}</td>
                                    <td>{{ number_format($payroll->take_home_pay_amount) }}</td>
                                    <td>{{ date('d/m/Y h:i:s', strtotime($payroll->created_at)) }}</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($payroll->is_closed)
                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                                    data-target="#chotbangluongModal{{ $payroll->id }}">Chốt bảng
                                                    lương</button>
                                            @endif
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#xembangluongModal{{ $payroll->id }}">Xem bảng lương</button>
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
    @foreach ($payrolls as $key => $payroll)
        <div class="modal fade" id="xembangluongModal{{ $payroll->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Bảng lương</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label>Mã NV</label>
                                <h5>NV{{ $payroll->employee->id }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Họ và tên</label>
                                <h5>{{ $payroll->employee->fullname }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Mã bảng lương</label>
                                <h5>{{ $payroll->id }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Tháng năm</label>
                                <h5>{{ date('m/Y', strtotime($payroll->year_month)) }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Ngày tính lương</label>
                                <h5>{{ date('d/m/Y H:i:s', strtotime($payroll->created_at)) }}</h5>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label>Tên phòng ban</label>
                                <h5>{{ $payroll->department->name }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Tên chức vụ</label>
                                <h5>{{ $payroll->position->name }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Lương cơ bản</label>
                                <h5>{{ number_format($payroll->basic_pay_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Ngày công trong tháng</label>
                                <h5>{{ $payroll->timesheet->business_days_in_month }} ngày</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>KPI</label>
                                <h5>{{ $payroll->kpi }}</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Thưởng KPI</label>
                                <h5>{{ number_format($payroll->kpi_bonus_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Ngày công chuẩn</label>
                                <h5>{{ $payroll->timesheet->business_days }} ngày</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Nghỉ có phép</label>
                                <h5 class="text-danger">{{ $payroll->timesheet->leave_days }} ngày</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Nghỉ không phép</label>
                                <h5 class="text-danger">{{ $payroll->timesheet->unauthorized_leave_days }} ngày</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Số ngày làm việc</label>
                                <h5>{{ $payroll->timesheet->working_days }} ngày</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Lương công chuẩn</label>
                                <h5>{{ number_format($payroll->business_days_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Trừ lương nghỉ có phép</label>
                                <h5 class="text-danger">{{ number_format($payroll->leave_days_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Trừ lương nghỉ không phép</label>
                                <h5 class="text-danger">{{ number_format($payroll->unauthorized_leave_days_amount) }} đ
                                </h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Lương ngày công</label>
                                <h5>{{ number_format($payroll->working_days_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Thâm niên</label>
                                <h5>{{ $payroll->employee->seniority_years }} năm</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Phụ cấp thâm niên</label>
                                <h5>{{ number_format($payroll->seniority_allowance_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Phụ cấp chức vụ</label>
                                <h5>{{ number_format($payroll->position_allowance_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Phụ cấp gửi xe</label>
                                <h5>{{ number_format($payroll->parking_allowance_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Phụ cấp trực siêu thị</label>
                                <h5>{{ number_format($payroll->sleep_at_shop_allowance_amount) }} đ</h5>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Tổng phụ cấp</label>
                                <h5>{{ number_format($payroll->sum_of_allowances_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Đóng BHXH</label>
                                <h5 class="text-danger">{{ number_format($payroll->social_insurance_pay_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Đóng BHYT</label>
                                <h5 class="text-danger">{{ number_format($payroll->health_insurance_pay_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Đóng BHTN</label>
                                <h5 class="text-danger">{{ number_format($payroll->unemployment_insurance_pay_amount) }}
                                    đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tổng tiền đóng bảo hiểm</label>
                                <h5 class="text-danger">{{ number_format($payroll->sum_of_insurances_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tổng thưởng phạt</label>
                                <h5>{{ number_format($payroll->payoff_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tổng lương</label>
                                <h5>{{ number_format($payroll->sum_of_payrolls_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tổng tạm ứng</label>
                                <h5 class="text-danger">{{ number_format($payroll->advance_amount) }} đ</h5>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Thực lãnh</label>
                                <h5>{{ number_format($payroll->take_home_pay_amount) }} đ</h5>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Ghi chú</label>
                                <p>{{ $payroll->note }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <a href="print_single" class="btn mb-2 btn-primary">In bảng lương</a> --}}
                        <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
