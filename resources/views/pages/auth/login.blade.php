@extends('layouts.auth')

@section('title', 'Đăng nhập')

@section('header', 'Đăng nhập')

@section('content')
    <form action="{{ route('authenticate') }}" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
        @csrf
        <div class="form-group">
            <label class="sr-only">Tên đăng nhập</label>
            <input type="text" class="form-control form-control-lg" name="ten_dang_nhap" placeholder="Tên đăng nhập"
                required="" autofocus="">
        </div>
        <div class="form-group">
            <label class="sr-only">Mật khẩu</label>
            <input type="password" class="form-control form-control-lg" name="mat_khau" placeholder="Mật khẩu"
                required="">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
        <div class="mt-3">
            <a href="{{ route('forgot') }}">Tôi đã quên mật khẩu</a>
        </div>
        <p class="mt-5 mb-3 text-muted">HoaBinhGroup &copy; 2022</p>
    </form>
@endsection

@section('modals')

@endsection
