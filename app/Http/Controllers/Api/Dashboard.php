<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use App\Models\Pelanggaran;

class Dashboard extends Controller
{
    public function chartSiswa()
    {
        $kelas       = KelasModel::pluck('nama_kelas');
        $jumlahSiswa = KelasModel::select('kelas.nama_kelas', \DB::raw('COUNT(siswa.id) as jumlah_siswa'))
            ->leftJoin('siswa', 'siswa.id_kelas', '=', 'kelas.id')
            ->groupBy('kelas.nama_kelas')
            ->pluck('jumlah_siswa')
            ->toArray();
        $bulanPelanggaran = Pelanggaran::selectRaw('MONTH(created_at) as bulan')->distinct()->orderBy('bulan')->pluck('bulan');
        $tahunPelanggaran = Pelanggaran::selectRaw('YEAR(created_at) as tahun')->distinct()->orderBy('tahun')->pluck('tahun');
        return response()->json(
            ['status' => 'success',
             'data' => $jumlahSiswa, 
             'dataKelas' => $kelas,
             'bulanPelanggaran'=> $bulanPelanggaran,
             'tahunPelanggaran'=>$tahunPelanggaran,
             ], 200);
    }
}
