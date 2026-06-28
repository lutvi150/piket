<!-- jQuery 2.1.4 -->
<script src="{{ asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{-- <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script> --}}
<!-- Sparkline -->
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/app.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
{{-- jquery form --}}
<script src="{{ asset('assets/jqform/src/jquery.form.js') }}"></script>
{{-- notiflix --}}
<script src="{{ asset('assets/notiflix/build/notiflix-aio.js') }}"></script>
{{-- reusable code --}}
<script src="{{ asset('assets/js/reusable.js') }}"></script>

<script>
    const BASE_URL = "{{ url('/') }}";
    window.APP = {
        user: @json(session('data')),
        baseUrl: @json(url('/'))
    };
    // use for error
    error_function = (xhr) => {
        {
            const status = xhr.status;
            if (status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $(`.e-${key}`).text(value[0]);
                });
            } else if (status === 404) {
                Notiflix.Report.failure(
                    `Error 404`,
                    `Data tidak ditemukan`,
                    `Okay`,
                );
            } else if (status === 500) {
                Notiflix.Report.failure(
                    `Error 500`,
                    `Terjadi kesalahan pada server`,
                    `Okay`,
                );
            } else {
                Notiflix.Report.failure(
                    `Kesalahan`,
                    `Terjadi kesalahan tidak diketahui`,
                    `Okay`,
                );
            }

        }
    }
</script>
