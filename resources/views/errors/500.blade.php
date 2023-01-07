@extends('layouts.errors')

@section('title', 'Lỗi tải trang')

@section('header', '500')

@section('content')
    <h1 class="mb-1 text-muted font-weight-bold">Lỗi tải trang!</h1>
    <h6 class="mb-3 text-muted">Vui lòng tải lại trang hoặc quay về trang chủ.</h6>
    <a href="{{ route('home') }}" class="btn btn-lg btn-primary px-5">Quay về trang chủ</a>
@endsection
