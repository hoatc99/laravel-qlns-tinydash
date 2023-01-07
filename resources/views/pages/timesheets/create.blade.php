@extends('layouts.master')

@section('title', 'Chấm công')

@section('header', 'Chấm công ' . date('m/Y', strtotime(Session::get('year_month'))))

@section('content')
    <div class="row my-4">
        <div class="col-md-12">
            <form action="{{ route('timesheets.store') }}" method="post">
                @csrf
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
                                    <th>Ngày công chuẩn</th>
                                    <th>Số ngày công</th>
                                    <th>Nghỉ phép</th>
                                    <th>Nghỉ không phép</th>
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
                                        <td><input type="text" class="form-control input-day"
                                                id="nghiphep{{ $key }}" name="nghiphep[]"
                                                oninput="calc_working_days({{ $key }})" required></td>
                                        <td><input type="text" class="form-control input-day"
                                                id="nghikhongphep{{ $key }}" name="nghikhongphep[]"
                                                oninput="calc_working_days({{ $key }})" required>
                                        </td>
                                        <td>
                                            <textarea name="ghichu[]" class="form-control"></textarea>
                                        </td>
                                        <input type="hidden" name="ngaycongchuan[]"
                                            value="{{ $assignment->business_days }}">
                                        <input type="hidden" name="manhanvien[]" value="{{ $assignment->employee->id }}">
                                        <input type="hidden" name="maphancong[]" value="{{ $assignment->id }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary">Chấm công</button>
                </div>
            </form>
        </div> <!-- Bordered table -->
    </div> <!-- end section -->
@endsection

@section('modals')

@endsection

@section('scripts')
    <script>
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
    </script>
@endsection
