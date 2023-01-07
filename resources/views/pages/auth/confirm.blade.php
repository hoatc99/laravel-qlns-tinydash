@extends('layouts.auth')

@section('title', 'Xác nhận')

@section('header', 'Đã nhận thông tin')

@section('content')
    <form class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        <div class="alert alert-success" role="alert">Chúng tôi đã nhận được thông tin của bạn. Vui lòng giữ liên lạc
            trong 1 - 2 ngày làm việc tiếp theo.</div>
        <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-block">Trở về trang đăng nhập</a>
        <p class="mt-5 mb-3 text-muted">HoaBinhGroup &copy; 2022</p>
    </form>
@endsection
