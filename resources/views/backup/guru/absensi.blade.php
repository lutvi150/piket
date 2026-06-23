@extends('layout.template')
@section('content')
@php
    $role=Auth::user()->role;
@endphp
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <!-- /.card -->
                <div class="card mb-12">
                    <div class="card-header">
                        <h3 class="card-title">Data Absensi </h3> <br>
                            @php
                                $role=Auth::user()->role;
                            @endphp
                        <a href="{{ url($role.'/absensi') }}" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Kembali</a> 
                        <button type="button" class="btn btn-sm btn-primary" onclick="show_report()"><i class="fa fa-print"></i> Cetak Laporan</button>
                        <button type="button" onclick="show_absensi()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Buat Absen Baru</button>
                    </div> <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Tanggal Absen</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Status Guru</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Nama Guru</th>
                                    <th >Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                    {{$item->tanggal}}
                                    </td>
                                    <td>
                                        {{ date('H:i', strtotime($item->jam_masuk)) }}
                                    </td>
                                    <td>
                                        {{ date('H:i', strtotime($item->jam_keluar)) }}
                                    </td>
                                    <td>
                                        {{ $item->mata_pelajaran }}
                                    </td>
                                    <td>
                                        {{ $item->jumlah_siswa }}
                                    </td>
                                    <td>
                                        {{ $item->guru->nama_guru }}
                                    </td>
                                    <td>
                                        <a href="{{ url($role.'/absensi/check-absensi/'.$kelas->id.'/'.$item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> </a>
                                        @if ($role=='admin')
                                        {{-- <button type="button" class="btn btn-sm btn-success" onclick="delete_edit('{{ $item->id }}')"><i class="fa fa-edit"></i></button> --}}
                                        <button type="button" class="btn btn-sm btn-danger" onclick="delete_data('{{ $item->id }}')"><i class="fa fa-trash"></i></button>
                                        @endif
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
   
    <!-- Modal -->
    <div class="modal fade" id="buat-absensi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title absen-title">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ url($role.'/absensi/buat-absensi') }}" id="form-absensi" enctype="multipart/form-data" target="_blank" method="post">
                        <div class="form-group">
                          <label for="">Tanggal Absen</label>
                          <input type="text" name="tanggal_absen" id="tanggal_absen" class="form-control" placeholder="{{ date('d-m-Y') }}" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-tanggal_absen"></small>
                        </div>
                        <div class="form-group">
                          <label for="">Jam Mulai</label>
                          <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" placeholder="{{ date('H:i') }}" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-jam_mulai"></small>
                        </div>
                        <div class="form-group">
                          <label for="">Jam Selesai</label>
                          <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" placeholder="{{ date('H:i') }}" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-jam_selesai"></small>
                        </div>
                        <div class="form-group">
                          <label for="">Status Guru</label>
                          <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" placeholder="Guru Kelas" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-mata_pelajaran"></small>
                        </div>
                        <div class="form-group">
                          <label for="">Jumlah Siswa</label>
                          <input type="text" name="jumlah_siswa" value="{{ $siswa->count() }}" disabled id="jumlah_siswa" class="form-control" placeholder="{{ $siswa->count() }}" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-jumlah_siswa"></small>
                        </div>
                        <div class="form-group">
                          <label for="">Nama Guru</label>
                          <input type="text" name="nama_guru" disabled value="{{ $kelas->guru->nama_guru }}" id="nama_guru" class="form-control" placeholder="{{ $kelas->guru->nama_guru }}" aria-describedby="helpId">
                          <small id="helpId" class="text-error e-nama_guru"></small>
                        </div>
                        <input type="text" hidden  name="id_guru" value="{{ $kelas->guru->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="store_data()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cetak-bulan-laporan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title laporan-title">Modal title</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url($role.'/absensi/laporan-bulanan') }}" id="form-laporan" method="post"  >
                    <div class="form-group">
                      <label for="">Bulan</label>
                      <select name="bulan" id="bulan" class="form-control">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                        </select>
                      <small id="helpId" class="text-error e-bulan"></small>
                    </div>
                    <div class="form-group">
                      <label for="">Tahun</label>
                      <input type="number" name="tahun" id="tahun" class="form-control" placeholder="{{ date('Y') }}" aria-describedby="helpId">
                      <small id="helpId" class="text-error e-tahun"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="cetak_laporan()">Cetak</button>
            </div>
        </div>
    </div>
</div>
    @endsection
    @section('script')
    <script>
        $(document).ready(function () {
            sessionStorage.setItem('id_kelas', '{{ $kelas->id }}');
        });
        show_report=()=>{
            $('#cetak-bulan-laporan .laporan-title').text("Cetak Laporan Bulanan " + '{{ $kelas->nama_kelas }}');
            $('#cetak-bulan-laporan').modal('show');
        }
        show_absensi=()=>{
            $(".absen-title").text("Buat Absensi Baru " + '{{ $kelas->nama_kelas }}');
            $('#buat-absensi').modal('show');

        }
        cetak_laporan=()=>{
            let url=$("#form-laporan").attr('action');
            let bulan = $('#bulan').val();
            let tahun = $('#tahun').val();
            if(bulan && tahun){
                window.location.href = url +"/"+ bulan + "/" + tahun+ "/"+ sessionStorage.getItem('id_kelas');
            }else{
                alert('Silahkan isi bulan dan tahun');
            }
        }
        store_data=()=>{
            $(".text-error").text('');
            $("#form-absensi").ajaxForm({
                type: "POST",
                url: $("#form-absensi").attr('action'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    id_kelas: sessionStorage.getItem('id_kelas'),
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status == true) {
                        Notiflix.Report.success(
                            `Berhasil`,
                            `Data Kelas Berhasil Disimpan`,
                            `Okay`,
                        );
                        $('#modal-add').modal('hide');
                        location.reload();
                    }else{
                        $.each(response.errors, function (key, value) {
                            $(`.e-${key}`).text(value[0]);
                        });
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Data Kelas Gagal Disimpan`,
                            `Okay`,
                        );
                    }
                    
                },
                error: function (xhr) {
                    error_function(xhr)
                }
            }).submit();
        }

        delete_data = (id) => {
            Notiflix.Confirm.show(
                'Konfirmasi Hapus',
                'Apakah Anda yakin ingin menghapus data ini? menghapus absensi akan menghapus semua data yang terkait dengan absensi ini.',
                'Ya',
                'Tidak',
                function () {
                    $.ajax({
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ url('admin/absensi/${id}') }}`,
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