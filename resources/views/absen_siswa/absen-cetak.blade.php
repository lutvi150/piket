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
    <h3>ABSEN SISWA</h3>



    <table>
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->nisn ?? '-' }}</td>
                    <td>{{ $item->status_text}}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width:100%; border:none; border-collapse:collapse;">
        <tr>
            <td style="width:50%; border:none;"></td>

            <td style="width:50%; border:none; text-align:center;">
                Padang,
                {{-- {{ \Carbon\Carbon::parse()->translatedFormat('d F Y') }} --}}
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
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
