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
                        <h3 class="card-title">Data Guru</h3> <br>
                        <button class="btn btn-sm btn-success" onclick="show_modal()"><i class="fa fa-plus"></i> Tambah
                            Guru</button>
                    </div> <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped display" id="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Guru</th>
                                    <th>Email</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Foto</th>
                                    <th>Level Akses</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guru as $item)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_guru }}</td>
                                    <td>{{ $item->guru->email }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>
                                        @php
                                        $fotoPath = public_path('uploads/guru/' . $item->foto);
                                        @endphp
                                        @if (empty($item->foto) || !file_exists($fotoPath))
                                        <img src="{{ asset('assets/images/default.png') }}" alt="Foto Guru"
                                            class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                        @else
                                        <img src="{{ asset('uploads/guru/' . $item->foto) }}" alt="Foto Guru"
                                            class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                        @endif
                                    </td>
                                    <td class="">
                                        <button class="btn btn-sm btn-warning" onclick="edit_data({{ $item->id }})">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="delete_data({{ $item->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button class="btn btn-primary btn-sm"
                                            onclick="reset_password({{ $item->id_user }})">
                                            <i class="fa fa-key"></i>
                                        </button>
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

{{-- ubah Password --}}
<div class="modal fade" id="edit-password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama guru" class="form-label">Password Baru</label>
                    <input type="text" class="form-control" id="password" name="password"
                        placeholder="Masukkan Password Baru">
                    <span class="e-password text-error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="store_password()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-add-title">Modal title</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <strong>Informasi</strong>
                    <ul>
                        <li>Isi form dengan benar</li>
                        <li>Pastikan data yang diinput sudah sesuai</li>
                        <li>Jangan menggunakan tanda baca (,) di kolom inputan</li>
                        <li><b>Password akan dibuat otomatis menggunakan NIP</b></li>
                    </ul>
                </div>
                <form enctype="multipart/form-data" id="form-add" action="{{route('guru-add')}}" method="POST">
                    <div class="mb-3">
                        <label for="nama guru" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="nama_guru" name="nama_guru"
                            placeholder="Masukkan Nama Guru">
                        <span class="e-nama_guru text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email guru" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan Email Guru">
                        <span class="e-email text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP Guru">
                        <span class="e-nip text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <span class="e-jenis_kelamin text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"
                            placeholder="Masukkan Alamat Guru"></textarea>
                        <span class="e-alamat text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Masukkan No HP Guru">
                        <span class="e-no_hp text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Masukkan No HP Guru">
                        <span class="e-no_hp text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Level Akses</label>
                        <select name="level_akses" class="form-control" id="level_akses">
                            <option value=""></option>
                        </select>
                        <span class="e-no_hp text-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                        <span class="e-foto text-error"></span>
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
        $("#data-table").DataTable({
            "responsive": true,
            "autoWidth": false,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Tidak ada entri yang tersedia",
                "infoFiltered": "(disaring dari _MAX_ total entri)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
        reset_password = (id) => {
            sessionStorage.setItem('id', id)
            $("#edit-password").modal("show");
        }
        edit_data = (id) => {
            sessionStorage.setItem('id', id);
            sessionStorage.setItem('jenis', 'update')
            $.ajax({
                type: "GET",
                url: `{{ url('admin/guru/${id}/edit') }}`,
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    let data=response.data;
                    $('.modal-add-title').text('Edit Data Guru');
                    $('#nama_guru').val(data.nama_guru);
                    $('#email').val(data.guru.email);
                    $('#nip').val(data.nip);
                    $('#jenis_kelamin').val(data.jenis_kelamin);
                    $('#alamat').val(data.alamat);
                    $('#no_hp').val(data.no_hp);
                    $('#modal-add').modal('show');
                },
                error: function (xhr) {
                    error_function(xhr)
                }
            });
        }
        store_password = () => {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('ubah-password') }}",
                data: {
                    id: sessionStorage.getItem('id'),
                    password: $("#password").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `Password berhasil di ubah`,
                            `Okay`,
                        );
                        $('#edit-password').modal('hide');
                    } else {
                        console.log('disini');

                        // Handle validation errors
                        $.each(response.errors, function (key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Password gagal di ubah`,
                            `Okay`,
                        );
                    }
                },
                error: function (xhr) {
                    error_function(xhr)
                }
            });
        }
        show_modal = () => {
            $("#form-add").trigger("reset");
            sessionStorage.setItem('jenis', 'store');
            $('.modal-add-title').text('Tambah Data Guru');
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
                data:{
                    jenis:sessionStorage.getItem('jenis'),
                    id:sessionStorage.getItem('id'),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `"Data Kelas Berhasil Disimpan`,
                            `Okay`,
                        );
                        $('#modal-add').modal('hide');
                        // Optionally, you can refresh the page or update the table here
                        location.reload();
                    } else {
                        console.log('disini');

                        // Handle validation errors
                        $.each(response.errors, function (key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `"Data Kelas Gagal Disimpan`,
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
                            `"Data tidak ditemukan`,
                            `Okay`,
                        );
                    } else if (status === 500) {
                        Notiflix.Report.failure(
                            `Error 500`,
                            `"Terjadi kesalahan pada server`,
                            `Okay`,
                        );
                    } else {
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `"Terjadi kesalahan tidak diketahui`,
                            `Okay`,
                        );
                    }

                }
            }).submit();
        }
        delete_data = (id) => {
            Notiflix.Confirm.show(
                'Konfirmasi Hapus',
                'Apakah Anda yakin ingin menghapus data ini?',
                'Ya',
                'Tidak',
                function () {
                    $.ajax({
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ url('admin/guru/guru-delete/${id}') }}`,
                        success: function (response) {
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
                        error: function (xhr) {
                            Notiflix.Report.failure(
                                `Kesalahan`,
                                `Terjadi kesalahan saat menghapus data`,
                                `Okay`,
                            );
                        }
                    });
                },
                function () {
                    // User clicked "No"
                    Notiflix.Notify.info('Penghapusan dibatalkan.');
                }
            );
        }
    </script>
    @endsection