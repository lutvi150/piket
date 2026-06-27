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
                            <div style="margin-top:10px">
                                <div class="alert alert-info" role="alert">
                                    <ol>
                                        <li>Untuk menambahkan absen, silakan klik tombol "Buat Absen".</li>
                                    </ol>
                                </div>
                                <button type="button" class="btn btn-success btm-sm" onclick="showModalAbsen()"><i
                                        class="fa fa-plus"></i> Buah Absen</button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mengajar</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
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
                                <label for="">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                                <small id="helpId" class="text-muted text-error e-tanggal">Help text</small>
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
                                <select name="mapel" class="form-control" id="mapel"></select>
                                <small id="helpId" class="text-muted text-error e-mapel">Help text</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Kelas</label>
                                <select name="kelas" class="form-control" id="kelas"></select>
                                <small id="helpId" class="text-muted text-error e-kelas">Help text</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store-button">Simpan</button>
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
            // get_data();
            getKelas();
            getMapel();
        });
        const form = $("#form-absen");
        showModalAbsen = () => {
            sessionStorage.setItem('TY', 'POST');
            form[0].reset();
            form.attr('action', `${BASE_URL}/api/absen-siswa`);
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
                $("#kelas").html(option);
            } catch (error) {
                console.log(error);
                
            }
        }
        conts getMapel=async ()=>{
            try {
                const response= await fetch(`${BASE_URL}/api/mapel`);
                if (!response) {
                    throw new Error("Gagal mengambil data mapel");
                }
                const mapel = await response.json();
                let option = '<option value="">Pilih Mata Pelajaran</option>';
                mapel.forEach(item => {
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
                        get_data(jenis);
                        setTimeout(() => {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Piket Berhasil Dicatat`,
                                `Okay`,
                            );
                            form[0].reset();
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

        get_data = () => {
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
