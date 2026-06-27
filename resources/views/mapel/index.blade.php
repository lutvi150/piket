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
                            <h3 class="box-title">Data Mata Pelajaran</h3>
                            <div style="margin-top:10px">
                                <button onclick="show_modal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>
                                    Tambah Mata Pelajaran</button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapel as $item)
                                        <tr>
                                            <td style="width: 10px">{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_mapel }}</td>
                                            <td style="width:40px">
                                                <button onclick="edit_data({{ $item->id }})"
                                                    class="btn btn-warning
                                                    btn-xs"><i
                                                        class="fa fa-edit"></i></button>
                                                <button onclick="delete_data({{ $item->id }})"
                                                    class="btn btn-danger
                                                    btn-xs"><i
                                                        class="fa fa-trash"></i></button>
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
                    <form enctype="multipart/form-data" id="form-add" action="{{ route('mapel-add') }}" method="POST">
                        <div class="mb-3">
                            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                                placeholder="Masukkan Nama Mata Pelajaran">
                            <span class="e-nama_mapel text-error"></span>
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
        show_modal = () => {
            $('.modal-add-title').text('Tambah Materi Pelajaran');
            $('#modal-add').modal('show');
        }

        edit_data = (id) => {
            sessionStorage.setItem('id_kelas', id);
            sessionStorage.setItem('jenis', 'update');
            data_guru(() => {
                $.ajax({
                    type: "GET",
                    url: `${BASE_URL}/mapel/mapel-edit/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        $('#nama_mapel').val(response.data.nama_mapel);
                        $('.modal-add-title').text('Edit Kelas');
                        $('#modal-add').modal('show');
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
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
                        nama_mapel: $("#nama_mapel").val(),
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == true) {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Mapel Berhasil Disimpan`,
                                `Okay`,
                            );
                            $('#modal-add').modal('hide');
                            location.reload();
                        } else {
                            console.log('disini');

                            $.each(response.errors, function(key, value) {
                                $(`.e-${key}`).text(value[0]);
                            });
                            Notiflix.Report.failure(
                                `Kesalahan`,
                                `Data Mapel Gagal Disimpan`,
                                `Okay`,
                            );
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
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
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `${BASE_URL}/mapel/mapel/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Berhasil`,
                                    `Data Kelas Berhasil Dihapus`,
                                    `Okay`,
                                );
                                // location.reload();
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
