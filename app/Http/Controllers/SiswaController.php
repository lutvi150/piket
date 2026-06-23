<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\KelasModel;
use App\Models\OrangtuaModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Siswa";
        $siswa = SiswaModel::with(['kelas'])->select('id', 'id_kelas', 'nama_siswa', 'nisn', 'jenis_kelamin')->get();
        return view('siswa.index', compact("siswa", "title"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Siswa";
        $kelas = KelasModel::all();
        return view('admin.tambah_siswa', compact("title", "kelas"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiswaRequest $request)
    {
        $data=$request->validated();
        $siswa = SiswaModel::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil disimpan.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SiswaModel $siswaModel, $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiswaModel $siswaModel)
    {
        $siswa = SiswaModel::find($siswaModel->id);
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
    public function update(Request $request, SiswaModel $siswaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiswaModel $siswaModel)
    {
        try {
            DB::transaction(function () use ($siswaModel) {
                // Cek dan hapus orang tua jika ada
                $orangTua = OrangtuaModel::where('id_siswa', $siswaModel->id)->first();
                if ($orangTua) {
                    $orangTua->delete();
                }

                // Hapus siswa
                $siswaModel->delete();
            });

            return response()->json([
                'status'  => true,
                'message' => 'Data siswa berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data siswa.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
