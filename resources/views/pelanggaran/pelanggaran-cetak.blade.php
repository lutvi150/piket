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

    <h3>REKAPITULASI DAFTAR PELANGGARAN SISWA</h3>

    <p>
        Periode :
        {{ $tanggal_mulai }}
        s/d
        {{ $tanggal_sampai }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Tanggal</th>
                <th>Poin</th>
                <th>Sanksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->jenis_pelanggaran }}</td>
                    <td>{{ $item->tanggal_pelanggaran }}</td>
                    <td>{{ $item->poin }}</td>
                    <td>{{ $item->tindakan_sanksi }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>