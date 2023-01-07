@extends('layouts.master')

@section('title', 'Chọn bảng công để tính lương')

@section('header', 'Chọn bảng công để tính lương')

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
                <button type="submit" class="btn btn-primary">Xem danh sách nhân viên</button>
            </form>
        </div>
    </div>
    <div class="row my-4">
        <!-- Small table -->
        <div class="col-md-12">
            <form action="{{ route('payrolls.send_calculate_request') }}" method="post">
                @csrf
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Mã NV</th>
                                    <th>Tên NV</th>
                                    <th>Phòng ban</th>
                                    <th>Chức vụ</th>
                                    <th>Ngày chấm công</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timesheets as $key => $timesheet)
                                    <tr>
                                        <td><input type="checkbox" name="ma_bang_cong[]" value="{{ $timesheet->id }}" checked></td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>NV{{ $timesheet->employee->id }}</td>
                                        <td>{{ $timesheet->employee->fullname }}</td>
                                        <td>{{ $timesheet->department->name }}</td>
                                        <td>{{ $timesheet->position->name }}</td>
                                        <td>{{ date('d/m/Y h:i:s', strtotime($timesheet->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($timesheets->count() > 0)
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-primary">Tính lương</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('modals')

@endsection
