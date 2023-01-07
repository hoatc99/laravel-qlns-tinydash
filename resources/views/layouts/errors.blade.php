<!doctype html>
<html lang="en">

<head>
    @include('includes.metas')
    @include('includes.styles')

    <title>@yield('title', 'Lỗi không xác định')</title>
</head>

<body>
    <div class="wrapper vh-100">
        <div class="align-items-center h-100 d-flex w-50 mx-auto">
            <div class="mx-auto text-center">
                <h1 class="display-1 m-0 font-weight-bolder text-muted" style="font-size:80px;">@yield('header')</h1>

                @yield('content')
            </div>
        </div>
    </div>
    @include('includes.scripts')
</body>

</html>
</body>

</html>
