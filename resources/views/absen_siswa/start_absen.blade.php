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
                            <h3 class="box-title">Absensi </h3>
                            <div style="margin-top:10px">

                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-12 table-pelanggaran">
                                @if (auth()->user()->hasRole(['guru_mapel']))
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Notifikasi!</strong>
                                        <ul>
                                            <li>Untuk mempercapat Absen dapat menggunakan tombol <button type="button"
                                                    onclick="makeAllAbsensi()" class=" btn btn-success btn-sm"><i
                                                        class="fa fa-check"></i> Hadir Semua</button> </li>
                                        </ul>
                                    </div>
                                @endif
                                <!-- Filter -->
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-6">
                                        <label>&nbsp;</label>
                                        <div>
                                            <a href="{{ url('absensi-siswa') }}" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-reply"></i> Kembali</a>
                                            @if (auth()->user()->hasRole(['guru_mapel']))
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="makeAllAbsensi()"><i class="fa fa-check"></i> Hadir
                                                    Semua</button>
                                            @endif
                                            <button type="button" class="btn btn-warning btn-sm " onclick="cetakPdf()">
                                                <i class="fa fa-print"></i> Cetak Laporan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tabel -->
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Nama Siswa</th>
                                                <th>NISN</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Menu</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
    <div class="modal fade" id="modalLampiran">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Upload Lampiran</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_absen" value="{{ $absen->id }}">
                    <input type="hidden" id="status_absen" value="S">
                    <input type="hidden" id="piket_id">
                    <input type="hidden" id="jenis" value="siswa">
                    <input type="hidden" id="tanggal" value="{{ $absen->tanggal }}">
                    <input type="hidden" id="id_kelas" value="{{ $absen->id_kelas }}">
                    <input type="hidden" id="id_mapel" value="{{ $absen->id_kelas }}">
                    <input type="hidden" id="jam_ke" value="1-8">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="file" class="form-control" id="lampiran" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="submitLampiran()">
                        Simpan
                    </button>
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
        const roles = @json(session('data.role'));
        const id_absen = window.location.pathname.replace(/\/$/, '').split('/').pop();
        $(document).ready(function() {
            get_data();
        });
        get_data = () => {
            const isGuruMapel = roles.includes('guru_mapel');
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/absensi-siswa/check-absen/${id_absen}`,
                dataType: "JSON",
                success: function(response) {
                    let html = '';
                    response.data.forEach((item, index) => {
                        if (item.status == 'H') {
                            item.status = '<span class="label label-success">Hadir</span>';
                        } else if (item.status == 'S') {
                            item.status = '<span class="label label-warning">Sakit</span>';
                        } else if (item.status == 'I') {
                            item.status = '<span class="label label-info">Izin</span>';
                        } else if (item.status == 'A') {
                            item.status = '<span class="label label-danger">Alfa</span>';
                        } else {
                            item.status = '<span class="label label-danger">Belum Absen</span>';
                        }
                        let tombol = "";
                        if (item.sumber == 'B' || item.sumber == 'A') {
                            tombol = `<button type="button" onclick="makeAbsensi(${item.id},'H')"
                                            class="btn btn-sm btn-success"><i class="fa fa-check"></i> Hadir</button>
                                        <button type="button" onclick="makeAbsensi(${item.id},'S')"
                                            class="btn btn-sm btn-warning"><i class="fa fa-times"></i> Sakit</button>
                                        <button type="button" onclick="makeAbsensi(${item.id},'I')"
                                            class="btn btn-sm btn-info"><i class="fa fa-info-circle"></i> Izin</button>
                                        <button type="button" onclick="makeAbsensi(${item.id},'A')"
                                            class="btn btn-sm btn-secondary"><i class="fa fa-question"></i>
                                            Alfa</button>`;
                        }
                        let lampiran = "";
                        if (item.lampiran != null) {
                            lampiran =
                                `<a href="${BASE_URL}/uploads/piket/${item.lampiran}" class="btn btn-primary btn-xs" target="_blank"> <i class="fa fa-file"></i> Lampiran</a>`;
                        }
                        html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama_siswa ? item.nama_siswa.toUpperCase() : '-'}</td>
                            <td>${item.nisn}</td>
                            <td>${item.status}</td>
                            <td>${item.keterangan ?? '-'}</td>
                            <td> ${isGuruMapel ? tombol : ''}${lampiran}
                                </td>
                                </tr>`;
                    });
                    $("#example1 tbody").html(html);
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }

        function submitAbsen(id, status, keterangan = '') {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${BASE_URL}/api/absensi-siswa/check-absen`,
                data: {
                    id_siswa: id,
                    status: status,
                    keterangan: keterangan,
                    id_absensi: window.location.pathname.split('/').pop(),
                    id_kelas: sessionStorage.getItem('id_kelas')
                },
                success: function(response) {
                    if (response.status) {
                        Notiflix.Report.success(
                            'Berhasil',
                            'Absensi berhasil dilakukan',
                            'Okay'
                        );
                        get_data();
                    } else {
                        Notiflix.Report.failure(
                            'Absensi Gagal',
                            'Absensi sudah ada',
                            'Okay'
                        );
                    }
                },
                error: function() {
                    Notiflix.Report.failure(
                        'Kesalahan',
                        'Terjadi kesalahan saat melakukan absensi',
                        'Okay'
                    );
                }
            });
        }
        makeAbsensi = (id, status) => {
            // Alfa hanya keterangan
            if (status === 'Alfa') {
                Notiflix.Confirm.prompt(
                    'Absensi Siswa',
                    'Silahkan isi keterangan Alfa jika ada',
                    'Bolos',
                    'Kirim',
                    'Batalkan',
                    function(clientAnswer) {
                        submitAbsen(id, status, clientAnswer);
                    },
                    function() {
                        Notiflix.Notify.info('Absensi dibatalkan.');
                    }
                );
                return;
            }

            // Sakit / Izin
            // if (status === 'S' || status === 'I') {            
            if (status === 'S') {
                $("#piket_id").val(id);
                $("#modalLampiran").modal("show");
                $("#status_absen").val(status);
                $("#id_absen").val(id);
                return;
            }
            // Hadir
            Notiflix.Confirm.show(
                'Konfirmasi',
                'Apakah Anda yakin?',
                'Ya',
                'Tidak',
                function() {
                    submitAbsen(id, status);
                },
                function() {}
            );
        }

        cetakPdf = () => {
            const id = window.location.pathname.split('/').pop();
            window.open(`${BASE_URL}/api/absensi-siswa/cetak-pdf/${id}`, '_blank');
        }
        const makeAllAbsensi = () => {
            Notiflix.Confirm.show(
                'Konfirmasi',
                'Semua siswa akan ditandai sebagai hadir. Lanjutkan?',
                'Ya, Hadir Semua',
                'Batal',
                async () => {
                        try {
                            const response = await fetch(
                                `${BASE_URL}/api/absensi-siswa/hadir-semua/${id_absen}`, {
                                    method: 'GET',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .content,
                                        'Accept': 'application/json'
                                    }
                                });

                            const result = await response.json();
                            if (!response.ok || !result.status) {
                                throw new Error(result.msg || 'Terjadi kesalahan.');
                            }
                            Notiflix.Notify.success(result.msg);
                            get_data();

                        } catch (error) {
                            console.error(error);
                            Notiflix.Notify.failure(error.message || 'Gagal memproses data.');
                        }
                    },
                    () => {
                        Notiflix.Notify.info('Proses dibatalkan.');
                    }
            );
        };
        submitLampiran = () => {
            let formData = new FormData();
            formData.append('jenis', $("#jenis").val()); // guru / siswa
            formData.append('piket_id', $("#id_absen").val()); // id guru / siswa
            formData.append('tanggal', $("#tanggal").val());
            formData.append('status', $("#status_absen").val());
            let keterangan = $("#keterangan").val();
            if (keterangan) {
                keterangan += " (Diisi oleh guru mapel)";
            }
            formData.append('keterangan', keterangan);
            // jika ada
            if ($("#id_kelas").length) {
                formData.append('id_kelas', $("#id_kelas").val());
            }
            if ($("#id_mapel").length) {
                formData.append('id_mapel', $("#id_mapel").val());
            }
            if ($("#jam_ke").length) {
                formData.append('jam_ke', $("#jam_ke").val());
            }
            if ($("#terlambat").length) {
                formData.append('terlambat', $("#terlambat").val());
            }
            let file = $("#lampiran")[0].files[0];
            if (file) {
                formData.append('lampiran', file);
            }
            let id = $("#piket_id").val();
            let status = $("#status_absen").val();
            $.ajax({
                url: `${BASE_URL}/api/rekap-piket`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".btn-primary").prop('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    $(".btn-primary").prop('disabled', false).text('Simpan');
                    if (response.status) {
                        submitAbsen(id, status);
                        $("#modalLampiran").modal('hide');
                        $("#lampiran").val('');
                        $("#keterangan").val('');
                        Notiflix.Notify.success(response.msg);
                        get_data();
                    } else {
                        Notiflix.Notify.failure(response.msg);
                    }
                },
                error: function(xhr) {
                    $(".btn-primary").prop('disabled', false).text('Simpan');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            Notiflix.Notify.failure(value[0]);
                        });
                    } else {
                        handleAjaxError(xhr);
                    }
                }
            });
        }
    </script>
@endsection
