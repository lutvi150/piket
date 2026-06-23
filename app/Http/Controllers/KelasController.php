<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Kelas";
        $kelas = KelasModel::withCount('siswa')->get();
        return view('kelas.index', compact("kelas", "title"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->jenis == 'store') {
            $kelas = KelasModel::create([
                'nama_kelas' => $request->nama_kelas,
                'id_guru' => $request->id_guru
            ]);
        } else {
            $kelas = KelasModel::findOrFail($request->id);
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'id_guru' => $request->id_guru
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.',
            'data' => $kelas,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KelasModel $kelasModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasModel $kelasModel)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data kelas berhasil diambil.',
            'data' => $kelasModel
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KelasModel $kelasModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelasModel $kelasModel, $id)
    {
        $kelas = KelasModel::find($id);
        if ($kelas) {
            // Hapus siswa yang terkait dengan kelas ini
            SiswaModel::where('id_kelas', $id)->delete();
            // Hapus kelas
            $kelas->delete();
            return response()->json([
                'status' => true,
                'message' => 'Kelas berhasil dihapus.',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }
    }
}
