@extends('layouts.master')

@section('title', 'Cài đặt hệ thống')

@section('header', 'Cài đặt hệ thống')

@section('content')
    <div class="my-4">
        <form action="{{ route('save_settings') }}" method="post">
            @csrf
            <h5>Lương và Phụ cấp</h5>
            <div class="list-group mb-2 shadow">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Lương cơ bản</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input-money text-right" name="khoi_tao_luong_co_ban"
                                value="{{ @$setting->init_basic_pay_amount }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">đồng</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Phụ cấp Gửi xe</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input-money text-right" name="phu_cap_gui_xe"
                                value="{{ @$setting->parking_allowance_amount }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">đồng</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Phụ cấp Trực siêu thị</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input-money text-right" name="phu_cap_truc_sieu_thi"
                                value="{{ @$setting->sleep_at_shop_allowance_amount }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">đồng</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Phụ cấp Thâm niên (% trên LCB)</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="phu_cap_tham_nien"
                                value="{{ @$setting->seniority_allowance_percent }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .list-group -->
            <h5>Chấm công và tính lương (đầu tháng)</h5>
            <div class="list-group mb-2 shadow">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Số ngày dành cho chấm công</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="so_ngay_cham_cong"
                                value="{{ @$setting->days_for_timekeeping }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">ngày</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Số ngày dành cho tính lương</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-right" name="so_ngay_tinh_luong"
                                value="{{ @$setting->days_for_payroll_calculate }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">ngày</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Mở chấm công quá hạn</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="mo_cham_cong_qua_han" value="0" class="selectgroup-input"
                                    {{ !@$setting->is_overdue_timesheet_timekeeping_open ? 'checked' : '' }}>
                                <span class="selectgroup-button">Đóng</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="mo_cham_cong_qua_han" value="1" class="selectgroup-input"
                                    {{ @$setting->is_overdue_timesheet_timekeeping_open ? 'checked' : '' }}>
                                <span class="selectgroup-button">Mở</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Chấm công tạm thời</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="mo_tinh_luong_qua_han" value="0" class="selectgroup-input"
                                    {{ !@$setting->is_overdue_payroll_calculate_open ? 'checked' : '' }}>
                                <span class="selectgroup-button">Đóng</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="mo_tinh_luong_qua_han" value="1" class="selectgroup-input"
                                    {{ @$setting->is_overdue_payroll_calculate_open ? 'checked' : '' }}>
                                <span class="selectgroup-button">Mở</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div> <!-- .list-group -->
            <h5>Thiết lập hệ thống công ty</h5>
            <div class="list-group mb-2 shadow">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Giả lập ngày hôm nay</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control drgpicker" name="gia_lap_ngay_hom_nay"
                                value="{{ date('d/m/Y', strtotime($setting->virtual_today)) }}" aria-describedby="button-addon2">
                        </div>
                    </div>
                </div>
            </div> <!-- .list-group -->
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div> <!-- /.card-body -->
@endsection

@section('modals')

@endsection
