@extends('layout.template')
@section('content')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row g-4">
            <!--begin::Col-->
            <form id="form-tambah-siswa" action="{{ route('siswa-add') }}" enctype="multipart/form-data" method="POST">
                <div class="col-md-12">
                    <!--begin::Quick Example-->
                    <!--begin::Form-->
                    <div class="card card-primary card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Data Siswa</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama_siswa" aria-describedby="">
                                <span class="text-error e-nama_siswa"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Jenis Kelamin</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                        id="inlineRadio1" value="L">
                                    <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin"
                                        id="inlineRadio2" value="P">
                                    <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis_siswa" aria-describedby="emailHelp">
                                <span class="text-error e-nis_siswa"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat_siswa" aria-describedby="emailHelp">
                                <span class="text-error e-alamat_siswa"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Kelas</label>
                                <select name="id_kelas" class="form-control" id="">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <span class="text-error e-alamat_siswa"></span>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="row">
                  <div class="col-md-6">
                    <!--begin::Quick Example-->
                    <div class="card card-danger card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Data Orang Tua Laki-laki</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form>
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Orang Tua Laki-laki</label>
                                    <input type="text" class="form-control" id="nama_orang_tua_lk"
                                        aria-describedby="emailHelp">
                                    <span class="text-error e-nama_orang_tua_lk"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan_orang_tua_lk"
                                        aria-describedby="emailHelp">
                                    <span class="text-error e-pekerjaan_orang_tua_lk"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat_orang_tua_lk"
                                        aria-describedby="emailHelp">
                                    <span class="text-error e-alamat_orang_tua_lk"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telp_orang_tua_lk"
                                        aria-describedby="emailHelp">
                                    <span class="text-error e-no_telp_orang_tua_lk"></span>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!--begin::Quick Example-->
                    <div class="card card-danger card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">Nama Orang Tua Perempuan</div>
                        </div>
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Orang Tua Perempuan</label>
                                <input type="text" class="form-control" id="nama_orang_tua_pr"
                                    aria-describedby="emailHelp">
                                <span class="text-error e-nama_orang_tua_lk"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan_orang_tua_pr"
                                    aria-describedby="emailHelp">
                                <span class="text-error e-pekerjaan_orang_tua_lk"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat_orang_tua_pr"
                                    aria-describedby="emailHelp">
                                <span class="text-error e-alamat_orang_tua_lk"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp_orang_tua_pr"
                                    aria-describedby="emailHelp">
                                <span class="text-error e-no_telp_orang_tua_lk"></span>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-success btn-sm" type="button" onclick="store_data()"><i class="fa fa-save"></i> Simpan</button>
                    <a href="{{route('data-siswa')}}" type="button" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i>Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <!--end::Row-->
</div>
<!--end::Container-->
</div>
@endsection
@section('script')
    <script>
        store_data = () => {
            $(".text-error").text('');
            let formData = {};
    
    $('#form-tambah-siswa').find('input, textarea, select').each(function () {
        let id = $(this).attr('id');
        let name = $(this).attr('name');
        let type = $(this).attr('type');
        let key = name ?? id;
        if (!key) return; 
        if (type === 'radio') {
            if ($(this).is(':checked')) {
                formData[key] = $(this).val();
            }
        } else {
            formData[key] = $(this).val();
        }
    });

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                url: $("#form-tambah-siswa").attr('action'),
                dataType: "JSON",
                success: function (response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `"Data Kelas Berhasil Disimpan." `,
                            `Okay`,
                        );
                        $('#form-tambah-siswa')[0].reset(); // Reset the form
                        // Optionally, you can refresh the page or update the table here
                        // location.reload();
                    } else {
                        console.log('disini');

                        // Handle validation errors
                        $.each(response.errors, function (key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Data Kelas Gagal Disimpan`,
                            `Okay`,
                        );
                    }
                },
                error: function (xhr) {
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
            });
        }
    </script>
@endsection