@extends('layouts.auth')

@section('title', 'Cấp lại mật khẩu')

@section('header', 'Yêu cầu cấp lại mật khẩu')

@section('content')
    <form action="{{ route('confirm') }}" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        @csrf
        <p class="text-muted">Vui lòng điền chính xác các thông tin sau đây, đội ngũ IT của chúng tôi sẽ sớm hỗ trợ bạn</p>
        <div class="form-group">
            <label class="sr-only">Tên đăng nhập</label>
            <input type="text" class="form-control form-control-lg" name="ten_tai_khoan" placeholder="Tên đăng nhập"
                required="" autofocus="">
        </div>
        <div class="form-group">
            <label class="sr-only">Số điện thoại</label>
            <input type="text" class="form-control form-control-lg" name="so_dien_thoai" placeholder="Số điện thoại"
                required="">
        </div>
        <div class="form-group">
            <label class="sr-only">Địa chỉ email</label>
            <input type="email" class="form-control form-control-lg" name="email" placeholder="Địa chỉ email"
                required="">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Gửi thông tin</button>
        <div class="mt-3">
            <a href="{{ route('login') }}">Trở về trang đăng nhập</a>
        </div>
        <p class="mt-5 mb-3 text-muted">HoaBinhGroup &copy; 2022</p>
    </form>
@endsection
