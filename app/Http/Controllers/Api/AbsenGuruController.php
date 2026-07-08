<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenGuruRequest;
use App\Models\AbsenGuru;
use Illuminate\Http\Request;
use App\Models\GuruModel as Guru;
use App\Models\JadwalPiket;
use App\Models\RekapPiket;
use App\Models\SiswaModel as Siswa;
use Illuminate\Support\Facades\DB;

class AbsenGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $data = AbsenGuru::where('guru_id', $guru->id)
            ->latest('tanggal')
            ->latest('created_at')
            ->get();
        return response()->json([
            'status' => true,
            'msg' => 'History absensi ditemukan',
            'errors' => null,
            'data' => $data,
            'content' => null,
        ]);
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
    public function store(AbsenGuruRequest $request)
    {
        $today = now();
        $tanggal = $today->toDateString();
        $jam = $today->format('H:i:s');

        $guru = auth()->user()->guru;

        if (!$guru) {
            return response()->json([
                'status' => false,
                'msg' => 'Data guru tidak ditemukan.',
                'errors' => null,
                'data' => null,
                'content' => null,
            ], 404);
        }

        $absen = AbsenGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        // ==========================
        // ABSEN MASUK
        // ==========================
        if (!$absen) {

            DB::transaction(function () use ($guru, $tanggal, $jam) {

                AbsenGuru::create([
                    'guru_id' => $guru->id,
                    'tanggal' => $tanggal,
                    'jam_masuk' => $jam,
                    'status' => 'H',
                ]);

                $guru->rekapPiket()->firstOrCreate(
                    [
                        'tanggal' => $tanggal,
                    ],
                    [
                        'kelas_id' => null,
                        'mapel_id' => null,
                        'terlambat' => 0,
                        'jam_ke' => null,
                        'status' => 'H',
                        'keterangan' => 'Absen masuk melalui aplikasi',
                        'lampiran' => null,
                    ]
                );

            });

            return response()->json([
                'status' => true,
                'msg' => 'Absen masuk berhasil.',
                'errors' => null,
                'data' => [
                    'jam_masuk' => $jam,
                    'jam_keluar' => null,
                ],
                'content' => null,
            ], 201);
        }

        // ==========================
        // SUDAH ABSEN PULANG
        // ==========================
        if ($absen->jam_keluar) {

            return response()->json([
                'status' => false,
                'msg' => 'Anda sudah melakukan absensi hari ini.',
                'errors' => null,
                'data' => null,
                'content' => null,
            ], 422);
        }

        // ==========================
        // ABSEN PULANG
        // ==========================
        $absen->update([
            'jam_keluar' => $jam,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Absen pulang berhasil.',
            'errors' => null,
            'data' => [
                'jam_masuk' => $absen->jam_masuk,
                'jam_keluar' => $jam,
            ],
            'content' => null,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absen = AbsenGuru::with('guru')->find($id);
        if (!$absen) {
            return response()->json(
                [
                    'status' => false,
                    'msg' => 'Data absensi guru tidak ditemukan',
                    'errors' => null,
                    'data' => null,
                    'content' => null,
                ],
                404
            );
        }
        return response()->json(
            [
                'status' => true,
                'msg' => 'Data absensi guru berhasil ditemukan',
                'errors' => null,
                'data' => $absen,
                'content' => null,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $absen = AbsenGuru::find($id);
        if (!$absen) {
            return response()->json(
                [
                    'status' => false,
                    'msg' => 'Data absensi guru tidak ditemukan',
                    'errors' => null,
                    'data' => null,
                    'content' => null,
                ],
                404
            );
        }
        $absen->update($request->validated());
        return response()->json(
            [
                'status' => true,
                'msg' => 'Data absensi guru berhasil diperbarui',
                'errors' => null,
                'data' => $absen->fresh()->load('guru'),
                'content' => null,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absen = AbsenGuru::find($id);
        if (!$absen) {
            return response()->json(
                [
                    'status' => false,
                    'msg' => 'Data absensi guru tidak ditemukan',
                    'errors' => null,
                    'data' => null,
                    'content' => null,
                ],
                404
            );
        }
        $absen->delete();
        return response()->json(
            [
                'status' => true,
                'msg' => 'Data absensi guru berhasil dihapus',
                'errors' => null,
                'data' => null,
                'content' => null,
            ]
        );
    }
    public function checkStatus()
    {
        $guru = auth()->user()->guru;
        if (!$guru) {
            return response()->json([
                'status' => false,
                'msg' => 'Data guru tidak ditemukan.',
                'errors' => null,
                'data' => null,
                'content' => null,
            ], 404);
        }

        $absen = AbsenGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->first();
        return response()->json([
            'status' => true,
            'msg' => 'Status absensi berhasil diambil.',
            'errors' => null,
            'today' => [
                'jam_masuk' => $absen->jam_masuk ?? null,
                'jam_keluar' => $absen->jam_keluar ?? null,
            ],
            'content' => null,
        ]);
    }
}
