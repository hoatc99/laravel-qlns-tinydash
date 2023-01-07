@extends('layouts.master')

@section('title', 'Quản lý hồ sơ')

@section('header', 'Chi tiết hồ sơ nhân viên')

@section('hbuttons')
    <a href="" class="btn btn-primary">In hồ sơ</a>
@endsection

@section('content')
    <div class="row my-4">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="thongtinchung-tab" data-toggle="tab" href="#thongtinchung"
                                role="tab" aria-controls="thongtinchung" aria-selected="true">Thông tin chung</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="thongtincongviec-tab" data-toggle="tab" href="#thongtincongviec"
                                role="tab" aria-controls="thongtincongviec" aria-selected="false">Thông tin công
                                việc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hopdonglaodong-tab" data-toggle="tab" href="#hopdonglaodong"
                                role="tab" aria-controls="hopdonglaodong" aria-selected="false">Hợp đồng lao động</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="quatrinhlamviec-tab" data-toggle="tab" href="#quatrinhlamviec"
                                role="tab" aria-controls="quatrinhlamviec" aria-selected="false">Quá trình làm việc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="quatrinhnangluong-tab" data-toggle="tab" href="#quatrinhnangluong"
                                role="tab" aria-controls="quatrinhnangluong" aria-selected="false">Quá trình nâng
                                lương</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="phucloibaohiem-tab" data-toggle="tab" href="#phucloibaohiem"
                                role="tab" aria-controls="phucloibaohiem" aria-selected="false">Phúc lợi & Bảo hiểm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="thongtinkhac-tab" data-toggle="tab" href="#thongtinkhac" role="tab"
                                aria-controls="thongtinkhac" aria-selected="false">Thông tin khác</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="thongtinchung" role="tabpanel"
                            aria-labelledby="thongtinchung-tab">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Ảnh đại diện</label>
                                        <img src="{{ asset('upload/avatars/' . $employee->avatar_url) }}" alt=""
                                            class="w-100 curved" name="anh_dai_dien">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label>Mã NV</label>
                                            <h5>NV{{ $employee->id }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Họ và tên</label>
                                            <h5>{{ $employee->fullname }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Giới tính</label>
                                            <h5>{{ $employee->gender ? 'Nam' : 'Nữ' }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Ngày sinh</label>
                                            <h5>{{ date('d/m/Y', strtotime($employee->date_of_birth)) }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Số điện thoại</label>
                                            <h5>{{ $employee->phone_number }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Email</label>
                                            <h5>{{ $employee->email }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Số CCCD</label>
                                            <h5>{{ $employee->identification_number }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Ngày cấp</label>
                                            <h5>{{ date('d/m/Y', strtotime($employee->date_of_issue)) }}</h5>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Nơi cấp</label>
                                            <h5>{{ $employee->place_of_issue }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>Địa chỉ Thường trú</label>
                                        <h5>{{ $employee->place_of_permanent }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="thongtincongviec" role="tabpanel"
                            aria-labelledby="thongtincongviec-tab">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Tình trạng</label>
                                        <div
                                            class="color bg-{{ $employee->is_working ? 'success' : 'danger' }} text-white">
                                            <h5>{{ $employee->is_working ? 'Đang làm việc' : 'Đã thôi việc' }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày nhận việc</label>
                                        <h5>{{ date('d/m/Y', strtotime($employee->date_of_employment)) }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Thâm niên</label>
                                        <h5>{{ $employee->seniority_years }} năm</h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Phòng ban hiện tại</label>
                                        <h5>{{ @$employee->assignment->department->name }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Chức vụ hiện tại</label>
                                        <h5>{{ @$employee->assignment->position->name }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <h5>{{ @date('d/m/Y', strtotime($employee->assignment->start_date)) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày kết thúc dự kiến</label>
                                        <h5>{{ @date('d/m/Y', strtotime($employee->assignment->expected_end_date)) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày kết thúc thực tế</label>
                                        <h5>{{ @date('d/m/Y', strtotime($employee->assignment->actual_end_date)) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Lương cơ bản</label>
                                        <h5>{{ @$employee->assignment->basic_pay_amount }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày thôi việc</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Quyết định thôi việc</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Lý do thôi việc</label>
                                        <h5></h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-center">Danh sách phân công công việc</h5>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Phòng ban</th>
                                                <th>Chức vụ</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày kết thúc dự kiến</th>
                                                <th>Ngày kết thúc thực tế</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee->assignments as $key => $assignment)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $assignment->position->department->name }}</td>
                                                    <td>{{ $assignment->position->name }}</td>
                                                    <td>{{ $assignment->start_date }}</td>
                                                    <td>{{ $assignment->expected_end_date }}</td>
                                                    <td>{{ $assignment->actual_end_date }}</td>
                                                    <td><span
                                                            class="text-{{ $assignment->is_ended ? 'success' : 'danger' }}">{{ $assignment->is_ended ? 'Chưa kết thúc' : 'Đã kết thúc' }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="hopdonglaodong" role="tabpanel"
                            aria-labelledby="hopdonglaodong-tab">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Loại hợp đồng</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Thời hạn</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Ngày ký</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Ngày kết thúc</label>
                                        <h5></h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <h5 class="text-center">Danh sách hợp đồng đã ký</h5>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Loại hợp đồng</th>
                                                <th>Thời hạn</th>
                                                <th>Ngày ký</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày kết thúc dự kiến</th>
                                                <th>Ngày kết thúc thực tế</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee->labor_contracts as $key => $labor_contract)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $labor_contract->type }}</td>
                                                    <td>{{ $labor_contract->period }}</td>
                                                    <td>{{ $labor_contract->signed_date }}</td>
                                                    <td>{{ $labor_contract->start_date }}</td>
                                                    <td>{{ $labor_contract->expected_end_date }}</td>
                                                    <td>{{ $labor_contract->actual_end_date }}</td>
                                                    <td><span class="text-{{ $labor_contract->is_ended ? 'success' : 'danger' }}">{{ $labor_contract->is_ended ? 'Chưa kết thúc' : 'Đã kết thúc' }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="quatrinhlamviec" role="tabpanel"
                            aria-labelledby="quatrinhlamviec-tab">
                            <div class="accordion w-100" id="accordion1">
                                <div class="card timeline shadow">
                                    <div class="card-header" id="heading1">
                                        <a role="button" href="#collapse1" data-toggle="collapse"
                                            data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                            <strong>Thay đổi phòng ban 8 lần</strong>
                                        </a>
                                    </div>
                                    <div id="collapse1" class="collapse show" aria-labelledby="heading1"
                                        data-parent="#accordion1">
                                        <div class="card-body">
                                            <div class="pb-3 timeline-item item-primary">
                                                <div class="pl-5">
                                                    <div class="mb-1"><strong>@Brown Asher</strong><span
                                                            class="text-muted small mx-2">Just create new layout Index,
                                                            form, table</span><strong>Tiny Admin</strong></div>
                                                    <p class="small text-muted">Creative Design <span
                                                            class="badge badge-light">1h ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb-3 timeline-item item-warning">
                                                <div class="pl-5">
                                                    <div class="mb-3"><strong>@Fletcher Everett</strong><span
                                                            class="text-muted small mx-2">created new group
                                                            for</span><strong>Tiny Admin</strong></div>
                                                    <ul class="avatars-list mb-2">
                                                        <li>
                                                            <a href="#" class="avatar avatar-sm">
                                                                <img alt="..." class="avatar-img rounded-circle"
                                                                    src="{{ asset('upload/avatars/face.png') }}">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="avatar avatar-sm">
                                                                <img alt="..." class="avatar-img rounded-circle"
                                                                    src="{{ asset('upload/avatars/face.png') }}">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="avatar avatar-sm">
                                                                <img alt="..." class="avatar-img rounded-circle"
                                                                    src="{{ asset('upload/avatars/face.png') }}">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <p class="small text-muted">Front-End Development <span
                                                            class="badge badge-light">1h ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pb-3 timeline-item item-success">
                                                <div class="pl-5">
                                                    <div class="mb-2"><strong>@Kelley Sonya</strong><span
                                                            class="text-muted small mx-2">has commented
                                                            on</span><strong>Advanced table</strong></div>
                                                    <div class="card d-inline-flex mb-2">
                                                        <div class="card-body bg-light py-2 px-3"> Lorem ipsum dolor sit
                                                            amet, consectetur adipiscing elit. </div>
                                                    </div>
                                                    <p class="small text-muted">Back-End Development <span
                                                            class="badge badge-light">1h ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow">
                                    <div class="card-header" id="heading1">
                                        <a role="button" href="#collapse2" data-toggle="collapse"
                                            data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            <strong>Collapse two</strong>
                                        </a>
                                    </div>
                                    <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                        data-parent="#accordion1">
                                        <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3
                                            wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. </div>
                                    </div>
                                </div>
                                <div class="card shadow">
                                    <div class="card-header" id="heading1">
                                        <a role="button" href="#collapse3" data-toggle="collapse"
                                            data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            <strong>Collapse three</strong>
                                        </a>
                                    </div>
                                    <div id="collapse3" class="collapse" aria-labelledby="heading3"
                                        data-parent="#accordion1">
                                        <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3
                                            wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="quatrinhnangluong" role="tabpanel"
                            aria-labelledby="quatrinhnangluong-tab">

                        </div>
                        <div class="tab-pane fade" id="phucloibaohiem" role="tabpanel"
                            aria-labelledby="phucloibaohiem-tab">

                        </div>
                        <div class="tab-pane fade" id="thongtinkhac" role="tabpanel" aria-labelledby="thongtinkhac-tab">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Tình trạng hôn nhân</label>
                                        <h5>{{ $employee->is_marital ? 'Đã kết hôn' : 'Độc thân' }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Trình độ học vấn</label>
                                        <h5>{{ $employee->academic_level }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Trình độ chuyên môn</label>
                                        <h5>{{ $employee->qualification }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Lương cơ bản</label>
                                        <h5>{{ $employee->basic_pay->basic_pay_amount ?? 0 }}
                                            đồng
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Tên ngân hàng</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Số thẻ ngân hàng</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Chi nhánh</label>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Mã BHXH</label>
                                        <h5>{{ $employee->social_insurance_number }}</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Ngày tham gia BHXH</label>
                                        <h5></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>Thông tin thêm</label>
                                        <h5>{{ $employee->additional_infomation }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Quay về</a>
            </div>
        </div>
    </div>
@endsection
