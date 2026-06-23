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
                        <h3 class="card-title">Data Absensi</h3>

                        <br>
                        @php
                        $role=Auth::user()->role;
                        @endphp
                        <a href="{{ url($role.'/absensi/buat-absensi/'.$kelas->id) }}"
                            class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                        <button type="button" class="btn btn-success btn-sm"
                            onclick="makeAllAbsensi('{{ $id_absen }}')"><i class="fa fa-check"></i> Hadir Semua</button>
                    </div> <!-- /.card-header -->
                    <div class="card-body p-2">
                        <div class="alert alert-danger" role="alert">
                            <strong>Notifikasi!</strong>
                            <ul>
                                <li>Jika siswa tidak hadir, maka tidak akan dihitung dalam nilai raport.</li>
                                <li>Siswa yang tidak hadir akan di notif ke orang tua melalui whatsapp</li>
                                <li>Untuk mempercapat Absen dapat menggunakan tombol <button type="button"
                                        onclick="makeAllAbsensi('{{ $id_absen }}')" class=" btn btn-success btn-sm"><i
                                            class="fa fa-check"></i> Hadir Semua</button> </li>
                            </ul>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($check as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['nama_siswa'] }}</td>
                                    <td>{{ $item['nisn'] }}</td>
                                    <td> @if ($item['foto'] == null)
                                        <img src="{{ asset('assets/images/default.png') }}" alt="Foto Guru"
                                            class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                        @else
                                        <img src="{{ asset('storage/' . $item['foto']) }}" alt="Foto Guru"
                                            class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                        @endif
                                    </td>
                                    </td>
                                    <td>
                                        @php
                                        $warna = match($item['status']) {
                                        'Hadir' => 'success',
                                        'Sakit' => 'warning',
                                        'Izin' => 'info',
                                        'Alfa' => 'secondary',
                                        default => 'danger',
                                        };
                                        @endphp
                                        <span
                                            class="badge bg-{{ $warna }}">{{ $item['status'] ?? 'Belum Absen' }}</span>
                                    </td>
                                    <td>{{ $item['keterangan'] }}</td>
                                    <td>
                                        <button type="button" onclick="makeAbsensi('{{ $item['id_siswa'] }}','Hadir')"
                                            class="btn btn-sm btn-success"><i class="fa fa-check"></i> Hadir</button>
                                        <button type="button" onclick="makeAbsensi('{{ $item['id_siswa'] }}','Sakit')"
                                            class="btn btn-sm btn-warning"><i class="fa fa-times"></i> Sakit</button>
                                        <button type="button" onclick="makeAbsensi('{{ $item['id_siswa'] }}','Izin')"
                                            class="btn btn-sm btn-info"><i class="fa fa-info-circle"></i> Izin</button>
                                        <button type="button" onclick="makeAbsensi('{{ $item['id_siswa'] }}','Alfa')"
                                            class="btn btn-sm btn-secondary"><i class="fa fa-question"></i>
                                            Alfa</button>
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

</div>

@endsection
@section('script')
<script>
    $(document).ready(function () {
        sessionStorage.setItem('id_kelas', "{{$kelas['id']}}");
        sessionStorage.setItem('id_absensi', "{{ $id_absen }}")
    });
    makeAllAbsensi = (id_absen) => {
        Notiflix.Confirm.show(
            'Konfirmasi Isi Absen',
            'Apakah Anda yakin ingin mengisi absen semua siswa ?',
            'Ya',
            'Tidak',
            function () {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_absensi: id_absen,
                        id_kelas: sessionStorage.getItem('id_kelas')
                    },
                    url: `{{ route('guru-check-absensi-add-all') }}`,
                    success: function (response) {
                        if (response.status == true) {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Absensi Berhasil Di lakukan`,
                                `Okay`,
                            );
                            location.reload();
                        } else {
                            Notiflix.Report.failure(
                                `Absensi Gagal Di lakukan`,
                                `Absensi Sudah Ada`,
                                `Okay`,
                            );
                        }
                    },
                    error: function (xhr) {
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Terjadi kesalahan saat melakukan absensi`,
                            `Okay`,
                        );
                    }
                });
            })
    }
    makeAbsensi = (id, status) => {
        if (status=='Alfa') {
        Notiflix.Confirm.prompt(
            'Absensi Siswa',
'Silahkan Isi Keterangan Alfa Jika Ada',
'Bolos',
'Kirim',
'Batalkan',
            function okCb (clientAnswer) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_siswa: id,
                        status: status,
                        keterangan: clientAnswer,
                        id_absensi: sessionStorage.getItem('id_absensi'),
                        id_kelas: sessionStorage.getItem('id_kelas')
                    },
                    url: `{{ route('guru-check-absensi-add') }}`,
                    success: function (response) {
                        if (response.status == true) {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Absensi Berhasil Di lakukan`,
                                `Okay`,
                            );
                            location.reload();
                        } else {
                            Notiflix.Report.failure(
                                `Absensi Gagal Di lakukan`,
                                `Absensi Sudah Ada`,
                                `Okay`,
                            );
                        }
                    },
                    error: function (xhr) {
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Terjadi kesalahan saat melakukan absensi`,
                            `Okay`,
                        );
                    }
                });
            },
            function cancelCB () {
                // User clicked "No"
                Notiflix.Notify.info('Absensi dibatalkan.');
            }
        );
            
        }else{
        Notiflix.Confirm.show(
            'Konfirmasi Isi Absen',
            'Apakah Anda yakin ingin ?',
            'Ya',
            'Tidak',
            function () {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_siswa: id,
                        status: status,
                        id_absensi: sessionStorage.getItem('id_absensi'),
                        id_kelas: sessionStorage.getItem('id_kelas')
                    },
                    url: `{{ route('guru-check-absensi-add') }}`,
                    success: function (response) {
                        if (response.status == true) {
                            Notiflix.Report.success(
                                `Berhasil`,
                                `Absensi Berhasil Di lakukan`,
                                `Okay`,
                            );
                            location.reload();
                        } else {
                            Notiflix.Report.failure(
                                `Absensi Gagal Di lakukan`,
                                `Absensi Sudah Ada`,
                                `Okay`,
                            );
                        }
                    },
                    error: function (xhr) {
                        Notiflix.Report.failure(
                            `Kesalahan`,
                            `Terjadi kesalahan saat melakukan absensi`,
                            `Okay`,
                        );
                    }
                });
            },
            function () {
                // User clicked "No"
                Notiflix.Notify.info('Absensi dibatalkan.');
            }
        );
    }}
</script>
@endsection