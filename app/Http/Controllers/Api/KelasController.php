<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KelasModel::withCount('siswa')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_kelas' => 'required|unique:kelas,nama_kelas|min:3',
        ];
        $messages = [
            'nama_kelas.required' => 'Nama kelas harus diisi.',
            'nama_kelas.unique'   => 'Nama kelas sudah digunakan.',
            'nama_kelas.min'      => 'Nama kelas minimal 3 karakter.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        KelasModel::create([
            'nama_kelas' => $request->nama_kelas,
            'id_guru'    => $request->id_guru,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil disimpan.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = KelasModel::with('guru')->find($id);
        if ($kelas) {
            return response()->json([
                'status'  => true,
                'message' => 'Data kelas ditemukan.',
                'data'    => $kelas,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data kelas tidak ditemukan.',
                'data'    => null,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_kelas' => 'required|min:3',
        ];
        $messages = [
            'nama_kelas.required' => 'Nama kelas harus diisi.',
            'nama_kelas.min'      => 'Nama kelas minimal 3 karakter.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        } else {
            $kelas = KelasModel::find($id);
            if ($kelas) {
                $kelas->update([
                    'nama_kelas' => $request->nama_kelas,
                    'id_guru'    => $request->id_guru,
                ]);
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diperbarui.',
                    'data'    => $kelas,
                ], 200);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data kelas tidak ditemukan.',
                    'data'    => null,
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = KelasModel::find($id);
        if ($kelas) {
            $kelas->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data kelas berhasil dihapus.',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data kelas tidak ditemukan.',
            ], 404);
        }
    }
}
