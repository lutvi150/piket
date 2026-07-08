<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
        }

        table th {
            text-align: center;
        }
    </style>
</head>

<body>
<table style="width:100%; border:none; border-collapse:collapse; margin-bottom:10px;">
    <tr>
        <td style="width:15%; text-align:center; border:none;">
            <img src="{{ public_path('assets/images/logo.jpg') }}" width="100">
        </td>

        <td style="width:70%; text-align:center; border:none; line-height:1.2;">
            <div style="font-size:22px; font-weight:bold;">
                KEMENTERIAN AGAMA REPUBLIK INDONESIA
            </div>

            <div style="font-size:18px; font-weight:bold;">
                KANTOR KEMENTERIAN AGAMA KOTA PADANG
            </div>

            <div style="font-size:17px; font-weight:bold;">
                MADRASAH TSANAWIYAH NEGERI 5 KOTA PADANG
            </div>

            <div style="font-size:13px;">
                Jalan Raya Belimbing Kuranji (25157) Telepon (0751) 4485071
            </div>

            <div style="font-size:13px;">
                Email :
                <span style="color:blue;">
                    mtsn5kuranji@kemenag.go.id /
                    mtsn5padang@gmail.com
                </span>
            </div>
        </td>

        <td style="width:15%; text-align:center; border:none;">
            <img src="{{ public_path('images_sistem/logo.png') }}" width="85">
        </td>
    </tr>
</table>

<hr style="border:1px solid #000; margin-top:5px; margin-bottom:20px;">
    <h3>REKAPITULASI PIKET HARIAN</h3>

    <table class="info">
        <tr>
            <td width="20%">Hari / Tanggal</td>
            <td width="2%">:</td>
            <td>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</td>
        </tr>

        <tr>
            <td style="vertical-align: top;">Guru Piket</td>
            <td style="vertical-align: top;">:</td>
            <td>
                @forelse($guru_piket as $item)
                    {{ $loop->iteration }}.
                    {{ $item ?? '-' }}<br>
                @empty
                    -
                @endforelse
            </td>
        </tr>
    </table>

    <div class="section-title">
        A. Guru yang Tidak Hadir
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="28%">Nama Guru</th>
                <th width="10%">Mapel</th>
                <th width="10%">Kelas</th>
                <th width="10%">Jam Ke-</th>
                <th width="10%">Tidak Hadir(Sakit, Izin, Alpa)</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

            @forelse($guru as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->piket->nama_guru }}</td>
                    <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->jam_ke ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

    <div class="section-title">
        B. Siswa yang Tidak Hadir
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Siswa</th>
                <th width="10%">Status (Sakit, Izin, Alpa, Terlambat)</th>
                <th width="18%">Kelas</th>
                <th width="18%">Mapel</th>
                <th width="10%">Jam Ke</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

            @forelse($siswa as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->piket->nama_siswa }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $item->jam_ke ?? '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <table style="width:100%; border:none; border-collapse:collapse;">
        <tr>
            <td style="width:50%; border:none;"></td>

            <td style="width:50%; border:none; text-align:center;">
                Padang,
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
            </td>
        </tr>

        <tr>
            <td style="width:50%; border:none; text-align:center;">
                Mengetahui,<br>
                Kepala Madrasah
            </td>

            <td style="width:50%; border:none; text-align:center;">
                Wakil Kurikulum<br>
            </td>
        </tr>

        <tr>
            <td style="height:80px; border:none;"></td>
            <td style="border:none;"></td>
        </tr>

        <tr>
            <td style="border:none; text-align:center;">
                <strong><u>{{ $kepalaMadrasah ?? '....................................' }}</u></strong><br>
                NIP. {{ $nipKepala ?? '.................................' }}
            </td>

            <td style="border:none; text-align:center;">
                <strong><u>{{ $wakaKurikulum ?? '....................................' }}</u></strong><br>
                NIP. {{ $nipWaka ?? '.................................' }}
            </td>
        </tr>
    </table>

</body>

</html>
