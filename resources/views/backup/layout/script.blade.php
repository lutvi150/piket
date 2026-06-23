<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
</script>
<!--end::Required Plugin(popperjs for Bootstrap 5)-->
<!--begin::Required Plugin(Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<!--end::Required Plugin(Bootstrap 5)-->
<!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset('assets/js/adminlte.js') }}"></script>
<!--end::Required Plugin(AdminLTE)-->
<!--begin::OverlayScrollbars Configure-->
{{-- jquer --}}
<script src="{{ asset('assets/jquery/dist/jquery.js') }}"></script>
{{-- jquery form --}}
<script src="{{ asset('assets/jqform/src/jquery.form.js') }}"></script>
{{-- notiflix --}}
<script src="{{ asset('assets/notiflix/build/notiflix-aio.js') }}"></script>
{{-- datatable --}}
<script src="{{ asset('assets/DataTables/datatables.js') }}"></script>
<script>
    const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper"
    const Default = {
        scrollbarTheme: "os-theme-light",
        scrollbarAutoHide: "leave",
        scrollbarClickScroll: true
    }
    document.addEventListener("DOMContentLoaded", function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER)
        if (
            sidebarWrapper &&
            OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined
        ) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll
                }
            })
        }
    })
</script>
<!--end::OverlayScrollbars Configure-->
<!-- Image path runtime fix -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Find the link tag for the main AdminLTE CSS file.
        const cssLink = document.querySelector('link[href*="css/adminlte.css"]');
        if (!cssLink) {
            return; // Exit if the link isn't found
        }

        // Extract the base path from the CSS href.
        // e.g., from "../css/adminlte.css", we get "../"
        // e.g., from "./css/adminlte.css", we get "./"
        const cssHref = cssLink.getAttribute('href');
        const deploymentPath = cssHref.slice(0, cssHref.indexOf('css/adminlte.css'));

        // Find all images with absolute paths and fix them.
        document.querySelectorAll('img[src^="/assets/"]').forEach(img => {
            const originalSrc = img.getAttribute('src');
            if (originalSrc) {
                const relativeSrc = originalSrc.slice(1); // Remove leading '/'
                img.src = deploymentPath + relativeSrc;
            }
        });
    });
    // use for error
    error_function = (xhr) => {
        {
            const status = xhr.status;
            if (status === 422) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function (key, value) {
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