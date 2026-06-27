<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekapPiketRequest;
use App\Models\GuruModel as Guru;
use App\Models\JadwalPiket;
use App\Models\RekapPiket;
use App\Models\SiswaModel as Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class RekapPiketController extends Controller
{
    public function index(Request $request)
    {
        $piketType = match ($request->jenis) {
            'guru'  => Guru::class,
            'siswa' => Siswa::class,
            default => null,
        };
        $query = RekapPiket::with([
            'kelas',
            'mapel',
            'piket',
        ]);
        if ($piketType) {
            $query->where('piket_type', $piketType);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } elseif ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_sampai,
            ]);
        } else {
            $query->whereDate('tanggal', now()->toDateString());
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status'  => true,
            'msg'     => 'Data rekap piket ditemukan',
            'errors'  => null,
            'data'    => $data,
            'content' => null,
        ], 200);
    }

    public function store(RekapPiketRequest $request)
    {
        $data  = $request->validated();
        $model = match ($data['jenis']) {
            'guru'  => Guru::find($data['piket_id']),
            'siswa' => Siswa::find($data['piket_id']),
            default => null,
        };

        if (! $model) {
            return response()->json([
                'status' => false,
                'msg'    => 'Data tidak ditemukan',
            ], 404);
        }
        if ($request->hasFile('lampiran')) {
            $file            = $request->file('lampiran');
            $filename        = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/piket');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
        }
        $rekapPiket = $model->rekapPiket()->create([
            'tanggal'    => $data['tanggal'],
            'kelas_id'   => $data['id_kelas'] ?? null,
            'mapel_id'   => $data['id_mapel'] ?? null,
            'terlambat'  => $data['terlambat'] ?? 0,
            'status'     => $data['status'],
            'keterangan' => $data['keterangan'] ?? null,
            'lampiran'   => $filename ?? null,
        ]);

        return response()->json([
            'status'  => true,
            'msg'     => 'Data rekap piket berhasil disimpan',
            'data'    => $rekapPiket->load('piket'),
            'data_es' => $data,
        ], 201);
    }
    public function show(string $id)
    {
        $rekap = RekapPiket::with([
            'kelas',
            'mapel',
            'piket',
        ])->find($id);

        if ($rekap) {
            return response()->json([
                'status'  => true,
                'msg'     => 'Data rekap piket ditemukan',
                'errors'  => null,
                'data'    => $rekap,
                'content' => null,
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'msg'     => 'Data rekap piket tidak ditemukan',
            'errors'  => null,
            'data'    => null,
            'content' => null,
        ], 404);
    }

    public function edit(string $id)
    {
        return $this->show($id);
    }

    public function update(RekapPiketRequest $request, string $id)
    {

        $rekapPiket = RekapPiket::find($id);
        if (! $rekapPiket) {
            return response()->json([
                'status'  => false,
                'msg'     => 'Data rekap piket tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }

        $data = $request->validated();
        if ($request->hasFile('lampiran')) {
            if ($rekapPiket->lampiran && file_exists(public_path('uploads/piket/' . $rekapPiket->lampiran))) {
                unlink(public_path('uploads/piket/' . $rekapPiket->lampiran));
            }
            $file            = $request->file('lampiran');
            $filename        = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/piket');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $rekapPiket->lampiran = $filename;
        }
        $rekapPiket->update([
            'tanggal'    => $data['tanggal'] ?? $rekapPiket->tanggal,
            'kelas_id'   => $data['id_kelas'] ?? $rekapPiket->kelas_id,
            'mapel_id'   => $data['id_kelas'] ?? $rekapPiket->mapel_id,
            'terlambat'  => $data['terlambat'] ?? $rekapPiket->terlambat,
            'status'     => $data['status'] ?? $rekapPiket->status,
            'keterangan' => $data['keterangan'] ?? $rekapPiket->keterangan,
            'lampiran'   => $rekapPiket->lampiran,
        ]);

        return response()->json([
            'status'  => true,
            'msg'     => 'Data rekap piket berhasil diupdate',
            'errors'  => null,
            'data'    => $rekapPiket->fresh()->load('piket'),
            'content' => null,
        ], 200);
    }

    public function destroy(string $id)
    {
        $rekap = RekapPiket::find($id);
        if ($rekap) {
            if ($rekap->lampiran && file_exists(public_path('uploads/piket/' . $rekap->lampiran))) {
                unlink(public_path('uploads/piket/' . $rekap->lampiran));
            }
            $jenis = $rekap->piket_type instanceof Siswa ? 'siswa' : 'guru';
            $rekap->delete();

            return response()->json([
                'status'  => true,
                'msg'     => 'Data rekap piket berhasil dihapus',
                'errors'  => null,
                'data'    => [
                    'jenis' => $jenis,
                ],
                'content' => null,
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'msg'     => 'Data rekap piket tidak ditemukan',
            'errors'  => null,
            'data'    => null,
            'content' => null,
        ], 404);
    }
    public function printRekap(Request $request)
    {
        $query = RekapPiket::with([
            'kelas',
            'mapel',
            'piket',
        ]);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } elseif ($request->filled('tanggal_mulai') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_sampai,
            ]);
        } else {
            $query->whereDate('tanggal', now()->toDateString());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query
            ->orderByDesc('created_at')
            ->get();

        $dataGuru = $data->filter(function ($item) {
            return $item->piket_type === Guru::class;
        })->values();

        $dataSiswa = $data->filter(function ($item) {
            return $item->piket_type === Siswa::class;
        })->values();
        $guruPiket = JadwalPiket::where('tanggal', $request->tanggal)->with('guru:id,nama_guru')->get()->pluck('guru.nama_guru');
        Carbon::setLocale('id');
        $html = view('rekap-piket.piket-cetak', [

            'guru'           => $dataGuru,
            'siswa'          => $dataSiswa,
            'guru_piket'=>$guruPiket,
            'kepalaMadrasah' => 'NOPRIZAL, M. Pd',
            'nipKepala'      => '197711092006041006',
            'wakaKurikulum'  => 'RIZA PUSPITA SARI, S. Pd',
            'nipWaka'        => '197607142006042019',
            'tanggal'        => $request->filled('tanggal') ? $request->tanggal : now()->toDateString(),
        ])->render();

        $mpdf = new Mpdf([
            'format' => 'A4-L',
        ]);

        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output('laporan_rekap_piket_siswa.pdf', 'I'),
            200,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
