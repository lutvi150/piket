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
                            <h3 class="box-title">Data Absen</h3>

                            @if (auth()->user()->hasRole(['admin', 'guru_mapel']))
                                <div class="alert alert-info" role="alert" style="margin-top:15px;">
                                    <ol style="margin-bottom:0;">
                                        <li>Untuk menambahkan absen, silakan klik tombol <strong>"Buat Absen"</strong>.</li>
                                    </ol>
                                </div>
                            @endif
                        </div>

                        <div class="box-body">

                            <!-- Filter -->
                            <div class="row" style="margin-bottom:15px;">

                                <div class="col-md-3">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai">
                                </div>

                                <div class="col-md-3">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai">
                                </div>

                                <div class="col-md-3">
                                    <label>Kelas</label>
                                    <select class="form-control kelas" id="kelas">
                                        <option value="">-- Semua Kelas --</option>
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button class="btn btn-primary" onclick="get_data()()">
                                            <i class="fa fa-search"></i> Filter
                                        </button>

                                        <button class="btn btn-default" onclick="resetFilter()">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>

                                        @if (auth()->user()->hasRole(['admin', 'guru_mapel']))
                                            <button type="button" class="btn btn-success pull-right"
                                                onclick="showModalAbsen()">
                                                <i class="fa fa-plus"></i> Buat Absen
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No.</th>

                                        @if (auth()->user()->hasRole(['admin', 'guru_bk', 'wali_kelas']))
                                            <th>Nama Guru</th>
                                        @endif

                                        <th>Tanggal</th>
                                        <th>Jam Mengajar</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th width="120">Menu</th>
                                    </tr>
                                </thead>

                                <tbody id="table-absen">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="buat-absen" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Absen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form-absen" method="post">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" readonly>
                                <small class="text-muted text-error e-tanggal"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Masuk</label>
                                <input type="time" name="masuk" id="masuk" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                                <small id="helpId" class="text-muted text-error e-masuk">Help text</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Keluar</label>
                                <input type="time" name="keluar" id="keluar" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                                <small id="helpId" class="text-muted text-error e-keluar">Help text</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Mata Pelajarasan</label>
                                <select name="id_mapel" class="form-control" id="mapel"></select>
                                <small id="helpId" class="text-muted text-error e-id_mapel">Help text</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kelas</label>
                                <select name="id_kelas" class="form-control kelas" id="kelas"></select>
                                <small id="helpId" class="text-muted text-error e-id_kelas">Help text</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store-button" onclick="store_data()">Simpan</button>
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
        $(function() {
            get_data();
            getKelas();
            getMapel();
        });
        const form = $("#form-absen");
        showModalAbsen = () => {
            sessionStorage.setItem('TY', 'POST');
            form[0].reset();
            form.attr('action', `${BASE_URL}/absensi-siswa`);
            $('.text-error').text('');
            $('.modal-title').text(`Buat Absen Baru`);
            $("#buat-absen").modal("show");
        }
        const getKelas = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/kelas`);
                if (!response) {
                    throw new Error("Gagal mengambil data kelas");
                }
                const kelas = await response.json();
                let option = '<option value="">Pilih Kelas</option>';
                kelas.forEach(item => {
                    option += `
                <option value="${item.id}">
                    ${item.nama_kelas}
                </option>
            `;
                });
                $(".kelas").html(option);
            } catch (error) {
                console.log(error);

            }
        }
        const getMapel = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/mapel`);
                if (!response) {
                    throw new Error("Gagal mengambil data mapel");
                }
                const mapel = await response.json();
                let option = '<option value="">Pilih Mata Pelajaran</option>';
                mapel.data.forEach(item => {
                    option += `
                <option value="${item.id}">
                    ${item.nama_mapel}
                </option>
                }`;
                });
                $("#mapel").html(option);
            } catch (error) {
                console.log(error);

            }
        }
        store_data = () => {
            $(".store-button").attr('disabled', true).text('Menyimpan...');
            $(".text-error").text('');
            form.ajaxForm({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#form-absen").attr('action'),
                data: {
                    _method: sessionStorage.getItem('TY') == 'POST' ? 'POST' : 'PUT',
                },
                dataType: "JSON",
                success: function(response) {
                    $(".store-button").removeAttr('disabled').text(sessionStorage.getItem('TY') == 'POST' ?
                        'Simpan' : 'Update');
                    if (response.status == true) {
                        get_data();
                        setTimeout(() => {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Absen Berhasil Disimpan`,
                                `Okay`,
                            );
                            form[0].reset();
                        }, 500);
                    } else {
                        $.each(response.errors, function(key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Gagal`,
                            `Data Absen Gagal Disimpan`,
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
        const get_data = async () => {
            const showGuru = roles.some(role => ['admin', 'guru_bk', 'wali_kelas'].includes(role));
            const isGuruMapel = roles.includes('guru_mapel');

            const tanggal_mulai = $('#tanggal_mulai').val();
            const tanggal_selesai = $('#tanggal_selesai').val();
            const kelas = $('#kelas').val();

            const params = new URLSearchParams();

            if (tanggal_mulai) params.append('tanggal_mulai', tanggal_mulai);
            if (tanggal_selesai) params.append('tanggal_selesai', tanggal_selesai);
            if (kelas) params.append('kelas', kelas);
            try {
                const response = await fetch(`${BASE_URL}/absensi-siswa-api?${params.toString()}`);
                if (!response.ok) {
                    throw new Error("Gagal mengambil data");
                }
                const result = await response.json();
                let html = '';
                result.data.forEach((item, index) => {

                    html += `
                    <tr>
                        <td>${index + 1}</td>
                        ${showGuru ? `<td>${item.nama_guru ?? '-'}</td>` : ''}
                        <td>${item.tanggal}</td>
                        <td>${item.jam_masuk} - ${item.jam_keluar}</td>
                        <td>${item.kelas.nama_kelas}| <label class="label label-success">${item.jumlah_siswa} orang</label></td>
                        <td>${item.mapel.nama_mapel}</td>
                        <td>
                            <a href="${BASE_URL}/absensi-siswa/start-absen/${item.id}"  class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> ${isGuruMapel ? 'Mulai Absen' : 'Check Absen'}</a>
                               ${isGuruMapel ? `
                                            <a href="#" onclick="edit_data(${item.id})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="#" onclick="delete_data(${item.id})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Hapus</a>`:''}
                        </td>
                        </tr>`
                });
                document.getElementById('table-absen').innerHTML = html;
            } catch (error) {
                console.log(error);
                handleAjaxError(error);
            }
        };
        const resetFilter = () => {
            $('#tanggal_mulai').val('');
            $('#tanggal_selesai').val('');
            $('#kelas').val('');
            get_data();
        };
        const edit_data = async (id) => {
            try {
                sessionStorage.setItem('TY', 'PUT');
                const response = await fetch(`${BASE_URL}/api/absensi-siswa/${id}`);
                if (!response.ok) {
                    throw new Error("Gagal mengambil data");
                }
                const result = await response.json();
                const data = result.data;
                form.attr("action", `${BASE_URL}/api/absensi-siswa/${id}`);
                $(".modal-title").text("Edit Absen");
                $(".text-error").text("");
                $("#tanggal").val(data.tanggal);
                $("#masuk").val(data.jam_masuk);
                $("#keluar").val(data.jam_keluar);
                $("#kelas").val(data.id_kelas).trigger("change");
                $("#mapel").val(data.id_mapel).trigger("change");
                $("#buat-absen").modal("show");
            } catch (error) {
                console.error(error);
                handleAjaxError(error);

            }
        };

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
                        url: `${BASE_URL}/api/absensi-siswa/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Data Absen Berhasil Dihapus`,
                                    `Okay`,
                                );
                                get_data()
                            } else {
                                Notiflix.Report.failure(
                                    `Gagal`,
                                    `Data  Absen Gagal Dihapus`,
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
