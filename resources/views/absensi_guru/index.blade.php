@extends('layout.template')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Absen Guru
                <small>Absen hanya untuk akun Anda</small>
            </h1>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">

                    <div class="box box-primary" style="border-radius:10px;">

                        <div class="box-body text-center">

                            <img src="{{ $guru->foto_url ?? asset('assets/images/default.png') }}"
                                style="width:80px;height:80px;border-radius:50%;object-fit:cover;">

                            <h4 style="margin-top:10px;">
                                {{ strtoupper($guru->nama_guru) }}
                            </h4>

                            <p>
                                <small>{{ $guru->nip }}</small>
                            </p>

                            {{-- TANGGAL --}}
                            <p>
                                <span class="label label-default">
                                    {{ date('d F Y') }}
                                </span>
                            </p>

                            {{-- STATUS --}}
                            <p id="status">
                                <span class="label label-info">Belum Absen</span>
                            </p>

                            {{-- 2x ABSEN --}}
                            <div class="btn-group btn-group-justified">

                                <a href="javascript:void(0)" onclick="absen('masuk')" class="btn btn-success btn-sm">
                                    <i class="fa fa-sign-in"></i><br>
                                    Masuk
                                </a>

                                <a href="javascript:void(0)" onclick="absen('pulang')" class="btn btn-primary btn-sm">
                                    <i class="fa fa-sign-out"></i><br>
                                    Keluar
                                </a>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>
        <div class="row" style="margin-top:20px;">
    <div class="col-md-12">

        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">History Absen</h3>
            </div>

            <div class="box-body table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Tipe</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- @forelse ($history as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                <td>{{ date('H:i', strtotime($item->created_at)) }}</td>
                                <td>
                                    <span class="label label-primary">
                                        {{ strtoupper($item->tipe) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-success">
                                        OK
                                    </span>
                                </td>
                            </tr>
                        @empty --}}
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data absensi
                                </td>
                            </tr>
                        {{-- @endforelse --}}
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>
    </div>
@endsection
@section('script')
<script>
    function absen(tipe) {
        $.ajax({
            url: "/absen/store",
            type: "POST",
            data: {
                tipe: tipe,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                $("#status").html(
                    '<span class="label label-success">Absen ' + tipe + ' berhasil</span>'
                );
            },
            error: function() {
                alert("Gagal absen");
            }
        });
    }
</script>
@endsection
