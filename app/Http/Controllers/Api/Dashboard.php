<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function chartSiswa()
    {
        $kelas = KelasModel::leftJoin('siswa', 'siswa.id_kelas', '=', 'kelas.id')
            ->select(
                'kelas.nama_kelas',
                DB::raw("SUM(CASE WHEN siswa.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as laki"),
                DB::raw("SUM(CASE WHEN siswa.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as perempuan")
            )
            ->groupBy('kelas.id', 'kelas.nama_kelas')
            ->orderBy('kelas.id')
            ->get();

        $bulanPelanggaran = Pelanggaran::selectRaw('MONTH(created_at) as bulan')
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan');

        $tahunPelanggaran = Pelanggaran::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        return response()->json([
            'status' => 'success',
            'dataKelas' => $kelas->pluck('nama_kelas'),
            'laki' => $kelas->pluck('laki'),
            'perempuan' => $kelas->pluck('perempuan'),
            'bulanPelanggaran' => $bulanPelanggaran,
            'tahunPelanggaran' => $tahunPelanggaran,
        ], 200);
    }
}
