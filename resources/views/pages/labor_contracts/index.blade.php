@extends('layouts.master')

@section('title', 'Quản lý hợp đồng lao động')

@section('header', 'Quản lý hợp đồng lao động')

@section('hbuttons')
    <a href="{{ route('labor-contracts.create') }}" class="btn btn-primary">Tạo hợp đồng</a>
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
                                <th>Loại hợp đồng</th>
                                <th>Kỳ hạn</th>
                                <th>Ngày ký</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc dự kiến</th>
                                <th>Ngày kết thúc thực tế</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labor_contracts as $key => $labor_contract)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>NV{{ $labor_contract->employee->id }}</td>
                                    <td>{{ $labor_contract->employee->fullname }}</td>
                                    <td>{{ $labor_contract->type }}</td>
                                    <td>{{ $labor_contract->period }}</td>
                                    <td>{{ $labor_contract->signed_date }}</td>
                                    <td>{{ $labor_contract->start_date }}</td>
                                    <td>{{ $labor_contract->expected_end_date }}</td>
                                    <td>{{ $labor_contract->actual_end_date }}</td>
                                    <td>
                                        <div class="badge badge-{{ $labor_contract->is_active ? 'success' : 'danger' }}">
                                            {{ $labor_contract->is_active ? 'Đang kích hoạt' : 'Đã kết thúc' }}</div>
                                    </td>
                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#huyhopdongModal{{ $labor_contract->id }}">Hủy hợp
                                                đồng</button>
                                            {{-- <a class="dropdown-item"
                                                href="{{ route('employees.show', $labor_contract->id) }}">Xem chi tiết</a>
                                            <a class="dropdown-item"
                                                href="{{ route('employees.edit', $employee->id) }}">Sửa thông tin</a>
                                            <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#phancongModal{{ $employee->id }}">Phân công</button>
                                            <a class="dropdown-item" href="#">Cập nhật trạng thái</a> --}}
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
    @foreach ($labor_contracts as $labor_contract)
        <div class="modal fade" id="huyhopdongModal{{ $labor_contract->id }}" tabindex="-1" role="dialog"
            aria-labelledby="varyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Hủy hợp đồng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có thực sự muốn hủy hợp đồng của nhân viên <b>{{ $labor_contract->employee->fullname }}
                                (NV{{ $labor_contract->employee->id }})
                            </b>. Hợp đồng đã hủy không thể khôi phục.
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>Loại hợp đồng</label>
                                    <h6>{{ $labor_contract->type }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Thời hạn</label>
                                    <h6>{{ $labor_contract->period }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày ký</label>
                                    <h6>{{ $labor_contract->signed_date }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày bắt đầu</label>
                                    <h6>{{ $labor_contract->start_date }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Ngày kết thúc dự kiến</label>
                                    <h6>{{ $labor_contract->expired_end_date }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn mb-2 btn-danger">Hủy hợp đồng</button>
                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    {{-- <script>
        $().ready(() => {
            var options = {{ Js::from(\App\Models\Position::all()) }};
            $("select#ma_phong_ban").on("load change", () => {
                $("select#ma_chuc_vu").empty();
                var filtered = options.filter(x => x.department_id == $("select#ma_phong_ban").val());
                filtered.forEach((x) => {
                    $("select#ma_chuc_vu").append(new Option(x.name, x.id));
                })
            }).triggerHandler('change');
        });
    </script> --}}
@endsection
