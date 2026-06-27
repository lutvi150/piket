<?php
namespace App\Http\Controllers;

use App\Models\AbsenModel;
use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = session('data');
        $guru = null;
        if (User::find($user->id)->hasRole([
            'guru_mapel',
            'guru_piket',
            'guru_bk',
            'wali_kelas',
        ])) {
            $guru = GuruModel::where('id_user', $user->id)->first();
        }

        $history = collect([
            (object) [
                'id'         => 1,
                'id_guru'    => 1,
                'tipe'       => 'masuk',
                'created_at' => now()->subHours(5),
            ],
            (object) [
                'id'         => 2,
                'id_guru'    => 1,
                'tipe'       => 'pulang',
                'created_at' => now()->subHours(1),
            ],
            (object) [
                'id'         => 3,
                'id_guru'    => 1,
                'tipe'       => 'masuk',
                'created_at' => now()->subDays(1),
            ],
            (object) [
                'id'         => 4,
                'id_guru'    => 1,
                'tipe'       => 'pulang',
                'created_at' => now()->subDays(1)->addHours(6),
            ],
        ]);

        return view('absensi_guru.index', compact('guru', 'user','history'));
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
    public function show(AbsenModel $absenModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenModel $absenModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AbsenModel $absenModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsenModel $absenModel)
    {
        //
    }
}
