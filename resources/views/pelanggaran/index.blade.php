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
                            <h3 class="box-title">Rekap Pelanggaran Tata Tertib </h3>
                            <div style="margin-top:10px">

                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-12 form-pelanggaran" hidden>
                                {{-- form --}}
                                <form role="form" id="form-add" action="" method="POST">
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div class="form-group search-siswa">
                                                <label for="namam_nisn">Nama/NISN</label>
                                                <input type="text" class="form-control" id="search"
                                                    placeholder="Masukkan Nama atau NISN Siswa">
                                                <ul id="result" class="list-group"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <div class="form-gro">
                                                <img style="width: 250px; height: 250px;"
                                                    src="{{ asset('assets/images/default.png') }}"
                                                    class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <input type="hidden" id="id_siswa" name="id_siswa">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Nama Siswa">Nama Siswa</label>
                                                <input type="text" disabled class="form-control" id="nama_siswa"
                                                    placeholder="Nama Siswa">
                                            </div>
                                            <div class="form-group">
                                                <label for="Jenis Pelanggaran">Jenis Pelanggaran</label>
                                                <input type="text" class="form-control" name="jenis_pelanggaran"
                                                    id="jenis_pelanggaran" placeholder="Jenis Pelanggaran">
                                                <span class="e-jenis_pelanggaran text-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Tanggal Pelanggaran">Tanggal Pelanggaran</label>
                                                <input type="date" class="form-control" name="tanggal_pelanggaran"
                                                    id="tanggal_pelanggaran" placeholder="Tanggal Pelanggaran">
                                                <span class="e-tanggal_pelanggaran text-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Poin">Poin</label>
                                                <input type="text" class="form-control" name="poin" id="poin"
                                                    placeholder="Poin">
                                                <span class="e-poin text-error"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="Tindakan/ Sanksi">Tindakan/ Sanksi</label>
                                                <input type="text" class="form-control" name="tindakan_sanksi"
                                                    id="tindakan_sanksi" placeholder="Tindakan/ Sanksi">
                                                <span class="e-tindakan_sanksi text-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="Keterangan">Keterangan</label>
                                                <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
                                                <span class="e-keterangan text-error"></span>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="button" id="store-button" class="btn btn-primary" onclick="store_data()">Catat</button>
                                        <button type="button" onclick="show_table()"
                                            class="btn btn-secondary">Batal</button>
                                    </div>
                                </form>
                                {{-- end form --}}
                            </div>
                            <div class="col-md-12 table-pelanggaran">

                                <!-- Toolbar -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        @if (auth()->user()->hasRole(['admin','guru_piket']))
                                        <button onclick="show_form()" class="btn btn-success btn-xs">
                                            <i class="fa fa-plus"></i> Catat Pelanggaran
                                        </button>
                                        @endif
                                        @if (auth()->user()->hasRole(['admin','guru_bk','wali_kelas']))
                                        <button type="button" class="btn btn-warning btn-xs" onclick="cetakPdf()">
                                            <i class="fa fa-print"></i> Cetak Laporan
                                        </button>
                                        @endif
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row align-items-end">
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" id="tanggal_mulai">
                                                <span class="e-tanggal_mulai text-danger"></span>
                                            </div>

                                            <div class="col-md-4">
                                                <input type="date" class="form-control" id="tanggal_sampai">
                                                <span class="e-tanggal_sampai text-danger"></span>
                                            </div>

                                            <div class="col-md-4">
                                                <button type="button" onclick="filter_data()" class="btn btn-primary">
                                                    <i class="fa fa-search"></i> Filter
                                                </button>

                                                <button onclick="reset_filter()" class="btn btn-secondary">
                                                    <i class="fa fa-refresh"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabel -->
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Jenis Pelanggaran</th>
                                                <th>Tanggal Pelanggaran</th>
                                                <th>Poin</th>
                                                <th>Tindakan / Sanksi</th>
                                                <th>Keterangan</th>
                                                <th width="10%">Menu</th>
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
        // show form
        show_form = () => {
            sessionStorage.setItem('TY', 'POST');
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `${BASE_URL}/api/pelanggaran`);
            $('.text-error').text('');
            $('.form-pelanggaran').removeAttr('hidden');
            $('.table-pelanggaran').attr('hidden', true);
            $("#store-button").text('Catat').removeClass('btn-warning').addClass('btn-primary');
            $(".search-siswa").removeAttr('hidden');
        }
        show_table = () => {
            $('.form-pelanggaran').attr('hidden', true);
            $('.table-pelanggaran').removeAttr('hidden');
        }

        edit_data = (id) => {
            sessionStorage.setItem('TY', 'PUT');
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/pelanggaran/${id}`,
                dataType: "JSON",
                success: function(response) {

                    let data = response.data;
                    $("#form-add").attr('action', `${BASE_URL}/api/pelanggaran/${id}`);
                    $("#id_siswa").val(data.id_siswa);
                    $("#nama_siswa").val(data.siswa.nama_siswa);
                    $("#jenis_pelanggaran").val(data.jenis_pelanggaran);
                    $("#tanggal_pelanggaran").val(data.tanggal_pelanggaran);
                    $("#poin").val(data.poin);
                    $("#tindakan_sanksi").val(data.tindakan_sanksi);
                    $("#keterangan").val(data.keterangan);
                    $('.text-error').text('');
                    $('.form-pelanggaran').removeAttr('hidden');
                    $('.table-pelanggaran').attr('hidden', true);
                    $("#store-button").text('Update').removeClass('btn-primary').addClass('btn-warning');
                    $(".search-siswa").attr('hidden', true);
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
        store_data = () => {
            $("#store-button").attr('disabled', true).text('Menyimpan...');
            $(".text-error").text('');
            $("#form-add").ajaxForm({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#form-add").attr('action'),
                data: {
                    _method: sessionStorage.getItem('TY') == 'POST' ? 'POST' : 'PUT',
                },
                dataType: "JSON",
                success: function(response) {
                    $("#store-button").removeAttr('disabled').text(sessionStorage.getItem('TY') == 'POST' ? 'Catat' : 'Update');
                    if (response.status == true) {
                        setTimeout(() => {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Pelanggaran Berhasil Dicatat`,
                                `Okay`,
                            );
                            $("#form-add")[0].reset();
                            get_data();
                            show_table();
                        }, 500);
                    } else {
                        $.each(response.errors, function(key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Data Pelanggaran Gagal Disimpan`,
                            `Okay`,
                        );
                    }
                },
                error: function(xhr) {
                    $("#store-button").removeAttr('disabled').text(sessionStorage.getItem('TY') == 'POST' ? 'Catat' : 'Update');
                    handleAjaxError(xhr);
                }
            }).submit();
        }
        get_data = () => {
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/pelanggaran`,
                dataType: "JSON",
                success: function(response) {
                    let html = '';
                    response.data.forEach((item, index) => {
                        html += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.siswa.nama_siswa}</td>
                            <td>${item.siswa.kelas.nama_kelas}</td>
                            <td>${item.jenis_pelanggaran}</td>
                            <td>${item.tanggal_pelanggaran}</td>
                            <td>${item.poin}</td>
                            <td>${item.tindakan_sanksi}</td>
                            <td>${item.keterangan}</td>
                            <td>
                                <button class="btn btn-warning btn-xs" onclick="edit_data(${item.id})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-xs" onclick="delete_data(${item.id})">
                                    <i class="fa fa-trash"></i>
                                </button>
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
                        url: `${BASE_URL}/api/pelanggaran/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Berhasil`,
                                    `Data Pelanggaran Berhasil Dihapus`,
                                    `Okay`,
                                );
                                get_data();
                            } else {
                                Notiflix.Report.failure(
                                    `Gagal`,
                                    `Data Pelanggaran Gagal Dihapus`,
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
                    Notiflix.Notify.info('Penghapusan dibatalkan.');
                }
            );
        }
        let timer;
        $("#search").on("keyup", function() {
            clearTimeout(timer);
            let query = $(this).val();
            timer = setTimeout(function() {
                if (query.length < 2) return;
                $.ajax({
                    url: `${BASE_URL}/api/siswa/search`,
                    type: "GET",
                    data: {
                        q: query
                    },
                    success: function(response) {
                        let html = "";

                        response.data.forEach(function(item) {
                            html += `<li class="list-group-item select-item" data-id="${item.id}" data-nama="${item.nama_siswa}">
                            ${item.nama_siswa} || ${item.nisn}
                         </li>`;
                        });

                        $("#result").html(html);
                    }
                });
            }, 300);
        }, );
        $(document).on("click", ".select-item", function() {
            $("#search").val($(this).text());
            $("#id_siswa").val($(this).data("id"));
            $("#nama_siswa").val($(this).data("nama"));
            $("#result").html("");
        });
        reset_filter = () => {
            $("#tanggal_mulai").val('');
            $("#tanggal_sampai").val('');
            get_data();
        }
        filter_data=()=>{
            let tanggal_mulai=$("#tanggal_mulai").val();
            let tanggal_sampai=$("#tanggal_sampai").val();
            if(tanggal_mulai == '' || tanggal_sampai == ''){
                if(tanggal_mulai == ''){
                    $(".e-tanggal_mulai").text('Tanggal mulai harus diisi');
                }else{
                    $(".e-tanggal_mulai").text('');
                }
                if(tanggal_sampai == ''){
                    $(".e-tanggal_sampai").text('Tanggal sampai harus diisi');
                }else{
                    $(".e-tanggal_sampai").text('');
                }
                return;
            }else{
                $(".e-tanggal_mulai").text('');
                $(".e-tanggal_sampai").text('');
                $.ajax({
                    url: `${BASE_URL}/api/pelanggaran?tanggal_mulai=${tanggal_mulai}&tanggal_sampai=${tanggal_sampai}`,
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        let html = '';
                        response.data.forEach((item, index) => {
                            html += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.siswa.nama_siswa}</td>
                                <td>${item.siswa.kelas.nama_kelas}</td>
                                <td>${item.jenis_pelanggaran}</td>
                                <td>${item.tanggal_pelanggaran}</td>
                                <td>${item.poin}</td>
                                <td>${item.tindakan_sanksi}</td>
                                <td>${item.keterangan}</td>
                                <td>
                                    <button class="btn btn-warning btn-xs" onclick="edit_data(${item.id})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs" onclick="delete_data(${item.id})">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
        }
        cetakPdf = () => {
            let tanggal_mulai=$("#tanggal_mulai").val();
            let tanggal_sampai=$("#tanggal_sampai").val();
            let url = `${BASE_URL}/api/pelanggaran/cetak?tanggal_mulai=${tanggal_mulai}&tanggal_sampai=${tanggal_sampai}`;
            window.open(url, '_blank');
        }
    </script>
@endsection
