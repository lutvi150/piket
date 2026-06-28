<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Models\AbsenModel as Absen;
use App\Models\KelasModel as Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $data = $request->validated();
        $kelas = Kelas::withCount('siswa')
            ->findOrFail($data['id_kelas']);
        $absen->update([
            'tanggal'      => $data['tanggal'],
            'jam_masuk'        => $data['masuk'],
            'jam_keluar'       => $data['keluar'],
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
}
