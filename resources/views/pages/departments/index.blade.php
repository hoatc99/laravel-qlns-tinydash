@extends('layouts.master')

@section('title', 'Quản lý phòng ban')

@section('header', 'Quản lý phòng ban')

@section('hbuttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taophongbanModal">Tạo
        phòng ban</button>
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
                                <th>Tổng số nhân viên</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $key => $department)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ count($department->assignments) }}</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Xem nhân viên</a>
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#suaphongbanModal{{ $department->id }}">Sửa</button>
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
    <div class="modal fade" id="taophongbanModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('departments.store') }}" method="post">
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
                                <label>Tên phòng ban</label>
                                <input type="text" class="form-control" name="ten_phong_ban" placeholder="Tên phòng ban"
                                    required autofocus>
                                <div class="invalid-feedback">Vui lòng nhập tên phòng ban</div>
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

    @foreach ($departments as $department)
        <div class="modal fade" id="suaphongbanModal{{ $department->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('departments.update', $department->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Sửa phòng ban</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Tên phòng ban</label>
                                    <input type="text" class="form-control" name="ten_phong_ban"
                                        value="{{ $department->name }}" placeholder="Tên phòng ban" required autofocus>
                                    <div class="invalid-feedback">Vui lòng nhập tên phòng ban</div>
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
