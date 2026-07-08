<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenGuruRequest;
use App\Models\AbsenGuru;
use Illuminate\Http\Request;

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

        $idGuru = auth()->user()->guru->id;

        $absen = AbsenGuru::where('guru_id', $idGuru)
            ->whereDate('tanggal', $tanggal)
            ->first();

        // Belum ada data -> Absen Masuk
        if (!$absen) {

            AbsenGuru::create([
                'guru_id' => $idGuru,
                'tanggal' => $tanggal,
                'jam_masuk' => $jam,
                'status' => 'H',
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'Absen masuk berhasil.',
                'errors' => null,
                'data' => null,
                'content' => null,
            ], 201);
        }

        // Sudah pernah absen pulang
        if ($absen->jam_keluar !== null) {

            return response()->json([
                'status' => false,
                'msg' => 'Anda sudah melakukan absen masuk dan pulang hari ini.',
                'errors' => null,
                'data' => null,
                'content' => null,
            ], 422);
        }

        // Absen Pulang (hanya sekali)
        $absen->update([
            'jam_keluar' => $jam,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Absen pulang berhasil.',
            'errors' => null,
            'data' => null,
            'content' => null,
        ], 201);
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
