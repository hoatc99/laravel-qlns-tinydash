@extends('layouts.master')

@section('title', 'Chỉnh sửa bảng công')

@section('header', 'Chỉnh sửa bảng công')

@section('content')
    <div class="row my-4">
        <div class="col-md-12">
            <form action="{{ route('timesheets.update', $timesheet->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mã NV</th>
                                    <th>Tên NV</th>
                                    <th>Phòng ban</th>
                                    <th>Chức vụ</th>
                                    <th>Ngày công chuẩn</th>
                                    <th>Số ngày công</th>
                                    <th>Nghỉ phép</th>
                                    <th>Nghỉ không phép</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>NV{{ $timesheet->employee->id }}</td>
                                    <td>{{ $timesheet->employee->fullname }}</td>
                                    <td>{{ $timesheet->position->department->name }}</td>
                                    <td>{{ $timesheet->position->name }}</td>
                                    <td id="ngaycongchuan">{{ $timesheet->business_days }}</td>
                                    <td id="songaycong"></td>
                                    <td><input type="text" class="form-control input-day" id="nghiphep"
                                            name="nghiphep" oninput="calc_working_days()" value="{{ $timesheet->leave_days }}" required></td>
                                    <td><input type="text" class="form-control input-day"
                                            id="nghikhongphep" name="nghikhongphep"
                                            oninput="calc_working_days()" value="{{ $timesheet->unauthorized_leave_days }}" required>
                                    </td>
                                    <td>
                                        <textarea name="ghichu" class="form-control">{{ $timesheet->note }}"</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </form>
        </div> <!-- Bordered table -->
    </div> <!-- end section -->
@endsection

@section('modals')

@endsection

@section('scripts')
    {{-- <script>
        // var calc_working_days = (index = null) => {
        //     let business_days = parseInt({!! json_encode($assignments) !!}[index]['business_days']);
        //     let working_days = business_days - $(`#nghiphep${index}`).val() - $(`#nghikhongphep${index}`).val();
        //     $(`#songaycong${index}`).text(working_days);
        //     let status = working_days < 0;
        //     $(':input[type="submit"]').prop('disabled', status);
        // }
        const calc_working_days = (index) => {
            let status = true;
            if (index == 0) {
                status = check_inputs();
            } else {
                let business_days = parseInt({!! json_encode($assignments) !!}[index]['business_days']);
                let working_days = business_days - $(`#nghiphep${index}`).val() - $(`#nghikhongphep${index}`).val();
                $(`#songaycong${index}`).text(working_days);
                status = working_days < 0;
                status = check_inputs();
            }
            $(':input[type="submit"]').prop('disabled', status);
        }

        const check_inputs = () => {
            $(':input.input-day').each(() => {
                if ($(this).val() == '') {
                    return false;
                }
            });
            return true;
        }

        $().ready(() => {
            calc_working_days(0);
        })
    </script> --}}
@endsection
