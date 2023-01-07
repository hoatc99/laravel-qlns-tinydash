@extends('layouts.master')

@section('title', 'Chọn phân công để chấm công')

@section('header', 'Chọn phân công để chấm công')

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
                            @foreach ($departments as $department)
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
            <form action="{{ route('timesheets.send_timekeeping_request') }}" method="post">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $key => $assignment)
                                    @php $employee = \App\Models\Employee::whereId($assignment->employee_id)->first() @endphp
                                    <tr>
                                        <td><input type="checkbox" name="phan_cong[{{ $assignment->id }}]" checked></td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>NV{{ $employee->id }}</td>
                                        <td>{{ $employee->fullname }}</td>
                                        <td>{{ $assignment->position->department->name }}</td>
                                        <td>{{ $assignment->position->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" name="thang_nam" value="{{ \Request::get('thang_nam') }}">
                @if (count($assignments) > 0)
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-primary">Chấm công</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('modals')

@endsection
