<script src="{{asset('admin/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('admin/assets/compiled/js/app.js')}}"></script>
<!-- Need: Apexcharts -->
<script src="{{asset('admin/assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/assets/static/js/pages/dashboard.js')}}"></script>

<script src="{{asset('admin/assets/extensions/dayjs/dayjs.min.js')}}"></script>
<script src="{{asset('admin/assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/assets/static/js/pages/ui-apexchart.js')}}"></script>

{{-- Bootstrap and Popper JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{--sweetalert--}}

<script src="{{asset('admin/assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>>
<script src="{{asset('admin/assets/static/js/pages/sweetalert2.js')}}"></script>>
{{-- Toast init --}}
<script>

    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: @json(session('success'))
        });
        @elseif (session('error'))
        Toast.fire({
            icon: 'error',
            title: @json(session('error'))
        });
        @endif
    });
</script>
@stack('scripts')


<!-- End custom js for this page -->
