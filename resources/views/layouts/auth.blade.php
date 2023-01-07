<!doctype html>
<html lang="en">

<head>
    @include('includes.metas')
    @include('includes.styles')

    <title>HoaBinhGroup - @yield('title', 'Xác thực')</title>
</head>

<body>
    <div class="wrapper vh-100">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="col-md-12 text-center">
                <h1 class="h1">@yield('header')</h1>
                <div class="navbar-brand mx-auto flex-fill text-center mb-3 text-muted">HoaBinhGroup</div>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        @include('partials.messages')
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    @include('includes.scripts')
    @yield('scripts')
</body>

</html>
