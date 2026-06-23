<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PelanggaranRequest;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggaran::with('siswa.kelas')->orderByDesc('created_at');
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
            $query->whereBetween(
                'tanggal_pelanggaran',
                [
                    $request->tanggal_mulai,
                    $request->tanggal_sampai,
                ]
            );
        }

        if ($request->filled('id_siswa')) {
            $query->where('id_siswa', $request->id_siswa);
        }

        $data = $query
            ->orderByDesc('created_at')
            ->get();
        return response()->json([
            'status'  => true,
            'msg'     => 'Data pelanggaran ditemukan',
            'errors'  => null,
            'data'    => $data,
            'content' => null,
        ], 200);
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
    public function store(PelanggaranRequest $request)
    {
        $data        = $request->validated();
        $pelanggaran = Pelanggaran::create([
            'id_siswa'            => $data['id_siswa'],
            'jenis_pelanggaran'   => $data['jenis_pelanggaran'],
            'tanggal_pelanggaran' => $data['tanggal_pelanggaran'],
            'poin'                => $data['poin'],
            'tindakan_sanksi'     => $data['tindakan_sanksi'],
            'keterangan'          => $data['keterangan'],
        ]);
        if ($pelanggaran) {
            return response()->json([
                'status'  => true,
                'msg'     => 'Data pelanggaran berhasil disimpan',
                'errors'  => null,
                'data'    => $pelanggaran,
                'content' => null,
            ], 201);
        } else {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data pelanggaran gagal disimpan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggaran = Pelanggaran::with('siswa')->find($id);
        if ($pelanggaran) {
            return response()->json([
                'status'  => true,
                'msg'     => 'Data pelanggaran ditemukan',
                'errors'  => null,
                'data'    => $pelanggaran,
                'content' => null,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data pelanggaran tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggaran = Pelanggaran::with('siswa')->find($id);
        if ($pelanggaran) {
            return response()->json([
                'status'  => true,
                'msg'     => 'Data pelanggaran ditemukan',
                'errors'  => null,
                'data'    => $pelanggaran,
                'content' => null,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data pelanggaran tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelanggaranRequest $request, string $id)
    {
        $pelanggaran = Pelanggaran::find($id);
        if ($pelanggaran) {
            $data = $request->validated();
            $pelanggaran->update([
                'id_siswa'            => $data['id_siswa'] ?? $pelanggaran->id_siswa,
                'jenis_pelanggaran'   => $data['jenis_pelanggaran'] ?? $pelanggaran->jenis_pelanggaran,
                'tanggal_pelanggaran' => $data['tanggal_pelanggaran'] ?? $pelanggaran->tanggal_pelanggaran,
                'poin'                => $data['poin'] ?? $pelanggaran->poin,
                'tindakan_sanksi'     => $data['tindakan_sanksi'] ?? $pelanggaran->tindakan_sanksi,
                'keterangan'          => $data['keterangan'] ?? $pelanggaran->keterangan,
            ]);
            return response()->json([
                'status'  => true,
                'msg'     => 'Data pelanggaran berhasil diupdate',
                'errors'  => null,
                'data'    => $pelanggaran,
                'content' => null,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data pelanggaran tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggaran = Pelanggaran::find($id);
        if ($pelanggaran) {
            $pelanggaran->delete();
            return response()->json([
                'status'  => true,
                'msg'     => 'Data pelanggaran berhasil dihapus',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data pelanggaran tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }
    }
    public function cetak(Request $request)
    {
        $query = Pelanggaran::with([
            'siswa.kelas',
        ]);

        if (
            $request->filled('tanggal_mulai') &&
            $request->filled('tanggal_sampai')
        ) {
            $query->whereBetween(
                'tanggal_pelanggaran',
                [
                    $request->tanggal_mulai,
                    $request->tanggal_sampai,
                ]
            );
        }

        $data = $query
            ->orderBy('created_at', 'desc')
            ->get();

        $html = view(
            'pelanggaran.pelanggaran-cetak',
            [
                'data'           => $data,
                'tanggal_mulai'  => $request->tanggal_mulai,
                'tanggal_sampai' => $request->tanggal_sampai,
            ]
        )->render();

        $mpdf = new Mpdf([
            'format' => 'A4-L',
        ]);

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output(
                'laporan-pelanggaran.pdf',
                'I'
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
