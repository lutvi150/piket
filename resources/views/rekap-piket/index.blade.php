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
                            <h3 class="box-title">Data {{ $title }}</h3>
                            <div class="alert alert-warning" role="alert">
                                <strong>Informasi Piket</strong>
                                <ul>
                                    <li>Silahkan pilih jadwal piket anda</li>
                                </ul>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Pilih Tanggal Piket</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tanggal_piket" id="tanggal_piket"
                                        aria-describedby="emailHelpId" placeholder="">
                                    <small id="emailHelpId" class="form-text text-muted e-tangal_piket"></small>
                                </div>
                            </div>
                          <div class="col-md-12">
                            @if (auth()->user()->hasRole(['admin','guru_piket']))
                              <button class="btn-success btn-xs" onclick="modalAddGuru()"><i class="fa fa-plus small"></i>
                                Tambah Guru</button>
                            <button class="btn-success btn-xs" onclick="modalAddSiswa()"><i class="fa fa-plus small"></i>
                                Tambah Siswa</button>  
                                <button class="btn-warning btn-xs" onclick="printLaporan()"><i class="fa fa-print small"></i>
                                Print Laporan</button>
                            @endif
                          </div>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guru</th>
                                        <th>Mapel</th>
                                        <th>Kelas</th>
                                        <th>Terlambat</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Kelas</th>
                                        <th>Mapel</th>
                                        <th>Jam</th>
                                        <th>Keterangan</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAddGuru" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-guru-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="form-guru" method="post">
                        <div class="form-group">
                            <label for="">Nama Guru</label>
                            <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                                placeholder="Nama Guru" aria-describedby="helpId">
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas</label>
                            <select name="id_kelas" id="id_kelas" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="S">Sakit</option>
                                <option value="I">Izin</option>
                                <option value="A">Alfa</option>
                            </select>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddSiswa" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-guru-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="form-guru" method="post">
                        <div class="form-group">
                            <label for="">NISN</label>
                            <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                                placeholder="NISN" aria-describedby="helpId">
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Siswa</label>
                            <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                                placeholder="Nama Siswa" aria-describedby="helpId">
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" readonly>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="S">Sakit</option>
                                <option value="I">Izin</option>
                                <option value="A">Alfa</option>
                            </select>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Lampiran</label>
                            <input type="file" name="kelas" id="kelas" class="form-control" readonly>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                            <small id="helpId" class="text-muted"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
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
                url: "{{ url('api/guru') }}",
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
        modalAddSiswa=()=>{
            sessionStorage.setItem('TY', 'POST');
            $("#form-guru")[0].reset();
            $("#form-guru").attr('action', `{{ url('api/guru') }}`);
            $('.text-error').text('');
            $('.modal-guru-title').text('Catat Siswa');
            $('#modalAddSiswa').modal('show');
        }
        modalAddGuru = () => {
            sessionStorage.setItem('TY', 'POST');
            $("#form-guru")[0].reset();
            $("#form-guru").attr('action', `{{ url('api/guru') }}`);
            $('.text-error').text('');
            $('.modal-guru-title').text('Catat Guru');
            $('#modalAddGuru').modal('show');
        }

        edit_data = (id) => {
            sessionStorage.setItem('TY', 'PUT');
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `${BASE_URL}/api/kelas/${id}`, );
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
