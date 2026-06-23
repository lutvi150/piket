<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PiketTahunan;
use App\Models\JadwalPiket;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PiketTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piketTahunan = PiketTahunan::with('guru')->get();
        $data         = [
            'status'  => true,
            'message' => 'Data piket tahunan berhasil diambil.',
            'data'    => $piketTahunan,
        ];
        return response()->json($data, 200);
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
    public function store(Request $request)
    {
        $rules = [
            'hari'    => 'required|integer',
            'id_guru' => 'required|integer',
        ];
        $messages = [
            'hari.required'    => 'Hari harus diisi.',
            'hari.integer'     => 'Hari harus berupa angka.',
            'id_guru.required' => 'ID guru harus diisi.',
            'id_guru.integer'  => 'ID guru harus berupa angka.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $check = PiketTahunan::where('hari', $request->hari)->where('id_guru', $request->id_guru)->first();
        if ($check) {
            return response()->json([
                'status'  => false,
                'message' => 'Data piket tahunan untuk hari dan guru tersebut sudah ada.',
                'data'    => $check,
            ], 201);
        } else {
            PiketTahunan::create([
                'hari'    => $request->hari,
                'id_guru' => $request->id_guru,
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil disimpan.',
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'hari'    => 'required|integer',
            'id_guru' => 'required|integer',
        ];
        $messages = [
            'hari.required'    => 'Hari harus diisi.',
            'hari.integer'     => 'Hari harus berupa angka.',
            'id_guru.required' => 'ID guru harus diisi.',
            'id_guru.integer'  => 'ID guru harus berupa angka.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        } else {
            $jadwal = PiketTahunan::find($id);
            if ($jadwal) {
                $jadwal->update([
                    'hari'    => $request->hari,
                    'id_guru' => $request->id_guru,
                ]);
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diperbarui.',
                    'data'    => $jadwal,
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
        $jadwal = PiketTahunan::find($id);
        if ($jadwal) {
            $jadwal->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data piket tahunan berhasil dihapus.',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data piket tahunan tidak ditemukan.',
            ], 404);
        }
    }
    public function generatePiketTahunan(Request $request)
    {
        $tahun        = $request->input('tahun');
        $piketTahunan = PiketTahunan::all();
        $libur        = [
            '2026-01-01',
            '2026-02-17',
            '2026-03-19',
            '2026-03-20',
            '2026-04-03',
            '2026-04-06',
            '2026-05-01',
            '2026-05-14',
            '2026-05-26',
            '2026-06-01',
            '2026-06-17',
            '2026-08-17',
            '2026-09-24',
            '2026-12-25',
        ];

        $hasil = [];
        $start = new DateTime("$tahun-01-01");
        $end   = new DateTime(($tahun + 1) . "-01-01");

        $interval = new DateInterval('P1D');
        $periode  = new DatePeriod($start, $interval, $end);

        foreach ($periode as $tanggal) {

            $formatTanggal = $tanggal->format('Y-m-d');

            // 0 = Minggu
            $hariAngka = (int) $tanggal->format('w');

            // Skip minggu
            if ($hariAngka == 0) {
                continue;
            }

            // Skip hari libur
            if (in_array($formatTanggal, $libur)) {
                continue;
            }
            $guruPiket = $piketTahunan->where('hari', $hariAngka);
            // Mapping hari
            foreach ($guruPiket as $guru) {

                $dataInsert[] = [
                    'tanggal'    => $formatTanggal,
                    'id_guru'    => $guru->id_guru,
                    'keterangan' => 'A',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        $deleteCount = JadwalPiket::whereYear('tanggal', $tahun)->delete();
        JadwalPiket::insert($dataInsert);
        return response()->json([
            'status'  => true,
            'total'   => count($dataInsert),
            'message' => 'Data piket berhasil digenerate.',
        ]);
    }
}
