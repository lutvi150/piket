<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Http\Requests\CheckAbsenSiswaRequest;
use App\Models\AbsenModel as Absen;
use App\Models\CheckAbsenModel as CheckAbsen;
use App\Models\KelasModel as Kelas;
use App\Models\RekapPiket;
use App\Models\SiswaModel as Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class AbsenSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Absen::with([
                'kelas',
                'mapel',
            ]);
            if (session('data.role') != 'admin') {
                $query->where('id_guru', session('data.id'));
            }
            $absen = $query
                ->latest('tanggal')
                ->latest('created_at')
                ->get();
            return response()->json([
                'status'  => true,
                'msg'     => 'Data absen berhasil diambil',
                'errors'  => null,
                'data'    => $absen,
                'content' => null,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'  => false,
                'msg'     => 'Data absen gagal diambil',
                'errors'  => $e->getMessage(),
                'data'    => null,
                'content' => null,
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AbsenRequest $request)
    {
        try {
            $data  = $request->validated();
            $kelas = Kelas::withCount('siswa')->findOrFail($data['id_kelas']);
            $absen = Absen::create([
                'tanggal'      => $data['tanggal'],
                'masuk'        => $data['masuk'],
                'keluar'       => $data['keluar'],
                'id_mapel'     => $data['id_mapel'],
                'id_kelas'     => $data['id_kelas'],
                'jumlah_siswa' => $kelas->siswa_count,
                'id_guru'      => session('data.id'),
            ]);
            return response()->json([
                'status'  => true,
                'msg'     => 'Data absen berhasil disimpan',
                'errors'  => null,
                'data'    => $absen,
                'content' => null,
            ], 201);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'  => false,
                'msg'     => 'Data absen gagal disimpan',
                'errors'  => $e->getMessage(),
                'data'    => null,
                'content' => null,
                'session' => session()->all(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $absen = Absen::findOrFail($id);
        return response()->json([
            'status' => true,
            'data'   => $absen,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $absen = Absen::findOrFail($id);
        return response()->json([
            'status' => true,
            'data'   => $absen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AbsenRequest $request, $id)
    {
        try {

            $absen = Absen::findOrFail($id);
            $data  = $request->validated();
            $kelas = Kelas::withCount('siswa')
                ->findOrFail($data['id_kelas']);
            $absen->update([
                'tanggal'      => $data['tanggal'],
                'jam_masuk'    => $data['masuk'],
                'jam_keluar'   => $data['keluar'],
                'id_mapel'     => $data['id_mapel'],
                'id_kelas'     => $data['id_kelas'],
                'jumlah_siswa' => $kelas->siswa_count,
            ]);
            return response()->json([
                'status' => true,
                'msg'    => 'Data berhasil diupdate',
                'data'   => $absen->fresh(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Data tidak ditemukan',
            ], 404);

        } catch (\Throwable $e) {
            Log::error($e);
            return response()->json([
                'status' => false,
                'msg'    => 'Terjadi kesalahan pada server',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absen $id)
    {
        try {
            $absen->delete();
            return response()->json([
                'status'  => true,
                'msg'     => 'Data absen berhasil dihapus',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'  => false,
                'msg'     => 'Data absen gagal dihapus',
                'errors'  => $e->getMessage(),
                'data'    => null,
                'content' => null,
            ], 500);
        }
    }
    public function checkAbsen($id_absen)
    {
        try {
            $absen      = Absen::findOrFail($id_absen);
            $siswa      = Siswa::where('id_kelas', $absen->id_kelas)->get();
            $checkAbsen = CheckAbsen::where('id_absensi', $id_absen)->get()->keyBy('id_siswa');
            $checkPiket = RekapPiket::whereDate('tanggal', $absen->tanggal)->get()->keyBy('piket_id');
            $data       = $siswa->map(function ($item) use ($checkPiket, $checkAbsen) {
                if (isset($checkPiket[$item->id])) {
                    $item->status     = $checkPiket[$item->id]->status;
                    $item->keterangan = $checkPiket[$item->id]->keterangan;
                    $item->lampiran   = $checkPiket[$item->id]->lampiran;
                    $item->sumber     = "P";

                } elseif (isset($checkAbsen[$item->id])) {
                    $item->status     = $checkAbsen[$item->id]->status;
                    $item->keterangan = $checkAbsen[$item->id]->keterangan;
                    $item->lampiran   = $checkAbsen[$item->id]->lampiran;
                    $item->sumber     = "A";
                } else {

                    $item->status     = 'B';
                    $item->keterangan = null;
                    $item->lampiran   = null;
                    $item->sumber     = "B";

                }

                return $item;
            });
            return response()->json([
                'status'  => true,
                'msg'     => 'Data berhasil diambil',
                'errors'  => null,
                'data'    => $data,
                // 'demo'=>$checkPiket,
                'content' => null,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'  => false,
                'msg'     => 'Data absen gagal diambil',
                'errors'  => $e->getMessage(),
                'data'    => null,
                'content' => null,
            ], 500);
        }
    }
    public function storeAbsen(CheckAbsenSiswaRequest $request)
    {
        try {
            $data       = $request->validated();
            $checkAbsen = CheckAbsen::where('id_absensi', $data['id_absensi'])->where('id_siswa', $data['id_siswa'])->first();
            if ($checkAbsen) {
                $updateAbsen = CheckAbsen::where('id_absensi', $data['id_absensi'])->where('id_siswa', $data['id_siswa'])->update([
                    'status'     => $data['status'],
                    'keterangan' => $data['keterangan'],
                ]);
            } else {
                $makeAbsen = CheckAbsen::create([
                    'id_absensi' => $data['id_absensi'],
                    'id_siswa'   => $data['id_siswa'],
                    'status'     => $data['status'],
                    'keterangan' => $data['keterangan'],
                ]);
            }
            return response()->json([
                'status'  => true,
                'msg'     => 'Data absen berhasil disimpan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 201);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status'  => false,
                'msg'     => 'Data absen gagal disimpan',
                'errors'  => $e->getMessage(),
                'data'    => null,
                'content' => null,
                'session' => session()->all(),
            ], 500);
        }
    }
    public function cetakAbsen($id)
    {
        // try {
        $absen      = Absen::findOrFail($id);
        $siswa      = Siswa::where('id_kelas', $absen->id_kelas)->get();
        $checkAbsen = CheckAbsen::where('id_absensi', $id)->get()->keyBy('id_siswa');
        $checkPiket = RekapPiket::whereDate('tanggal', $absen->tanggal)->where('kelas_id', $absen->id_kelas)->where('piket_type', Siswa::class)->get()->keyBy('piket_id');

        $data = $siswa->map(function ($item) use ($checkAbsen, $checkPiket) {
            $statusMap = [
                'H' => 'Hadir',
                'S' => 'Sakit',
                'I' => 'Izin',
                'A' => 'Alfa',
                'B' => 'Belum Absen',
            ];
            if (isset($checkPiket[$item->id])) {
                $status     = $checkPiket[$item->id]->status;
                $keterangan = $checkPiket[$item->id]->keterangan;
            } elseif (isset($checkAbsen[$item->id])) {
                $status     = $checkAbsen[$item->id]->status;
                $keterangan = $checkAbsen[$item->id]->keterangan;
            } else {
                $status     = 'B';
                $keterangan = '-';
            }
            $item->status      = $status;
            $item->status_text = $statusMap[$status] ?? $status;
            $item->keterangan  = $keterangan;
            return $item;
        });
        // $hasil = [
        //     'absen' => $absen,
        //     'data'  => $data,
        // ];return response()->json($hasil);exit;
        $html = view('absen_siswa.absen-cetak', [
            'absen' => $absen,
            'data'  => $data,
        ])->render();
        $mpdf = new Mpdf([
            'format' => 'A4-L',
        ]);
        $mpdf->WriteHTML($html);
        return response(
            $mpdf->Output('laporan-absensi.pdf', 'I'),
            200,
            [
                'Content-Type' => 'application/pdf',
            ]
        );

        // } catch (\Exception $e) {
        // return back()->with('error', $e->getMessage());

        // }
    }
}
