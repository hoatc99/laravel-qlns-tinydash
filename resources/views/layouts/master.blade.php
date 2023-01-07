<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.metas')
    @include('includes.styles')

    <title>HoaBinhGroup - @yield('title', 'Quản lý nhân sự')</title>
</head>

<body class="vertical">
    <div class="wrapper">

        @include('partials.navbar')
        @include('partials.sidebar')

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="mb-2 page-title">@yield('header')</h2>

                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                @include('partials.messages')
                            </div>
                            <div class="col-md-3 text-right">
                                @yield('hbuttons')
                            </div>
                        </div>
                        @yield('content')

                    </div>
                </div>
            </div> <!-- .container-fluid -->

            @include('components.modal-notification')
            @include('components.modal-shortcut')
            @yield('modals')
        </main> <!-- main -->
    </div> <!-- .wrapper -->
    @include('includes.scripts')
    @yield('scripts')
</body>

</html>
