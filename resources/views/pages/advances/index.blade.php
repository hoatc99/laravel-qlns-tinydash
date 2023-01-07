@extends('layouts.master')

@section('title', 'Quản lý tạm ứng')

@section('header', 'Quản lý tạm ứng')

@section('hbuttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taotamungModal">Tạo
        tạm ứng</button>
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
                                <th>Tháng năm</th>
                                <th>Mã NV</th>
                                <th>Họ tên</th>
                                <th>Số tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advances as $key => $advance)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('m/Y', strtotime($advance->year_month)) }}</td>
                                    <td>NV{{ $advance->employee->id }}</td>
                                    <td>{{ $advance->employee->fullname }}</td>
                                    <td>{{ number_format($advance->advance_amount) }}</td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#suatamungModal{{ $advance->id }}">Sửa</button>
                                            <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                                data-target="#xoatamungModal{{ $advance->id }}">Xóa</button>
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
    <div class="modal fade" id="taotamungModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('advances.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varyModalLabel">Tạo tạm ứng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Chọn tháng</label>
                                <input type="month" class="form-control" name="thang_nam" required autofocus>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Số tiền</label>
                                <input type="text" class="form-control input-money text-right" name="so_tien" required>
                                <div class="invalid-feedback">Vui lòng nhập số tiền</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Chọn nhân viên</label>
                                <select class="form-control select2" name="ma_nhan_vien" required>
                                    <option value="">Vui lòng chọn nhân viên</option>
                                    @foreach (\App\Models\Employee::all() as $employee)
                                        <option value="{{ $employee->id }}">NV{{ $employee->id }} -
                                            {{ $employee->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Ghi chú</label>
                                <textarea class="form-control" name="ghi_chu"></textarea>
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

    @foreach ($advances as $advance)
        <div class="modal fade" id="suatamungModal{{ $advance->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('advances.update', $advance->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Sửa tạm ứng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Tháng</label>
                                    <h5>{{ date('m/Y', strtotime($advance->year_month)) }}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Nhân viên</label>
                                    <h5>NV{{ $advance->employee->id }} - {{ $advance->employee->fullname }}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Số tiền</label>
                                    <input type="text" class="form-control input-money text-right" name="so_tien"
                                        value="{{ $advance->advance_amount }}" required>
                                    <div class="invalid-feedback">Vui lòng nhập số tiền</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Ghi chú</label>
                                    <textarea class="form-control" name="ghi_chu">{{ $advance->note }}</textarea>
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

        <div class="modal fade" id="xoatamungModal{{ $advance->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('advances.destroy', $advance->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Xóa tạm ứng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Tháng</label>
                                    <h5>{{ date('m/Y', strtotime($advance->year_month)) }}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Nhân viên</label>
                                    <h5>NV{{ $advance->employee->id }} - {{ $advance->employee->fullname }}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Số tiền</label>
                                    <h5>{{ number_format($advance->advance_amount) }}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Ghi chú</label>
                                    <p>{{ $advance->note }}</p>
                                </div>
                            </div>
                            Bạn có muốn xóa thông tin tạm ứng này không?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn mb-2 btn-danger">Xóa</button>
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
