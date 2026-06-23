<?php

namespace App\Http\Controllers;

use App\Helpers\QRImageWithLogo;
use App\Models\AbsenModel;
use App\Models\CheckAbsensiModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;

class ReportPdf extends Controller
{
    function reportAbsen($bulan, $tahun,$id_kelas)
    {
        $start = microtime(true);
        if ($bulan < 1 || $bulan > 12 || $tahun < 2022) {
            return redirect()->back()->with("error", "");
        }

        $kelas = KelasModel::where('id',$id_kelas)->with('guru')->first();
        $siswa = SiswaModel::where('id_kelas', $id_kelas)->get();
        $tanggalAwal = Carbon::create($tahun, $bulan, 1);
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $tanggalLiburTambahan = [
            "$tahun-$bulan-17",
        ];
        $daftarTanggal = collect();

        while ($tanggalAwal->lte($tanggalAkhir)) {
            $tanggalStr = $tanggalAwal->toDateString();
            $hari = $tanggalAwal->dayOfWeek; // 0 = Minggu, 6 = Sabtu

            $status = in_array($hari, [0, 6]) || in_array($tanggalStr, $tanggalLiburTambahan)
                ? 'Libur'
                : 'Masuk';

            $daftarTanggal->push([
                'tanggal_lengkap' => $tanggalStr,
                'hari' => $tanggalAwal->locale('id')->dayName,
                'tanggal' => $tanggalAwal->day,
                'status' => $status
            ]);

            $tanggalAwal->addDay();
        }
        $dataSiswa = collect();
        $rincianBulan = AbsenModel::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get()->pluck('tanggal');
        foreach ($siswa as $key => $value) {
            $kehadiran = $this->comparekehadiran($value, $daftarTanggal, $rincianBulan);
            $dataSiswa->push([
                'nama' => $value->nama_siswa,
                'id_siswa' => $value->id,
                'kehadiran' => $kehadiran,
                // 'bulan' => $rincianBulan,

            ]);
        }
        $bulan = Carbon::createFromFormat('m', $bulan)->locale('id')->monthName;

        // barcode

        // $qrcode_name = "{$tahun}-{$bulan}-qrcode.png";
        // $logo_instansi = public_path("assets/images/logotutuwuri.jpg");
        // $logo_app = public_path("assets/images/logotutuwuri.png");
        // $logoPath = public_path('assets/images/logotutuwuri.png');
        // $outputPath = public_path("image_sistem/qrcode/{$qrcode_name}");
        // $data_qrcode = url("qrcode/{$bulan}/{$tahun}");

        // // Cek jika QR belum ada, lalu generate
        // if (!File::exists($outputPath)) {
        //     try {
        //         QRImageWithLogo::generateQRCodeWithLogo($data_qrcode, $logoPath, $outputPath);
        //     } catch (\Exception $e) {
        //         // Log error jika ada
        //         logger()->error('QR Code generation failed: ' . $e->getMessage());
        //     }
        // }
        // end barcode
        $data = [
            'bulan' => $bulan . " " . $tahun,
            'siswa' => $dataSiswa,
            // 'rincian_bulan' => $rincianBulan,
            'executing_time' => (microtime(true) - $start),
            'ram_usage' => (memory_get_peak_usage(true) / 1024 / 1024) . 'MB',
        ];
        // return response()->json($data);
        // exit;
        $pdf = PDF::loadView('pdf.absen', compact('data', 'kelas', 'daftarTanggal', 'siswa'))->setPaper('A4', 'landscape');
        return $pdf->stream('absen.pdf');
        // return view('pdf.absen', compact('kelas', 'daftarTanggal', 'siswa'));
    }
    function comparekehadiran($siswa, $daftarTanggal, $rincianBulan)
    {
        $newData = collect();
        $sakit = 0;
        $izin = 0;
        $alpa = 0;
        $tk = 0;
        $hadir = 0;

        foreach ($daftarTanggal as $key => $value) {
            $check = CheckAbsensiModel::join('absensi', 'absensi.id', '=', 'check_absensi.id_absensi')
                ->select('check_absensi.*', 'absensi.tanggal')
                ->get();
            $check = $check->where('id_siswa', $siswa->id)->where('tanggal', $value['tanggal_lengkap'])->first();
            if ($check) {
                $status = $check->status;
                if ($status == 'Sakit') {
                    $kehadiran = 'S';
                    $sakit++;
                } elseif ($status == 'Hadir') {
                    $kehadiran = '&#10003;';
                    $hadir++;
                } elseif ($status == 'Izin') {
                    $kehadiran = 'I';
                    $izin++;
                } elseif ($status == 'Alfa') {
                    $kehadiran = 'X';
                    $alpa++;
                } else {
                    $kehadiran = 'T';
                    $tk++;
                }
            } else {
                $status = '-';
                $kehadiran = '';
            };
            $newData->push([
                'daftar_tanggal' => $value['tanggal_lengkap'],
                'hari' => $value['hari'],
                'tanggal' => $value['tanggal'],
                'status' => $value['status'],
                'kehadiran' => $kehadiran,
            ]);
        }
        $data = [
            'absensi' => $newData,
            's' => $sakit,
            'i' => $izin,
            'a' => $alpa,
            't' => $tk,
            'h' => $hadir,
        ];
        return $data;
    }
    public function replace_location($url)
    {
        $replace = str_replace("e_contract/public", "public_html", $url);
        return $replace;
    }
    public function chartData()
    {
        $kelas = KelasModel::select('id', 'nama_kelas')->get();
        $tahun_absensi = AbsenModel::select(columns: DB::raw('YEAR(tanggal) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get();
        $data = [
            'status' => true,
            'kelas' => $kelas,
            'tahun' => $tahun_absensi,
        ];
        return response()->json($data, 200);
    }
    function chartDataPost(Request $request)
    {

        $id_kelas = $request->id_kelas;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $kelas = KelasModel::where('id', $id_kelas)->first();
        $jumlah_siswa = $kelas->siswa->count();
        $sakit = $this->countAttendance('Sakit', $id_kelas, $tahun, $bulan);
        $izin = $this->countAttendance('Izin', $id_kelas, $tahun, $bulan);
        $alpa = $this->countAttendance('Alfa', $id_kelas, $tahun, $bulan);
        $hadir = $this->countAttendance('Hadir', $id_kelas, $tahun, $bulan);
        $hariEfektif = $this->hariEfektif($bulan, $tahun);
        // persentase
        $persentase_hadir = round(($hadir / ($jumlah_siswa * $hariEfektif)) * 100, 2);
        $persentase_sakit = round(($sakit / ($jumlah_siswa * $hariEfektif)) * 100, 2);
        $persentase_izin = round(($izin / ($jumlah_siswa * $hariEfektif)) * 100, 2);
        $persentase_alpa = round(($alpa / ($jumlah_siswa * $hariEfektif)) * 100, 2);
        $tampa_keterangan = round(((($jumlah_siswa * $hariEfektif) - ($sakit + $izin + $alpa + $hadir)) / ($jumlah_siswa * $hariEfektif)) * 100, 2);
        $data = [
            'status' => 'success',
            'hari' => $hariEfektif,
            // 'data' => [$jumlah_siswa, $hadir, $sakit, $izin, $alpa],
            // 'dataKelas' => ['Jumlah Siswa', 'Hadir', 'Sakit', 'Izin', 'Alfa'],
            'data' => [$jumlah_siswa, $hadir, $sakit, $izin, $alpa],
            'dataKelas' => ['Jumlah Siswa', 'Hadir', 'Sakit', 'Izin', 'Alfa'],
            'bulan' => Carbon::createFromFormat('m', $bulan)->locale('id')->monthName,
            'tahun' => $tahun,
            'nama_kelas' => $kelas->nama_kelas,
            'label_persentase' => ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Tampa Keterangan'],
            'persentase' => [$persentase_hadir, $persentase_sakit, $persentase_izin, $persentase_alpa, $tampa_keterangan],
        ];
        return response()->json(
            $data,
            200
        );
    }
    function countAttendance($status, $id_kelas, $tahun, $bulan)
    {
        $data = CheckAbsensiModel::join('absensi', 'absensi.id', '=', 'check_absensi.id_absensi')->where('status', $status)->where('id_kelas', $id_kelas)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->count();
        return $data;
    }
    function hariEfektif($bulan, $tahun)
    {
        if ($bulan < 1 || $bulan > 12 || $tahun < 2022) {
            return redirect()->back()->with("error", "");
        }

        $kelas = KelasModel::with('guru')->get();
        $siswa = $kelas->flatMap(function ($item) {
            return $item->siswa;
        });
        $tanggalAwal = Carbon::create($tahun, $bulan, 1);
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $tanggalLiburTambahan = [
            "$tahun-$bulan-17",
        ];
        $daftarTanggal = collect();
        $hariEfektif = 0;
        while ($tanggalAwal->lte($tanggalAkhir)) {
            $tanggalStr = $tanggalAwal->toDateString();
            $hari = $tanggalAwal->dayOfWeek; // 0 = Minggu, 6 = Sabtu

            $status = in_array($hari, [0, 6]) || in_array($tanggalStr, $tanggalLiburTambahan)
                ? 'Libur'
                : 'Masuk';

            $daftarTanggal->push([
                'tanggal_lengkap' => $tanggalStr,
                'hari' => $tanggalAwal->locale('id')->dayName,
                'tanggal' => $tanggalAwal->day,
                'status' => $status
            ]);
            if ($status == 'Masuk') {
                $hariEfektif++;
            }
            $tanggalAwal->addDay();
        }
        return $hariEfektif;
    }
}
