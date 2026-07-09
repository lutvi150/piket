<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use App\Models\Pelanggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'status'           => 'success',
            'dataKelas'        => $kelas->pluck('nama_kelas'),
            'laki'             => $kelas->pluck('laki'),
            'perempuan'        => $kelas->pluck('perempuan'),
            'bulanPelanggaran' => $bulanPelanggaran,
            'tahunPelanggaran' => $tahunPelanggaran,
        ], 200);
    }
    public function grafikKehadiran(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->month;
        $jumlahHari = Carbon::create($tahun, $bulan, 1)->daysInMonth;
        $labels = [];
        $data   = [];

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $labels[] = $i;
            $data[$i] = 0;
        }
        $kehadiran = DB::table('check_absensi')
            ->join('absensi', 'absensi.id', '=', 'check_absensi.id_absensi')
            ->selectRaw('DAY(absensi.tanggal) as hari, COUNT(*) as total')
            ->whereYear('absensi.tanggal', $tahun)
            ->whereMonth('absensi.tanggal', $bulan)
            ->where('check_absensi.status', 'H')
            ->groupBy(DB::raw('DAY(absensi.tanggal)'))
            ->orderBy('hari')
            ->get();

        foreach ($kehadiran as $item) {
            $data[$item->hari] = $item->total;
        }

        return response()->json([
            'labels' => $labels,
            'data'   => array_values($data),
            'request'=>$request->all()
        ]);
    }
    public function grafikPelanggaran(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->month;

        $jumlahHari = Carbon::create($tahun, $bulan, 1)->daysInMonth;
        $labels = range(1, $jumlahHari);
        $data   = array_fill(1, $jumlahHari, 0);
        $pelanggaran = DB::table('pelanggaran')
            ->selectRaw('DAY(tanggal_pelanggaran) as hari, COUNT(*) as total')
            ->whereYear('tanggal_pelanggaran', $tahun)
            ->whereMonth('tanggal_pelanggaran', $bulan)
            ->groupBy(DB::raw('DAY(tanggal_pelanggaran)'))
            ->orderBy('hari')
            ->get();

        foreach ($pelanggaran as $item) {
            $data[$item->hari] = $item->total;
        }

        return response()->json([
            'labels' => $labels,
            'data'   => array_values($data),
            'request'=>$request->all()
        ]);
    }

}
