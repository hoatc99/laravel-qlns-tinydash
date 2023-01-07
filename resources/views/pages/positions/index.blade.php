@extends('layouts.master')

@section('title', 'Quản lý chức vụ')

@section('header', 'Quản lý chức vụ')

@section('hbuttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taochucvuModal">Tạo
        chức vụ</button>
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
                                <th>Tên phòng ban</th>
                                <th>Tên chức vụ</th>
                                <th>Phụ cấp</th>
                                <th>Số lượng nhân viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positions as $key => $position)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $position->department->name }}</td>
                                    <td>{{ $position->name }}</td>
                                    <td>{{ number_format($position->position_allowance_amount) }}</td>
                                    <td>{{ count($position->assignments) }}</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Xem nhân viên</a>
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#suachucvuModal{{ $position->id }}">Sửa</button>
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
    <div class="modal fade" id="taochucvuModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('positions.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Tạo phòng ban</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Tên chức vụ</label>
                                <input type="text" class="form-control" name="ten_chuc_vu" placeholder="Tên chức vụ"
                                    required autofocus>
                                <div class="invalid-feedback">Vui lòng nhập tên chức vụ</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Thuộc phòng ban</label>
                                <select class="form-control select2" name="ma_phong_ban" required>
                                    @foreach (\App\Models\Department::all() as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Phụ cấp chức vụ</label>
                                <input type="text" class="form-control input-money text-right" name="phu_cap_chuc_vu"
                                    required>
                                <div class="invalid-feedback">Vui lòng nhập phụ cấp chức vụ</div>
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

    @foreach ($positions as $position)
        <div class="modal fade" id="suachucvuModal{{ $position->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('positions.update', $position->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Sửa chức vụ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Tên chức vụ</label>
                                    <input type="text" class="form-control" name="ten_chuc_vu" placeholder="Tên chức vụ"
                                        value="{{ $position->name }}" required autofocus>
                                    <div class="invalid-feedback">Vui lòng nhập tên chức vụ</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Thuộc phòng ban</label>
                                    <select class="form-control select2" name="ma_phong_ban" required>
                                        @foreach (\App\Models\Department::all() as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $department->id == $position->department_id ? 'selected' : '' }}>
                                                {{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Phụ cấp chức vụ</label>
                                    <input type="text" class="form-control input-money text-right"
                                        name="phu_cap_chuc_vu" value="{{ $position->position_allowance_amount }}"
                                        required>
                                    <div class="invalid-feedback">Vui lòng nhập phụ cấp chức vụ</div>
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
    @endforeach
@endsection
