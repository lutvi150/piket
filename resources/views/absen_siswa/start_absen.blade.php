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

                                <div class="alert alert-danger" role="alert">
                                    <strong>Notifikasi!</strong>
                                    <ul>
                                        <li>Untuk mempercapat Absen dapat menggunakan tombol <button type="button"
                                                onclick="makeAllAbsensi()" class=" btn btn-success btn-sm"><i
                                                    class="fa fa-check"></i> Hadir Semua</button> </li>
                                    </ul>
                                </div>
                                <!-- Tabel -->
                                <div class="table-responsive">
                                    <a href="{{ url('absensi-siswa') }}" class="btn btn-danger btn-sm"><i
                                            class="fa fa-reply"></i> Kembali</a>
                                    <button type="button" class="btn btn-success btn-sm" onclick="makeAllAbsensi()"><i
                                            class="fa fa-check"></i> Hadir Semua</button>
                                    <!-- Toolbar -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-warning btn-xs" onclick="cetakPdf()">
                                                <i class="fa fa-print"></i> Cetak Laporan
                                            </button>
                                        </div>
                                    </div>
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
            get_data();
        });

        get_data = () => {
            const id = window.location.pathname.split('/').pop();
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/absensi-siswa/check-absen/${id}`,
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
                        html += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.nama_siswa}</td>
                            <td>${item.nisn}</td>
                            <td>${item.status}</td>
                            <td>${item.keterangan ?? '-'}</td>
                            <td>
                            ${tombol}
                            ${lampiran}
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

            Notiflix.Confirm.show(
                'Konfirmasi Isi Absen',
                'Apakah Anda yakin?',
                'Ya',
                'Tidak',
                function() {
                    submitAbsen(id, status);
                },
                function() {
                    Notiflix.Notify.info('Absensi dibatalkan.');
                }
            );
        }

        cetakPdf = () => {
            const id = window.location.pathname.split('/').pop();
            window.open(`${BASE_URL}/api/absensi-siswa/cetak-pdf/${id}`, '_blank');
        }
    </script>
@endsection
