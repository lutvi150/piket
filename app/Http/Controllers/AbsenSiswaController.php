<?php
namespace App\Http\Controllers;

use App\Models\AbsenSiswaModel;
use App\Http\Requests\AbsenRequest;
use App\Models\KelasModel as Kelas;
use App\Models\AbsenModel as Absen;
use App\Models\SiswaModel as Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsenSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Absen Siswa";
        $kelas = Kelas::withCount('siswa')->get();
        return view('absen_siswa.index', compact("title", "kelas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AbsenRequest $request)
    {
        
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
                'jam_masuk'        => $data['masuk'],
                'jam_keluar'       => $data['keluar'],
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
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AbsenSiswaModel $absenSiswaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenSiswaModel $absenSiswaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AbsenSiswaModel $absenSiswaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsenSiswaModel $absenSiswaModel)
    {
        //
    }
    public function startAbsen($id_absen)
    {
        $title="Absen Siswa";
        $absen = Absen::findOrFail($id_absen);
        return view('absen_siswa.start_absen',compact('absen','title'));
    }
}
