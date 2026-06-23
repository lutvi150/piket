@extends('layout.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data {{ $title }}
                <small>Data {{ $title }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Data</a></li>
                <li class="active">{{ $title }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Kelas</h3>
                            <div style="margin-top:10px">
                                <button onclick="show_modal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>
                                    Tambah Kelas</button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Siswa</th>
                                        <th>Wali Kelas</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $item)
                                        <tr>
                                            <td style="width: 10px">{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_kelas }}</td>
                                            <td>
                                                <label for=""
                                                    class="label label-danger">{{ $item->siswa_count }}</label>
                                            </td>
                                            <td>
                                                <label for=""
                                                    class="label label-primary">{{ $item->guru?->nama_guru ?? '-' }}</label>
                                            </td>
                                            <td style="width:40px">
                                                <button onclick="delete_data({{ $item->id }})"
                                                    class="btn btn-danger
                                                    btn-xs"><i
                                                        class="fa fa-trash"></i></button>
                                                <button onclick="edit_data({{ $item->id }})"
                                                    class="btn btn-warning
                                                    btn-xs"><i
                                                        class="fa fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>

    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-add-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="form-add" action="" method="POST">
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    <script>
        data_guru = (callback) => {
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/guru/walikelas`,
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        let html = '<option value="">-- Pilih Guru --</option>';
                        $.each(response.data, function(i, v) {
                            html += `<option value="${v.id}">${v.nama_guru}</option>`;
                        });
                        $("#id_guru").html(html);
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
            sessionStorage.setItem('TY', 'POST');
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `{{ url('api/kelas') }}`);
            $('.text-error').text('');
            data_guru(() => {
                $('.modal-add-title').text('Tambah Kelas');
                $('#modal-add').modal('show');
            });
        }

        edit_data = (id) => {
            sessionStorage.setItem('TY','PUT');
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `${BASE_URL}/api/kelas/${id}`,);
            data_guru(() => {
                $.ajax({
                    type: "GET",
                    url: `${BASE_URL}/api/kelas/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        $('#nama_kelas').val(response.data.nama_kelas);
                        $('#id_guru').val(response.data.id_guru);
                        sessionStorage.setItem('id_guru', response.data.id_guru);
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
                    type: sessionStorage.getItem("TY"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $("#form-add").attr('action'),
                    data: {
                        nama_kelas: $("#nama_kelas").val(),
                        id: sessionStorage.getItem('id_kelas'),
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
