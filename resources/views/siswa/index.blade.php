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
                            <h3 class="box-title">Data Siswa</h3>
                            <div style="margin-top:10px">
                                <button onclick="show_modal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>
                                    Tambah Siswa</button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>NIS</th>
                                        {{-- <th>Foto</th> --}}
                                        <th style="width: 40px">Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ strtoupper($item['nama_siswa']) }}</td>
                                            <td><label for="" class="label {{ $item->jenis_kelamin=="L" ? 'label-primary' : 'label-danger' }}">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</label></td>
                                            <td>{{ $item->nisn }}</td>
                                            {{-- <td><img class="foto-siswa" src="{{ asset('assets/images/default.png') }}" alt="" srcset=""></td> --}}
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

    <!-- Modal add -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-add-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="form-add" action="{{ route('siswa-add') }}" method="POST">
                        <div class="mb-3">
                            <label for="nama guru" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                                placeholder="Masukkan Nama Siswa">
                            <span class="e-nama_siswa text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn"
                                placeholder="Masukkan NISN Siswa">
                            <span class="e-nisn text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span class="e-jenis_kelamin text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-control" id="kelas" name="id_kelas">
                                <option value="">Pilih Kelas</option>
                            </select>
                            <span class="e-id_kelas text-error"></span>
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
        $(document).ready(function() {
            get_kelas();
        });
        // data kelas
        get_kelas = () => {
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${BASE_URL}/api/kelas`,
                dataType: "JSON",
                success: function(response) {
                    if (response) {
                        let options = '<option value="">Pilih Kelas</option>';
                        $.each(response, function(key, value) {
                            options += `<option value="${value.id}">${value.nama_kelas}</option>`;
                        });
                        $('#kelas').html(options);
                    }
                }
            });
        }
        show_modal = () => {
            $('.modal-add-title').text('Tambah Data Siswa');
            $('#modal-add').modal('show');
        }
        store_data = () => {
            $(".text-error").text('');
            $("#form-add").ajaxForm({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#form-add").attr('action'),
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `"Data Siswa Berhasil Disimpan." <br/><br/>- Admin`,
                            `Okay`,
                        );
                        $('#modal-add').modal('hide');
                        location.reload();
                    } else {
                        $.each(response.errors, function(key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `"Data Kelas Gagal Disimpan." <br/><br/>- Admin`,
                            `Okay`,
                        );
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            }).submit();
        }
        edit_data = (id) => {
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/siswa/${id}`,
                dataType: "JSON",
                success: function(response) {
                    $('.modal-add-title').text('Edit Data Siswa');
                    $('#nama_siswa').val(response.data.nama_siswa);
                    $('#nisn').val(response.data.nisn);
                    $('#jenis_kelamin').val(response.data.jenis_kelamin);
                    $('#kelas').val(response.data.id_kelas);
                    $('#modal-add').modal('show');
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
                        url: `${BASE_URL}/api/siswa/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Berhasil`,
                                    `"Data Kelas Berhasil Dihapus." <br/><br/>- Admin`,
                                    `Okay`,
                                );
                                location.reload();
                            } else {
                                Notiflix.Report.failure(
                                    `Gagal`,
                                    `"Data Kelas Gagal Dihapus." <br/><br/>- Admin`,
                                    `Okay`,
                                );
                            }
                        },
                        error: function(xhr) {
                            handleAjaxError(xhr);
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
