@extends('layout.template')
@section('content')
    <style>
        .table-super-sm td,
        .table-super-sm th {
            padding: 2px 6px !important;
            vertical-align: middle;
            font-size: 12px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ $title }}
                <small>{{ $title }}</small>
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
                            <h3 class="box-title">{{ $title }}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <button class="btn btn-success btn-sm" onclick="showModalAdd()"><i class="fa fa-plus"></i>
                                Tambah</button>
                            <button class="btn btn-success btn-sm" onclick="showModalGenerate()"><i class="fa fa-refresh"></i> Generate Piket
                                Tahunan</button>
                            <table id="" class="table ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Hari</th>
                                        <th>Piket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Helpers\HariHelper::getAllHari() as $nomor => $hari)
                                        <tr>
                                            {{-- Nomor --}}
                                            <td class="text-center align-middle" style="width: 5%">
                                                {{ $nomor }}
                                            </td>

                                            {{-- Nama Hari --}}
                                            <td class="align-middle" style="width: 20%">
                                                <span class="badge badge-success px-3 py-2">
                                                    {{ $hari }}
                                                </span>
                                            </td>

                                            {{-- Data Guru --}}
                                            <td>
                                                <table class="table table-super-sm small table-borderless mb-0">
                                                    <tbody class="reset-table" id="hari-{{ $nomor }}">

                                                    </tbody>
                                                </table>
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
                    <form enctype="multipart/form-data" id="form-add" action="" method="POST">
                        <div class="mb-3">
                            <label for="hari_piket" class="form-label">Hari Piket</label>
                            <select name="hari_piket" class="form-control" id="hari_piket">
                                <option value="">-- Pilih Hari --</option>
                                @foreach (\App\Helpers\HariHelper::getAllHari() as $nomor => $hari)
                                    <option value="{{ $nomor }}">{{ $hari }}</option>
                                @endforeach
                            </select>
                            <span class="e-hari text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="id_guru" class="form-label">Nama Guru</label>
                            <select name="id_guru" class="form-control" id="id_guru">

                            </select>
                            <span class="e-id_guru text-error"></span>
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
    <!-- Modal -->
    <div class="modal fade" id="modal-generate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Piket Tahunan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('api-piket-generate') }}" method="post">
                        <div class="form-group">
                          <label for="">Pilih Tahun</label>
                          <select name="tahun" class="form-control" id="tahun">
                            <option value="">-- Pilih Tahun --</option>
                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                          </select>
                          <small id="helpId" class="e-tahun text-error"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="generatePiket()">Generate</button>
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
            showDataPiket();
        });
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

        showModalAdd = () => {
            sessionStorage.setItem('TY', 'POST');
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `{{ url('api/piket-tahunan') }}`);
            $('.text-error').text('');
            data_guru(() => {
                $('.modal-add-title').text('Tambah ');
                $('#modal-add').modal('show');
            });
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
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $("#form-add").attr('action'),
                    data: {
                        hari: $("#hari_piket").children("option:selected").val(),
                        id_guru: $("#id_guru").children("option:selected").val(),
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == true) {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Data Piket Tahunan Berhasil Disimpan`,
                                `Okay`,
                            );
                            $('#modal-add').modal('hide');
                            showDataPiket();
                            // location.reload();
                        } else {
                            Notiflix.Report.failure(
                                `Kesalahan`,
                                response.message || `Data Piket Tahunan Gagal Disimpan`,
                                `Okay`,
                            );
                            if (response.errors) {
                                $.each(response.errors, function(key, value) {
                                    $(`.e-${key}`).text(value[0]);
                                });
                            }

                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    }
                });
        }
        showDataPiket = () => {
            $(".reset-table").html('');
            $.ajax({
                type: "GET",
                url: "{{ url('api/piket-tahunan') }}",
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        let nomorHari = {};
                        $.each(response.data, function(i, v) {
                            if (!nomorHari[v.hari]) {
                                nomorHari[v.hari] = 1;
                            }
                            let nomor = nomorHari[v.hari];
                            let html = `
                    <tr id="data-${v.id}">
                        <td class="align-middle">
                            ${nomor}.
                        </td>
                        <td class="align-middle">
                            ${v.guru.nama_guru}
                        </td>
                        <td class="text-end" style="width:1%">
                            <button type="button"
                                class="btn btn-danger btn-xs btn-hapus"
                                data-id="${v.id}" onclick="removeDataPiket(${v.id})">
                                <i class="fa fa-minus small"></i>
                            </button>
                        </td>
                    </tr>
                `;
                            $(`#hari-${v.hari}`).append(html);
                            nomorHari[v.hari]++;

                        });


                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
        removeDataPiket = (id) => {
            $.ajax({
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('api/piket-tahunan/${id}') }}`,
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `Data Piket Tahunan Berhasil Dihapus`,
                            `Okay`,
                        );
                        $(`#data-${id}`).remove();
                    } else {
                        Notiflix.Report.failure(
                            `Gagal`,
                            `Data Piket Tahunan Gagal Dihapus`,
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
        showModalGenerate = () => {
            $('#modal-generate').modal('show');
        }
        generatePiket = () => {
            let tahun = $('#tahun').children("option:selected").val();
            if (!tahun) {
                $('.e-tahun').text('Tahun harus dipilih.');
                return;
            }
                Notiflix.Confirm.show(
                    'Konfirmasi Generate',
                    `Apakah Anda yakin ingin generate piket tahunan untuk tahun ${tahun}? Data piket tahunan yang sudah ada untuk tahun tersebut akan dihapus dan digantikan dengan data baru.`,
                    'Ya',
                    'Tidak',
                    function() {
                        processPiketTahunan(tahun);
                    },
                    function() {
                        // User clicked "No"
                        Notiflix.Notify.info('Generate piket tahunan dibatalkan.');
                    }
                );
           
        }
        processPiketTahunan=(tahun)=>{
            Notiflix.Loading.standard('Sedang memproses...');
             $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('api-piket-generate') }}`,
                data: {
                    tahun: tahun
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `Piket Tahunan untuk tahun ${tahun} berhasil digenerate`,
                            `Okay`,
                        );
                        $('#modal-generate').modal('hide');
                        showDataPiket();
                    } else {
                        Notiflix.Report.failure(
                            `Gagal`,
                            response.message || `Piket Tahunan untuk tahun ${tahun} gagal digenerate`,
                            `Okay`,
                        );
                    }
                    Notiflix.Loading.remove();
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
    </script>
@endsection
