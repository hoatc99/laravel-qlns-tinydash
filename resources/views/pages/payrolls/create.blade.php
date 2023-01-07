@extends('layouts.master')

@section('title', 'Tính lương')

@section('header', 'Tính lương')

@section('content')
    <form action="{{ route('payrolls.store') }}" method="post" class="needs-validation" novalidate>
        @csrf
        @foreach ($timesheets as $key => $timesheet)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Bảng lương của nhân viên {{ $timesheet->employee->fullname }} (NV
                                {{ $timesheet->employee->id }})</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label>Mã NV</label>
                                            <h5>NV{{ $timesheet->employee->id }}</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Họ và tên</label>
                                            <h5>{{ $timesheet->employee->fullname }}</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Mã bảng công</label>
                                            <h5>{{ $timesheet->id }}</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Tháng năm</label>
                                            <h5>{{ date('m/Y', strtotime($timesheet->year_month)) }}</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Tên phòng ban</label>
                                            <h5>{{ $timesheet->department->name }}</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Tên chức vụ</label>
                                            <h5>{{ $timesheet->position->name }}</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Lương cơ bản</label>
                                            <h5>{{ number_format($timesheet->basic_pay_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Ngày công trong tháng</label>
                                            <h5>{{ $timesheet->business_days_in_month }} ngày</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>KPI</label>
                                            <h5>{{ $timesheet->kpi }}</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Thưởng KPI</label>
                                            <h5>{{ number_format($timesheet->kpi_bonus_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Ngày công chuẩn</label>
                                            <h5>{{ $timesheet->business_days }} ngày</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Nghỉ có phép</label>
                                            <h5 class="text-danger">{{ $timesheet->leave_days }} ngày</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Nghỉ không phép</label>
                                            <h5 class="text-danger">{{ $timesheet->unauthorized_leave_days }} ngày</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Số ngày làm việc</label>
                                            <h5>{{ $timesheet->working_days }} ngày</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Lương công chuẩn</label>
                                            <h5>{{ number_format($timesheet->business_days_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Trừ lương nghỉ có phép</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->leave_days_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Trừ lương nghỉ không phép</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->unauthorized_leave_days_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Lương ngày công</label>
                                            <h5>{{ number_format($timesheet->working_days_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Thâm niên</label>
                                            <h5>{{ $timesheet->seniority_years }} năm</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Phụ cấp thâm niên</label>
                                            <h5>{{ number_format($timesheet->seniority_allowance_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Phụ cấp chức vụ</label>
                                            <h5>{{ number_format($timesheet->position_allowance_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Phụ cấp gửi xe</label>
                                            <h5>{{ number_format($timesheet->parking_allowance_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Phụ cấp trực siêu thị</label>
                                            <h5>{{ number_format($timesheet->sleep_at_shop_allowance_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label>Tổng phụ cấp</label>
                                            <h5>{{ number_format($timesheet->sum_of_allowances_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Đóng BHXH</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->social_insurance_pay_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Đóng BHYT</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->health_insurance_pay_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Đóng BHTN</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->unemployment_insurance_pay_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Tổng tiền đóng bảo hiểm</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->sum_of_insurances_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Tổng thưởng phạt</label>
                                            <h5>{{ number_format($timesheet->payoff_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Tổng lương</label>
                                            <h5>{{ number_format($timesheet->sum_of_payrolls_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Tổng tạm ứng</label>
                                            <h5 class="text-danger">{{ number_format($timesheet->advance_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Thực lãnh</label>
                                            <h5>{{ number_format($timesheet->take_home_pay_amount) }} đ</h5>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Ghi chú</label>
                                            <textarea class="form-control" name="ghi_chu[]" rows="4"></textarea>
                                        </div>
                                        <input type="hidden" name="thang_nam[]" value="{{ $timesheet->year_month }}">
                                        <input type="hidden" name="luong_co_ban[]" value="{{ $timesheet->basic_pay_amount }}">
                                        <input type="hidden" name="luong_ngay_cong_chuan[]" value="{{ $timesheet->business_days_amount }}">
                                        <input type="hidden" name="tru_luong_nghi_co_phep[]" value="{{ $timesheet->leave_days_amount }}">
                                        <input type="hidden" name="tru_luong_nghi_khong_phep[]" value="{{ $timesheet->unauthorized_leave_days_amount }}">
                                        <input type="hidden" name="luong_ngay_cong[]" value="{{ $timesheet->working_days_amount }}">
                                        <input type="hidden" name="kpi[]" value="{{ $timesheet->kpi }}">
                                        <input type="hidden" name="thuong_kpi[]" value="{{ $timesheet->kpi_bonus_amount }}">
                                        <input type="hidden" name="phu_cap_chuc_vu[]" value="{{ $timesheet->position_allowance_amount }}">
                                        <input type="hidden" name="phu_cap_gui_xe[]" value="{{ $timesheet->parking_allowance_amount }}">
                                        <input type="hidden" name="phu_cap_truc_sieu_thi[]" value="{{ $timesheet->sleep_at_shop_allowance_amount }}">
                                        <input type="hidden" name="phu_cap_tham_nien[]" value="{{ $timesheet->seniority_allowance_amount }}">
                                        <input type="hidden" name="tong_phu_cap[]" value="{{ $timesheet->sum_of_allowances_amount }}">
                                        <input type="hidden" name="dong_bhxh[]" value="{{ $timesheet->social_insurance_pay_amount }}">
                                        <input type="hidden" name="dong_bhyt[]" value="{{ $timesheet->health_insurance_pay_amount }}">
                                        <input type="hidden" name="dong_bhtn[]" value="{{ $timesheet->unemployment_insurance_pay_amount }}">
                                        <input type="hidden" name="tong_dong_bao_hiem[]" value="{{ $timesheet->sum_of_insurances_amount }}">
                                        <input type="hidden" name="tong_thuong_phat[]" value="{{ $timesheet->payoff_amount }}">
                                        <input type="hidden" name="tong_luong[]" value="{{ $timesheet->sum_of_payrolls_amount }}">
                                        <input type="hidden" name="tong_tam_ung[]" value="{{ $timesheet->advance_amount }}">
                                        <input type="hidden" name="thuc_lanh[]" value="{{ $timesheet->take_home_pay_amount }}">
                                        <input type="hidden" name="ma_nhan_vien[]" value="{{ $timesheet->employee->id }}">
                                        <input type="hidden" name="ma_phong_ban[]" value="{{ $timesheet->department->id }}">
                                        <input type="hidden" name="ma_chuc_vu[]" value="{{ $timesheet->position->id }}">
                                        <input type="hidden" name="ma_bang_cong[]" value="{{ $timesheet->id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="text-right">
            <a href="{{ route('payrolls.calculate') }}" class="btn btn-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
@endsection

@section('modals')

@endsection

@section('scripts')

@endsection
