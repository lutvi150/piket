@extends('layout.template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $title }}
                <small> {{ $title }}</small>
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
                            <h3 class="box-title">Data Piket</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            @if (auth()->user()->hasRole(['admin']))
                                <button class="btn btn-success btn-sm" onclick="add_piket()"><i class="fa fa-plus"></i>
                                    Tambah
                                    Piket</button>
                                <a href="{{ route('piket.add-jadwal-tahunan') }}" class="btn btn-success btn-sm"><i
                                        class="fa fa-plus"></i> Tambah Piket Semester</a>
                            @endif
                            <div id="calendar"></div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-piket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form-add" method="post">
                        <div class="form-group">
                            <label for="">Pilih Guru</label>
                            <select name="id_guru" class="form-control" id="id_guru">
                                <option value="">Pilih Guru</option>
                            </select>
                            <small id="helpId" class="text-muted text-error e-id_guru">Help text</small>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Piket</label>
                            <input type="date" name="tanggal_piket" id="tanggal_piket" class="form-control"
                                placeholder="Tanggal Piket" aria-describedby="helpId">
                            <small id="helpId" class="text-muted text-error e-tanggal_piket">Help text</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-minus"></i>
                        Tutup</button>
                    <button type="button" class="btn btn-success" onclick="store_data()"><i class="fa fa-plus"></i>
                        Simpan</button>
                    <button type="button" hidden id="delete-data" class="btn btn-danger" onclick="delete_data()"><i
                            class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endsection
@section('script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        $(document).ready(function() {
            data_guru();
            showCalendar();
        });
        add_piket = () => {
            sessionStorage.setItem('TY', 'POST');
            $("#delete-data").attr('onclick', '').prop('hidden', true);
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `{{ route('api-piket-add') }}`);
            $('.text-error').text('');
            $("#modal-piket .modal-title").text("Tambah Piket");
            $('#modal-piket').modal('show');
        }
        edit_piket = (id) => {
            $("#delete-data").attr('onclick', `delete_data(${id})`).prop('hidden', false);
            sessionStorage.setItem('TY', 'PUT');
            sessionStorage.setItem('id_guru', id);
            data_guru();
            $("#form-add")[0].reset();
            $("#form-add").attr('action', `{{ url('api/piket') }}/${id}`);
            $('.text-error').text('');
            $("#modal-piket .modal-title").text("Edit Piket");
            $.ajax({
                url: `${BASE_URL}/api/piket/${id}`,
                method: 'GET',
                success: function(response) {
                    let data = response.data;
                    $('#id_guru').val(data.id_guru);
                    $('#tanggal_piket').val(data.tanggal);
                    $('#modal-piket').modal('show');
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
        store_data = () => {
            $(".text-error").text('');
            $("#form-add").ajaxForm({
                type: sessionStorage.getItem('TY'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#form-add").attr('action'),
                dataType: "JSON",
                success: function(response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `"Data Piket Berhasil Disimpan." <br/><br/>- Admin`,
                            `Okay`,
                        );
                        $('#modal-add').modal('hide');
                        showCalendar();
                        // location.reload();
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
        data_guru = () => {
            let id_guru = sessionStorage.getItem('id_guru');
            $.ajax({
                url: `${BASE_URL}/api/guru`,
                method: 'GET',
                success: function(response) {
                    let data = response.data;
                    let options = '<option value="">Pilih Guru</option>';
                    data.forEach(guru => {
                        options +=
                            `<option ${id_guru==guru.id?'selected':''} value="${guru.id}">${guru.nip} | ${guru.nama_guru}</option>`;
                    });
                    $('#id_guru').html(options);
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
                        url: `${BASE_URL}/api/piket/${id}`,
                        success: function(response) {
                            if (response.status == true) {
                                Notiflix.Report.success(
                                    `Berhasil`,
                                    `"Data Piket Berhasil Dihapus." <br/><br/>- Admin`,
                                    `Okay`,
                                );
                                $('#modal-piket').modal('hide');
                                showCalendar();
                                // location.reload();
                            } else {
                                Notiflix.Report.failure(
                                    `Gagal`,
                                    `"Data Piket Gagal Dihapus." <br/><br/>- Admin`,
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
        showCalendar = () => {
            //   document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                events: `${BASE_URL}/api/piket`,
                eventClick: function(info) {
                    let id = info.event.extendedProps.id;
                    edit_piket(id);
                    console.log("ID:", id);
                }
            });

            calendar.render();
            // });
        }
    </script>
@endsection
