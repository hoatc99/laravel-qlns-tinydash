@extends('layouts.master')

@section('title', 'Quản lý đóng bảo hiểm')

@section('header', 'Quản lý đóng bảo hiểm')

@section('content')
    <div class="row my-4">
        <div class="col-12">
            <form action="">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label>Chọn tháng</label>
                        <input type="month" class="form-control" name="thang_nam" value="{{ \Request::get('thang_nam') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Xem danh sách nhân viên đóng bảo hiểm</button>
            </form>
        </div>
    </div>
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
                                <th>BHXH</th>
                                <th>BHYT</th>
                                <th>BHTN</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đóng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insurance_pays as $key => $insurance_pay)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('m/Y', strtotime($insurance_pay->year_month)) }}</td>
                                    <td>{{ $insurance_pay->employee->id }}</td>
                                    <td>{{ $insurance_pay->employee->fullname }}</td>
                                    <td>{{ number_format($insurance_pay->social_insurance_pay_amount) }}</td>
                                    <td>{{ number_format($insurance_pay->health_insurance_pay_amount) }}</td>
                                    <td>{{ number_format($insurance_pay->unemployment_insurance_pay_amount) }}</td>
                                    <td>{{ number_format($insurance_pay->sum_of_insurances_amount) }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($insurance_pay->created_at)) }}</td>
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

@endsection
