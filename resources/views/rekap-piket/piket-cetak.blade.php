```blade
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .title {
            text-align: center;
            line-height: 1.4;
        }

        .title .kementerian {
            font-size: 18px;
            font-weight: bold;
        }

        .title .kantor {
            font-size: 16px;
            font-weight: bold;
        }

        .title .sekolah {
            font-size: 17px;
            font-weight: bold;
        }

        .title .alamat {
            font-size: 11px;
        }

        .line {
            border: 1px solid #000;
            margin: 8px 0 15px;
        }

        h3 {
            text-align: center;
            margin: 0 0 15px;
            text-transform: uppercase;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0 8px;
            background: #efefef;
            padding: 6px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            text-align: center;
            font-weight: bold;
            background: #f5f5f5;
        }

        table.data td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('assets/images/logo.jpg') }}" width="90">
            </td>

            <td width="70%" class="title">
                <div class="kementerian">KEMENTERIAN AGAMA REPUBLIK INDONESIA</div>
                <div class="kantor">KANTOR KEMENTERIAN AGAMA KOTA PADANG</div>
                <div class="sekolah">MADRASAH TSANAWIYAH NEGERI 5 KOTA PADANG</div>
                <div class="alamat">
                    Jalan Raya Belimbing Kuranji (25157)<br>
                    Telp. (0751) 4485071<br>
                    Email : mtsn5kuranji@kemenag.go.id /
                    mtsn5padang@gmail.com
                </div>
            </td>

            <td width="15%" align="center">
                <img src="{{ public_path('images_sistem/logo.png') }}" width="80">
            </td>
        </tr>
    </table>

    <div class="line"></div>

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
                <th width="10%">Status</th>
                <th width="18%">Mata Pelajaran</th>
                <th width="10%">Jam</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

            @forelse($guru as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->piket->nama_guru }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $item->terlambat }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
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
                <th width="10%">Status</th>
                <th width="18%">Kelas</th>
                <th width="18%">Mata Pelajaran</th>
                <th width="10%">Jam</th>
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
                    <td>{{ $item->terlambat }}</td>
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
