<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalPiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PiketController extends Controller
{
    public function index()
    {
        $data = JadwalPiket::with('guru')->get()->map(function ($item) {
            return [
                'title'         => $item->guru->nama_guru,
                'start'         => $item->tanggal,
                'color'=> $item->guru->jenis_kelamin == 'L' ? '#007bff' : '#e83e8c',
                'extendedProps' => [
                    'id' => $item->id,
                    'jenis_kelamin' => $item->guru->jenis_kelamin,
                ],
            ];
        });
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $rule = [
            'tanggal_piket' => 'required',
            'id_guru'       => 'required',
        ];
        $message = [
            'tanggal_piket.required' => 'Tanggal piket harus diisi',
            'id_guru.required'       => 'Guru piket harus diisi',
        ];
        $validator = Validator::make($request->all(), $rule, $message);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak valid',
                'errors'  => $validator->errors(),
            ], 422);
        } else {
            $check = JadwalPiket::where('id_guru', $request->id_guru)->where('tanggal', $request->tanggal_piket)->first();
            if ($check) {
                return response()->json([
                    'status'  => false,
                    'errors'  => ['id_guru' => ['Guru sudah memiliki jadwal piket pada tanggal tersebut']],
                    'message' => 'Data tidak valid',
                ], 422);
            } else {
                JadwalPiket::create([
                    'tanggal' => $request->tanggal_piket,
                    'id_guru' => $request->id_guru,
                ]);
                return response()->json([
                    'status'  => true,
                    'message' => 'Data piket berhasil disimpan',
                ], 200);
            }
        }

    }
    public function show(string $id)
    {
        $piket = JadwalPiket::find($id);
        if ($piket) {
            return response()->json([
                'status'  => true,
                'message' => 'Data piket ditemukan',
                'data'    => $piket,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan',
            ]);
        }
    }
    public function update(Request $request, string $id)
    {
        $rule = [
            'tanggal_piket' => 'required',
            'id_guru'       => 'required',
        ];
        $message = [
            'tanggal_piket.required' => 'Tanggal piket harus diisi',
            'id_guru.required'       => 'Guru piket harus diisi',
        ];
        $validator = Validator::make($request->all(), $rule, $message);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak valid',
                'errors'  => $validator->errors(),
            ]);
        }
        $piket = JadwalPiket::find($id);
        if ($piket) {
            $piket->update([
                'tanggal' => $request->tanggal_piket,
                'id_guru' => $request->id_guru,
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Data piket berhasil diperbarui',
                'data'    => $piket,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data piket tidak ditemukan',
            ]);
        }
    }
    public function destroy(string $id)
    {
        $piket = JadwalPiket::find($id);
        if ($piket) {
            $piket->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data piket berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data piket tidak ditemukan',
            ]);
        }
    }
}
