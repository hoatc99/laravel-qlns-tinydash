@extends('layouts.master')

@section('title', 'Quản lý hồ sơ')

@php $state = ! isset($employee) @endphp

@section('header', $state ? 'Tạo hồ sơ mới' : 'Chỉnh sửa hồ sơ')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ $state ? route('employees.store') : route('employees.update', $employee->id) }}" method="post"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method($state ? 'post' : 'put')
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">Thông tin chung</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <img src="{{ asset('upload/avatars/' . ($state ? 'face.png' : $employee->avatar_url)) }}"
                                        alt="" class="w-100 curved" id="img_anh_dai_dien">
                                    <div class="mt-3 text-center">
                                        <input type="file" class="form-control-file" accept="image/*" name="anh_dai_dien"
                                            id="input_anh_dai_dien" required>
                                        <button type="button" class="btn btn-sm btn-warning" id="btn_anh_dai_dien">Chọn
                                            ảnh</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>Mã NV</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend">NV</span>
                                            </div>
                                            <input type="text" class="form-control" name="ma_nhan_vien"
                                                value="{{ $state ? null : @$employee->id }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Họ và tên</label>
                                        <input type="text" class="form-control" name="ho_va_ten"
                                            value="{{ @$employee->fullname }}" placeholder="Họ và tên" required>
                                        <div class="invalid-feedback">Vui lòng nhập tên</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Giới tính</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gioi_tinh" value="1"
                                                    class="selectgroup-input"
                                                    {{ $state || @$employee->gender ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Nam</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gioi_tinh" value="0"
                                                    class="selectgroup-input" {{ $state || @$employee->gender ? '' : 'checked' }}>
                                                <span class="selectgroup-button">Nữ</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Ngày sinh</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text" id="button-addon-date"><span
                                                        class="fe fe-calendar fe-16"></span></div>
                                            </div>
                                            <input type="text" class="form-control drgpicker" name="ngay_sinh"
                                                value="{{ date('d/m/Y', strtotime(@$employee->date_of_birth)) }}" aria-describedby="button-addon2"
                                                required>
                                            <div class="invalid-feedback">Vui lòng nhập ngày sinh</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Số điện thoại</label>
                                        <input type="text" class="form-control input-phoneus" name="so_dien_thoai"
                                            value="{{ @$employee->phone_number }}" placeholder="Số điện thoại"
                                            maxlength="14" required>
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ @$employee->email }}" placeholder="Email"
                                            aria-describedby="emailHelp1" required>
                                        <div class="invalid-feedback">Vui lòng nhập email</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Số CCCD</label>
                                        <input type="text" class="form-control input-id-number" name="so_cccd"
                                            value="{{ @$employee->identification_number }}" placeholder="Số CCCD"
                                            maxlength="15" required>
                                        <div class="invalid-feedback">Vui lòng nhập số CCCD</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Ngày cấp</label>
                                        <input type="text" class="form-control drgpicker" name="ngay_cap"
                                            value="{{ date('d/m/Y', strtotime(@$employee->date_of_issue)) }}" aria-describedby="button-addon2"
                                            required>
                                        <div class="invalid-feedback">Vui lòng nhập ngày cấp CCCD</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Nơi cấp</label>
                                        <input type="text" class="form-control" name="noi_cap"
                                            value="{{ @$employee->place_of_issue }}" placeholder="Nơi cấp" required>
                                        <div class="invalid-feedback">Vui lòng nhập nơi cấp CCCD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Địa chỉ Thường trú</label>
                                    <input type="text" class="form-control" name="dia_chi"
                                        value="{{ @$employee->place_of_permanent }}"
                                        placeholder="Số nhà, tên đường" required>
                                    <div class="invalid-feedback">Vui lòng nhập địa chỉ thường trú</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">Thông tin công việc</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>Ngày nhận việc</label>
                                <div class="input-group">
                                    <input type="text" class="form-control drgpicker" name="ngay_nhan_viec"
                                        value="{{ date('d/m/Y', strtotime(today())) }}" aria-describedby="button-addon2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">Thông tin khác</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label>Tình trạng hôn nhân</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="tinh_trang_hon_nhan" value="0"
                                            class="selectgroup-input"
                                            {{ $state || @!$employee->is_marital ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Độc thân</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="tinh_trang_hon_nhan" value="1"
                                            class="selectgroup-input" {{ $state || @!$employee->is_marital ? '' : 'checked' }}>
                                        <span class="selectgroup-button">Đã kết hôn</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Trình độ học vấn</label>
                                <input type="text" class="form-control" name="trinh_do_hoc_van"
                                    value="{{ @$employee->academic_level }}" placeholder="Trình độ học vấn" required>
                                <div class="invalid-feedback">Vui lòng nhập trình độ học vấn</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Trình độ chuyên môn</label>
                                <input type="text" class="form-control" name="trinh_do_chuyen_mon"
                                    value="{{ @$employee->qualification }}" placeholder="Trình độ chuyên môn" required>
                                <div class="invalid-feedback">Vui lòng nhập trình độ chuyên môn</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Mã BHXH</label>
                                <input type="text" class="form-control" name="ma_bhxh"
                                    value="{{ @$employee->social_insurance_number }}" placeholder="Mã Bảo hiểm Xã hội"
                                    required>
                                <div class="invalid-feedback">Vui lòng nhập mã bảo hiểm xã hội</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tên ngân hàng</label>
                                <input type="text" class="form-control" name="ten_ngan_hang" value=""
                                    placeholder="Tên ngân hàng">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Số tài khoản ngân hàng</label>
                                <input type="text" class="form-control" name="so_tai_khoan_ngan_hang" value=""
                                    placeholder="Số tài khoản ngân hàng">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tên người thụ hưởng</label>
                                <input type="text" class="form-control" name="ten_nguoi_thu_huong" value=""
                                    placeholder="Tên người thụ hưởng">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Chi nhánh</label>
                                <input type="text" class="form-control" name="chi_nhanh" value=""
                                    placeholder="Chi nhánh">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Thông tin thêm</label>
                                <textarea class="form-control" name="thong_tin_them" rows="4">{{ @$employee->additional_infomation }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $().ready(() => {
            var input = $('#input_anh_dai_dien');
            $('#btn_anh_dai_dien').click((e) => {
                e.preventDefault();
                input.click();
            });

            input.on('change', () => {
                var reader = new FileReader();
                reader.onload = (e) => {
                    $('#img_anh_dai_dien').attr('src', e.target.result);
                }
                reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>
@endsection
