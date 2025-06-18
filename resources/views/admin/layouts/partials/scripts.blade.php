
<script src="{{asset('admin/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('admin/assets/compiled/js/app.js')}}"></script>
<!-- Need: Apexcharts -->
<script src="{{asset('admin/assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/assets/static/js/pages/dashboard.js')}}"></script>

{{-- Bootstrap and Popper JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')


{{-- <script src="{{ asset('/js/toast.js') }}"></script> --}}

<script>
    function toastSuccess(text) {
        toastr.success(
            text,
            "Berhasil!", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 1000
            }
        );
    }

    function toastError(text) {
        toastr.error(
            text,
            "GAGAL !", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 1000
            }
        );
    }

</script>

<!-- End custom js for this page -->
