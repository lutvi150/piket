<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiswaModel;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = SiswaModel::with('kelas')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data siswa ditemukan',
            'errors'  => null,
            'data'    => $siswa,
            'content' => null,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = SiswaModel::find($id);
        if ($siswa) {
            return response()->json([
                'status'  => true,
                'message' => 'Data siswa ditemukan.',
                'data'    => $siswa,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $siswa = SiswaModel::find($id);
            if (! $siswa) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data siswa tidak ditemukan.',
                ], 404);
            }
            $siswa->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data siswa berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data siswa.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function search(Request $request)
    {
        $query = $request->q;
        $siswa = SiswaModel::with('kelas')->where('nama_siswa', 'like', '%' . $query . '%')->limit(10)->get(['id', 'nama_siswa', 'nisn','id_kelas']);
        return response()->json([
            'status'  => true,
            'message' => 'Pencarian berhasil.',
            'data'    => $siswa,
        ], 200);
    }
}
