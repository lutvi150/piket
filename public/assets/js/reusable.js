function handleAjaxError(xhr) {
    let status = xhr.status;

    if (status === 422) {
        let errors = xhr.responseJSON.errors;

        // reset dulu semua error
        $('.text-danger').text('');

        $.each(errors, function (key, value) {
            $(`.e-${key}`).text(value[0]);
        });

    } else if (status === 404) {
        Notiflix.Report.failure(
            'Error 404',
            'Data tidak ditemukan.<br/><br/>- Admin',
            'OK'
        );

    } else if (status === 500) {
        Notiflix.Report.failure(
            'Error 500',
            'Terjadi kesalahan pada server.<br/><br/>- Admin',
            'OK'
        );

    } else {
        Notiflix.Report.failure(
            'Kesalahan',
            'Terjadi kesalahan tidak diketahui.<br/><br/>- Admin',
            'OK'
        );
    }
}