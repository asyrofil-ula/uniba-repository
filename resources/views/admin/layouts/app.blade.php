<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.partials.head')
</head>

<body>
<script src="{{asset('admin/assets/static/js/initTheme.js')}}"></script>
    <div id="app">
        @include('admin.layouts.partials.navbar')
        @include('admin.layouts.partials.sidebar')

        <!-- partial -->
        <div id="main" class="">
{{--           --}}
                <h3>@yield('header')</h3>
            <div class="page-content">
                @yield('content')
            </div>
            @include('admin.layouts.partials.footer')

            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    @include('admin.layouts.partials.scripts')
</body>

</html>
