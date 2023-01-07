@extends('layouts.errors')

@section('title', 'Không tìm thấy trang')

@section('header', '404')

@section('content')
    <h1 class="mb-1 text-muted font-weight-bold">Rất tiếc!</h1>
    <h6 class="mb-3 text-muted">Không tìm thấy trang này.</h6>
    <a href="{{ route('home') }}" class="btn btn-lg btn-primary px-5">Quay về trang chủ</a>
@endsection
