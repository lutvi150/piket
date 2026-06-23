<?php
namespace App\Http\Controllers;

use App\Models\Piket;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Piket";
        $bulan = [
            '1'  => 'Januari',
            '2'  => 'Februari',
            '3'  => 'Maret',
            '4'  => 'April',
            '5'  => 'Mei',
            '6'  => 'Juni',
            '7'  => 'Juli',
            '8'  => 'Agustus',
            '9'  => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        return view('piket.index', compact('title', 'bulan'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Piket $piket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piket $piket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piket $piket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piket $piket)
    {
        //
    }
    public function piketDetail($bulan, $tahun)
    {
        $title = "Piket Detail";
        $piket = Piket::where('bulan', $bulan)->where('tahun', $tahun)->get();
        if ($piket->isEmpty()) {
            Carbon::setLocale('id');
            $bulan = 1;
            $tahun = 2026;
            $libur = [
                '2026-01-01',
                '2026-01-10',
            ];
            $start  = Carbon::create($tahun, $bulan, 1);
            $end    = $start->copy()->endOfMonth();
            $period = CarbonPeriod::create($start, $end);
            $hasil  = [];
            foreach ($period as $tanggal) {
                $tgl = $tanggal->format('Y-m-d');

                $hasil[] = [
                    'tanggal' => $tgl,
                    'hari'    => $tanggal->translatedFormat('l'), // nama hari
                    'libur'   => in_array($tgl, $libur) ? true : false,
                ];
            }

            // dd($hasil);
        }

        return view('piket.detail',compact('title','piket'));
    }
    function addJadwalTahunan()  {
        $title= "Tambah Jadwal Piket Tahunan";
        
        return view('piket.add-jadwal-tahunan',compact('title'));
    }
}
