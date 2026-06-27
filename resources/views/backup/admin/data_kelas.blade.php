@extends('layout.template')
@section('content')
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <!-- /.card -->
                    <div class="card mb-12">
                        <div class="card-header">
                            <h3 class="card-title">Data Kelas</h3> <br>
                            <button class="btn btn-sm btn-success" onclick="show_modal()"><i class="fa fa-plus"></i> Tambah
                                Kelas</button>
                        </div> <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Siswa</th>
                                        <th>Nama Guru Kelas</th>
                                        <th style="width: 40px">Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $item)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_kelas }}</td>
                                            <td>
                                                <label for=""
                                                    class="label label-danger">{{ $item->siswa_count }}</label>
                                            </td>
                                            <td>
                                                <label for=""
                                                    class="label label-primary">{{ $item->guru->nama_guru ?? '-' }}</label>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"
                                                    onclick="edit_data({{ $item->id }})"><i
                                                        class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="delete_data({{ $item->id }})"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    {{-- use for modal --}}
    <!-- Modal add -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-add-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="form-add" action="{{ route('kelas-add') }}" method="POST">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                                placeholder="Masukkan Nama Kelas">
                            <span class="e-nama_kelas text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="id_guru" class="form-label">Nama Guru</label>
                            <select name="id_guru" class="form-control" id="id_guru">

                            </select>
                            <span class="e-nama_guru text-error"></span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" onclick="store_data()" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
        <script>
            data_guru = (callback) => {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-guru') }}",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            let html = '<option value="">-- Pilih Guru --</option>';
                            $.each(response.data, function(i, v) {
                                html += `<option value="${v.id}">${v.nama_guru}</option>`;
                            });
                            $("#id_guru").html(html);

                            // Jalankan callback setelah data guru berhasil dimuat
                            if (typeof callback === "function") {
                                callback();
                            }
                        } else {
                            alert('Gagal mengambil data guru.');
                        }
                    },
                    error: function(xhr) {
                        error_function(xhr);
                    }
                });
            }

            show_modal = () => {
                sessionStorage.setItem('jenis', 'store');
                data_guru(() => {
                    $('.modal-add-title').text('Tambah Kelas');
                    $('#modal-add').modal('show');
                });
            }

            edit_data = (id) => {
                sessionStorage.setItem('id_kelas', id);
                sessionStorage.setItem('jenis', 'update');
                data_guru(() => {
                    $.ajax({
                        type: "GET",
                        url: `{{ url('admin/kelas/${id}/edit') }}`,
                        dataType: "JSON",
                        success: function(response) {
                            $('#nama_kelas').val(response.data.nama_kelas);
                            $('#id_guru').val(response.data.id_guru);
                            $('.modal-add-title').text('Edit Kelas');
                            $('#modal-add').modal('show');
                        },
                        error: function(xhr) {
                            error_function(xhr)
                        }
                    });
                });

            }
            store_data = () => {
                $(".text-error").text('');
                let formData =
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: $("#form-add").attr('action'),
                        data: {
                            nama_kelas: $("#nama_kelas").val(),
                            id: sessionStorage.getItem('id_kelas'),
                            jenis: sessionStorage.getItem('jenis'),
                            id_guru: $("#id_guru").val(),
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Berhasil`,
                                    `Data Kelas Berhasil Disimpan`,
                                    `Okay`,
                                );
                                $('#modal-add').modal('hide');
                                location.reload();
                            } else {
                                console.log('disini');

                                // Handle validation errors
                                $.each(response.errors, function(key, value) {
                                    $(`.e-${key}`).text(value[0]);
                                });
                                Notiflix.Report.failure(
                                    `Kesalahan`,
                                    `Data Kelas Gagal Disimpan`,
                                    `Okay`,
                                );
                            }
                        },
                        error: function(xhr) {
                            error_function(xhr)
                        }
                    });
            }
            delete_data = (id) => {
                Notiflix.Confirm.show(
                    'Konfirmasi Hapus',
                    'Apakah Anda yakin ingin menghapus data ini?',
                    'Ya',
                    'Tidak',
                    function() {
                        $.ajax({
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('admin/kelas/kelas-delete/${id}') }}`,
                            success: function(response) {
                                if (response.status == true) {
                                    Notiflix.Report.success(
                                        `Berhasil`,
                                        `Data Kelas Berhasil Dihapus`,
                                        `Okay`,
                                    );
                                    location.reload();
                                } else {
                                    Notiflix.Report.failure(
                                        `Gagal`,
                                        `Data Kelas Gagal Dihapus`,
                                        `Okay`,
                                    );
                                }
                            },
                            error: function(xhr) {
                                Notiflix.Report.failure(
                                    `Kesalahan`,
                                    `Terjadi kesalahan saat menghapus data`,
                                    `Okay`,
                                );
                            }
                        });
                    },
                    function() {
                        // User clicked "No"
                        Notiflix.Notify.info('Penghapusan dibatalkan.');
                    }
                );
            }
        </script>
    @endsection
