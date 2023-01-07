@extends('layouts.master')

@section('title', 'Quản lý hồ sơ')

@section('header', 'Quản lý hồ sơ')

@section('hbuttons')
    <a href="{{ route('employees.create') }}" class="btn btn-primary">Tạo hồ sơ</a>
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
                                <th>Mã NV</th>
                                <th>Tên NV</th>
                                <th>Ảnh</th>
                                <th>Phòng ban hiện tại</th>
                                <th>Chức vụ hiện tại</th>
                                <th>Hợp đồng hiện tại</th>
                                <th>Ngày nhận việc</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $key => $employee)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>NV{{ $employee->id }}</td>
                                    <td>{{ $employee->fullname }}</td>
                                    <td class="text-center">
                                        <img alt="image" src="{{ asset('upload/avatars/' . $employee->avatar_url) }}"
                                            class="rounded-circle" width="35" data-toggle="tooltip"
                                            title="{{ $employee->fullname }}">
                                    </td>
                                    <td>{{ @$employee->assignment->department->name }}
                                    </td>
                                    <td>{{ @$employee->assignment->position->name }}</td>
                                    <td>{{ @$employee->labor_contract->period }}</td>
                                    <td>{{ date('d/m/Y', strtotime($employee->date_of_employment)) }}</td>
                                    <td>
                                        <div class="badge badge-{{ $employee->is_working ? 'success' : 'danger' }}">
                                            {{ $employee->is_working ? 'Đang làm việc' : 'Đã thôi việc' }}</div>
                                    </td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                                href="{{ route('employees.show', $employee->id) }}">Xem chi tiết</a>
                                            @if ($employee->is_working)
                                                <a class="dropdown-item"
                                                    href="{{ route('employees.edit', $employee->id) }}">Sửa thông tin</a>
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#phancongModal{{ $employee->id }}">Phân công</button>
                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                                    data-target="#capnhatthoiviecModal{{ $employee->id }}">Cập nhật thôi
                                                    việc</button>
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
    @foreach ($employees as $employee)
        <div class="modal fade" id="phancongModal{{ $employee->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('employees.assign', $employee->id) }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Phân công</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>Mã NV</label>
                                    <h6>NV{{ $employee->id }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày bắt đầu</label>
                                    <input type="text" class="form-control drgpicker" name="ngay_bat_dau"
                                        value="{{ date('d/m/Y', strtotime(today())) }}" aria-describedby="button-addon2" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Họ và tên</label>
                                    <h6>{{ $employee->fullname }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày kết thúc</label>
                                    <input type="text" class="form-control drgpicker" name="ngay_ket_thuc"
                                        value="{{ date('d/m/Y', strtotime(today()->addYears())) }}" aria-describedby="button-addon2"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phòng ban hiện tại</label>
                                    <h6>{{ @$employee->assignment->department->name }}
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phòng ban mới</label>
                                    <select class="form-control select2" name="ma_phong_ban" id="ma_phong_ban{{ (int)$employee->id }}"
                                        onchange="get_positions({{ (int)$employee->id }})" required>
                                        <option value="">Vui lòng chọn phòng ban</option>
                                        @foreach (\App\Models\Department::all() as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Chức vụ hiện tại</label>
                                    <h6>{{ @$employee->assignment->position->name }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Chức vụ mới</label>
                                    <select class="form-control select2" name="ma_chuc_vu"
                                        id="ma_chuc_vu{{ (int)$employee->id }}" required></select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày kết thúc</label>
                                    <h6>{{ @$employee->assignment->expected_end_date ?? 'Không có' }}
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Các loại phụ cấp được hưởng</label>
                                    <select class="form-control select2-multi" name="allowances[]">
                                        <option value="" value=""></option>
                                        <option value="gui_xe">Gửi xe</option>
                                        <option value="truc_sieu_thi">Trực siêu thị</option>
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

        <div class="modal fade" id="capnhatthoiviecModal{{ $employee->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('employees.update_status', $employee->id) }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Cập nhật thôi việc</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>Mã NV</label>
                                    <h6>NV{{ $employee->id }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Họ và tên</label>
                                    <h6>{{ $employee->fullname }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phòng ban</label>
                                    <h6>{{ @$employee->assignment->department->name }}
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Chức vụ</label>
                                    <h6>{{ @$employee->assignment->position->name }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày thôi việc</label>
                                    <input type="text" class="form-control drgpicker" name="ngay_thoi_viec"
                                        value="{{ date('d/m/Y', strtotime(today())) }}" aria-describedby="button-addon2" required>
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
    @endforeach
@endsection

@section('scripts')
    <script>
        const get_positions = (employee_id) => {
            $(`select#ma_chuc_vu${employee_id}`).empty();
            $.post("api/get_positions", {
                    department_id: $(`select#ma_phong_ban${employee_id}`).val()
                },
                (res) => {
                    res.forEach((x) => {
                        $(`select#ma_chuc_vu${employee_id}`).append(new Option(x.name, x.id));
                    })
                });
        }
        // $().ready(() => {
        //     $("select#ma_phong_ban").on("load change", () => {
        //         console.log($("select#ma_phong_ban").find("option:selected").val());
        //         $("select#ma_chuc_vu").empty();
        //         $.post("api/get_positions", {
        //                 department_id: $("select#ma_phong_ban").find("option:selected").val()
        //             },
        //             (res) => {
        //                 console.log(res);
        //                 res.forEach((x) => {
        //                     $("select#ma_chuc_vu").append(new Option(x.name, x.id));
        //                 })
        //             });
        //     }).triggerHandler('change');
        // });
        // $().ready(() => {
        //     var options = {{ Js::from(\App\Models\Position::all()) }};
        //     $("select#ma_phong_ban").on("load change", () => {
        //         $("select#ma_chuc_vu").empty();
        //         var filtered = options.filter(x => x.department_id == $("select#ma_phong_ban").val());
        //         filtered.forEach((x) => {
        //             $("select#ma_chuc_vu").append(new Option(x.name, x.id));
        //         })
        //     }).triggerHandler('change');
        // });
    </script>
@endsection
