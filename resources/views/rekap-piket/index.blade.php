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
                                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                        name="tanggal_piket" id="tanggal_piket" aria-describedby="emailHelpId"
                                        placeholder="">
                                    <small id="emailHelpId" class="form-text text-muted text-error e-tangal_piket"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if (auth()->user()->hasRole(['admin', 'guru_piket']))
                                    <button class="btn-success btn-xs" onclick="modalAdd('guru')"><i
                                            class="fa fa-plus small"></i>
                                        Tambah Guru</button>
                                    <button class="btn-success btn-xs" onclick="modalAdd('siswa')"><i
                                            class="fa fa-plus small"></i>
                                        Tambah Siswa</button>
                                    <button type="button" class="btn-warning btn-xs" onclick="printLaporan()"><i
                                            class="fa fa-print small"></i>
                                        Print Laporan</button>
                                @endif
                            </div>
                            <table id="show-data-guru" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Guru</th>
                                        <th>Mapel</th>
                                        <th>Kelas</th>
                                        <th>Jam Ke-</th>
                                        <th>Terlambat</th>
                                        <th>Tidak Hadir (Sakit,Izin,Alpa)</th>
                                        <th>Keterangan</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br>
                            <table id="show-data-siswa" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Status (Sakit,Izin,Alpa,Terlambat)</th>
                                        <th>Kelas</th>
                                        <th>Mapel</th>
                                        <th>Jam Ke-</th>
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
                    <h5 class="modal-add-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="form-guru" method="post">
                        <input type="hidden" id="id_guru" name="piket_id">
                        <input type="hidden" id="jenis_piket" name="jenis" value="guru">
                        <div class="form-group cari-guru">
                            <label for="">Cari Guru</label>
                            <input type="text" name="cari_guru" id="cari_guru" class="form-control"
                                placeholder="Nama Guru" aria-describedby="helpId">
                            <ul id="result_guru" class="list-group"></ul>
                            <small id="helpId" class="text-muted text-error e-piket_id"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Guru</label>
                            <input type="text" name="nama_guru" readonly id="nama_guru" class="form-control"
                                placeholder="Nama Guru" aria-describedby="helpId">
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas</label>
                            <select name="id_kelas_guru" id="id_kelas_guru" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted text-error e-id_kelas"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted text-error e-id_mapel"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="S">Sakit</option>
                                <option value="I">Izin</option>
                                <option value="A">Alfa</option>
                            </select>
                            <small id="helpId" class="text-muted text-error e-status"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran" class="form-control" readonly>
                            <small id="helpId" class="text-muted text-error e-lampiran"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store-button"
                        onclick="store_data('guru')">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddSiswa" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-add-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="form-siswa" method="post">
                        <input type="hidden" id="id_siswa" name="piket_id">
                        <input type="hidden" id="jenis_piket" name="jenis" value="siswa">
                        <input type="hidden" id="id_kelas" name="id_kelas">
                        <div class="form-group cari-siswa">
                            <label for="">Cari Siswa</label>
                            <input type="text" name="cari_siswa" id="cari_siswa" class="form-control"
                                placeholder="Nama Siswa" aria-describedby="helpId">
                            <ul id="result_siswa" class="list-group"></ul>
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Siswa</label>
                            <input type="text" name="nama_siswa" readonly id="nama_siswa" class="form-control"
                                placeholder="Nama Siswa" aria-describedby="helpId">
                            <ul id="result" class="list-group"></ul>
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="">NISN</label>
                            <input type="text" name="nisn" id="nisn" class="form-control" placeholder="NISN"
                                readonly aria-describedby="helpId">
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" readonly>
                            <small id="helpId" class="text-muted text-error e-kelas"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <select name="id_mapel" id="id_mapel" class="form-control">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <small id="helpId" class="text-muted text-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="S">Sakit</option>
                                <option value="I">Izin</option>
                                <option value="A">Alfa</option>
                            </select>
                            <small id="helpId" class="text-muted text-error e-status"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran" class="form-control" readonly>
                            <small id="helpId" class="text-muted text-error e-lampiran"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                            <small id="helpId" class="text-muted text-error e-keterangan"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store-button"
                        onclick="store_data('siswa')">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- modal print --}}
    <div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Laporan</h5>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <!-- Laporan Guru -->
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-user"></i> Laporan Piket Guru
                                    </h3>
                                </div>

                                <div class="box-body text-center">
                                    <p class="text-muted">
                                        Cetak laporan rekap piket guru berdasarkan periode yang dipilih.
                                    </p>

                                    <button type="button" class="btn btn-primary btn-lg" onclick="printLaporan('guru')">
                                        <i class="fa fa-print"></i>
                                        Cetak Laporan Guru
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Siswa -->
                        <div class="col-md-6">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-graduation-cap"></i> Laporan Piket Siswa
                                    </h3>
                                </div>

                                <div class="box-body text-center">
                                    <p class="text-muted">
                                        Cetak laporan rekap piket siswa berdasarkan periode yang dipilih.
                                    </p>

                                    <button type="button" class="btn btn-success btn-lg"
                                        onclick="printLaporan('siswa')">
                                        <i class="fa fa-print"></i>
                                        Cetak Laporan Siswa
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
        $(function() {
            get_data('siswa');
            get_data('guru');
            $('#tanggal_piket').on('change', function() {
                get_data('siswa');
                get_data('guru');
            });
        });
        let timer;
        $("#cari_siswa").on("keyup", function() {
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
                            html += `<li class="list-group-item select-item" data-id="${item.id}" data-nama_siswa="${item.nama_siswa}" data-nisn="${item.nisn}" data-id_kelas="${item.kelas.id}" data-kelas="${item.kelas.nama_kelas}">
                            ${item.nama_siswa} || ${item.nisn}
                         </li>`;
                        });

                        $("#result_siswa").html(html);
                    }
                });
            }, 300);
        }, );
        $(document).on("click", ".select-item", function() {
            $("#search").val($(this).text());
            $("#id_siswa").val($(this).data("id"));
            $("#id_kelas").val($(this).data("id_kelas"));
            $("#nisn").val($(this).data("nisn"));
            $("#kelas").val($(this).data("kelas"));
            $("#nama_siswa").val($(this).data("nama_siswa"));
            $("#result").html("");
        });
        $("#cari_guru").on("keyup", function() {
            clearTimeout(timer);
            let query = $(this).val();
            timer = setTimeout(function() {
                if (query.length < 2) return;
                $.ajax({
                    url: `${BASE_URL}/api/guru/search`,
                    type: "GET",
                    data: {
                        q: query
                    },
                    success: function(response) {
                        let html = "";

                        response.data.forEach(function(item) {
                            html += `<li class="list-group-item select-item-guru" data-id="${item.id}" data-nama_guru="${item.nama_guru}">
                            ${item.nama_guru} || ${item.nip}
                         </li>`;
                        });

                        $("#result_guru").html(html);
                    }
                });
            }, 300);
        }, );
        $(document).on("click", ".select-item-guru", function() {
            $("#search_guru").val($(this).text());
            $("#id_guru").val($(this).data("id"));
            $("#nama_guru").val($(this).data("nama_guru"));
            $("#result_guru").html("");
        });
        get_data = (jenis) => {
            let tanggal_piket = $("#tanggal_piket").val();
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/rekap-piket`,
                data: {
                    tanggal: tanggal_piket,
                    jenis: jenis,
                },
                dataType: "JSON",
                success: function(response) {
                    if (jenis === 'siswa') {
                        show_data_siswa(response.data);
                    } else {
                        show_data_guru(response.data);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
        show_data_guru = (data) => {

            let html = '';
            let badgeStatus = '';
            data.forEach((item, index) => {
                let lampiran = '';
                if (item.lampiran != null) {
                    lampiran =
                        `<a href="${BASE_URL}/uploads/piket/${item.lampiran}" class="btn btn-primary btn-xs" target="_blank"> <i class="fa fa-file"></i> Lampiran</a>`;
                }
                const statusMap = {
                    H: '<span class="label label-success">Hadir</span>',
                    I: '<span class="label label-warning">Izin</span>',
                    S: '<span class="label label-info">Sakit</span>',
                    A: '<span class="label label-danger">Alpha</span>'
                };

                const badgeStatus = statusMap[item.status] ||
                    '<span class="label label-default">-</span>';
                html += `<tr>
                            <td>${index + 1}</td>
                    <td>${item.piket?.nama_guru ?? '-'}</td>
                    <td>${item.mapel?.nama_mapel ?? '-'}</td>
                    <td>${item.kelas?.nama_kelas ?? '-'}</td>
                    <td>${item.jam ?? '-'}</td>
                    <td>${item.jam ?? '-'}</td>
                    <td>${badgeStatus}</td>
                    <td>${item.keterangan ?? '-'}</td>
                            <td>
                                <button class="btn btn-warning btn-xs" onclick="edit_data(${item.id})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-xs" onclick="delete_data(${item.id})">
                                    <i class="fa fa-trash"></i>
                                </button>
                                ${lampiran}
                            </td>
                        </tr>`;
            });
            $(`#show-data-guru tbody`).html(html);
        }
        show_data_siswa = (data) => {
            let html = '';
            let badgeStatus = '';
            data.forEach((item, index) => {
                let lampiran = '';
                if (item.lampiran != null) {
                    lampiran =
                        `<a href="${BASE_URL}/uploads/piket/${item.lampiran}" class="btn btn-primary btn-xs" target="_blank"> <i class="fa fa-file"></i> Lampiran</a>`;
                }
                const statusMap = {
                    H: '<span class="label label-success">Hadir</span>',
                    I: '<span class="label label-warning">Izin</span>',
                    S: '<span class="label label-info">Sakit</span>',
                    A: '<span class="label label-danger">Alpha</span>'
                };

                const badgeStatus = statusMap[item.status] ||
                    '<span class="label label-default">-</span>';
                html += `<tr>
                            <td>${index + 1}</td>
                    <td>${item.piket?.nama_siswa ?? '-'}</td>
                    <td>${badgeStatus}</td>
                    <td>${item.kelas?.nama_kelas ?? '-'}</td>
                    <td>${item.mapel?.nama_mapel ?? '-'}</td>
                    <td>${item.jam ?? '-'}</td>
                    <td>${item.keterangan ?? '-'}</td>
                            <td>
                                <button class="btn btn-warning btn-xs" onclick="edit_data(${item.id})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-xs" onclick="delete_data(${item.id})">
                                    <i class="fa fa-trash"></i>
                                </button>
                                ${lampiran}
                            </td>
                        </tr>`;
            });
            $(`#show-data-siswa tbody`).html(html);
        }
        store_data = (jenis) => {
            const form = jenis === 'siswa' ?
                $('#form-siswa') :
                $('#form-guru');
            $(".store-button").attr('disabled', true).text('Menyimpan...');
            $(".text-error").text('');
            form.ajaxForm({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: form.attr('action'),
                data: {
                    _method: sessionStorage.getItem('TY') == 'POST' ? 'POST' : 'PUT',
                    tanggal: $("#tanggal_piket").val(),
                },
                dataType: "JSON",
                success: function(response) {
                    $(".store-button").removeAttr('disabled').text(sessionStorage.getItem('TY') == 'POST' ?
                        'Simpan' : 'Update');
                    if (response.status == true) {
                        get_data(jenis);
                        setTimeout(() => {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Piket Berhasil Dicatat`,
                                `Okay`,
                            );
                            $("#form-add")[0].reset();
                        }, 500);
                    } else {
                        $.each(response.errors, function(key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Data Piket Gagal Disimpan`,
                            `Okay`,
                        );
                    }
                },
                error: function(xhr) {
                    $(".store-button").removeAttr('disabled').text(sessionStorage.getItem('TY') == 'POST' ?
                        'Simpan' : 'Update');
                    handleAjaxError(xhr);
                }
            }).submit();
        }
        modalAdd = (jenis) => {
            sessionStorage.setItem('TY', 'POST');
            const form = jenis === 'siswa' ?
                $('#form-siswa') :
                $('#form-guru');

            form[0].reset();
            form.attr('action', `${BASE_URL}/api/rekap-piket`);
            $('.text-error').text('');
            $('.modal-add-title').text(`Catat ${jenis}`);
            if (jenis === 'siswa') {
                $(".cari-siswa").removeAttr("hidden");
                $('#modalAddSiswa').modal('show');
            } else {
                $('#modalAddGuru').modal('show');
            }
        }
        edit_data = (id) => {
            sessionStorage.setItem('TY', 'PUT');
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/api/rekap-piket/${id}`,
                dataType: "JSON",
                success: function(response) {
                    const data = response.data;
                    const jenis = data.piket_type.includes("Siswa") ?
                        "siswa" :
                        "guru";

                    const form = jenis === "siswa" ?
                        $("#form-siswa") :
                        $("#form-guru");
                    form[0].reset();
                    form.attr("action", `${BASE_URL}/api/rekap-piket/${id}`);
                    form.find("[name=nama_siswa]").val(data.piket?.nama_siswa ?? '-');
                    form.find("[name=nisn]").val(data.piket?.nisn ?? '-');
                    form.find("[name=kelas]").val(data.kelas?.nama_kelas ?? '-');
                    form.find("[name=piket_id]").val(data.piket_id).trigger("change");
                    form.find("[name=id_kelas]").val(data.kelas_id).trigger("change");
                    form.find("[name=id_mapel]").val(data.mapel_id).trigger("change");
                    form.find("[name=status]").val(data.status);
                    form.find("[name=terlambat]").val(data.terlambat);
                    form.find("[name=keterangan]").val(data.keterangan);
                    $(".text-error").text("");
                    $(".modal-add-title").text(`Edit ${jenis}`);
                    if (jenis === "siswa") {
                        $(".cari-siswa").attr("hidden", true);
                        $("#modalAddSiswa").modal("show");
                    } else {
                        $("#modalAddGuru").modal("show");
                    }
                    get_data(jenis);

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
                        url: `${BASE_URL}/api/rekap-piket/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Data Piket Berhasil Dihapus`,
                                    `Okay`,
                                );
                                get_data(response.data.jenis)
                            } else {
                                Notiflix.Report.failure(
                                    `Gagal`,
                                    `Data  Gagal Dihapus`,
                                    `Okay`,
                                );
                            }
                        },
                        error: function(xhr) {
                            error_function(xhr)
                        }
                    });
                },
                function() {
                    // User clicked "No"
                    Notiflix.Notify.info('Penghapusan dibatalkan.');
                }
            );
        }
        showModalPrint = () => {
            $('#modalPrint').modal('show');
        }
        printLaporan = () => {
            const tanggal = $("#tanggal_piket").val();
            const url = `${BASE_URL}/api/rekap-piket/print?tanggal=${tanggal}`;
            window.open(url, "_blank");
        }
    </script>
@endsection
