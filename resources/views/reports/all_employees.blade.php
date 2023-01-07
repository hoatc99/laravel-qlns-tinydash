@extends('layouts.master')

@section('title', 'Danh sách nhân viên toàn công ty')

@section('header', 'Danh sách nhân viên toàn công ty')

@section('content')
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã NV</th>
                                <th>Tên NV</th>
                                <th>Phòng ban</th>
                                <th>Chức vụ</th>
                                <th>Hợp đồng</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $key => $assignment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>NV{{ $assignment->employee->id }}</td>
                                    <td>{{ $assignment->employee->fullname }}</td>
                                    <td>{{ $assignment->position->department->name }}</td>
                                    <td>{{ $assignment->position->name }}</td>
                                    <td id="ngaycongchuan">{{ $assignment->business_days }}</td>
                                    <td id="songaycong{{ $key }}"></td>
                                    <td><input type="text" class="form-control input-day" id="nghiphep{{ $key }}"
                                            name="nghiphep[]" oninput="calc_working_days({{ $key }})" required>
                                    </td>
                                    <td><input type="text" class="form-control input-day"
                                            id="nghikhongphep{{ $key }}" name="nghikhongphep[]"
                                            oninput="calc_working_days({{ $key }})" required>
                                    </td>
                                    <td>
                                        <textarea name="ghichu[]" class="form-control"></textarea>
                                    </td>
                                    <input type="hidden" name="ngaycongchuan[]" value="{{ $assignment->business_days }}">
                                    <input type="hidden" name="manhanvien[]" value="{{ $assignment->employee->id }}">
                                    <input type="hidden" name="maphancong[]" value="{{ $assignment->id }}">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3 text-right">
                <button type="submit" class="btn btn-primary">Xuất Excel</button>
            </div>
        </div> <!-- Bordered table -->
    </div> <!-- end section -->
@endsection
