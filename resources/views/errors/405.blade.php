@extends('layouts.errors')

@section('title', 'Trang không tồn tại')

@section('header', '405')

@section('content')
    <h1 class="mb-1 text-muted font-weight-bold">Rất tiếc!</h1>
    <h6 class="mb-3 text-muted">Trang không tồn tại, vui lòng quay về trang chủ.</h6>
    <a href="{{ route('home') }}" class="btn btn-lg btn-primary px-5">Quay về trang chủ</a>
@endsection
