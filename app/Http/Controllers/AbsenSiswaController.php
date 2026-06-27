<?php
namespace App\Http\Controllers;

use App\Models\AbsenSiswaModel;
use App\Models\KelasModel;
use Illuminate\Http\Request;

class AbsenSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Absen Siswa";
        $kelas = KelasModel::withCount('siswa')->get();
        return view('absen_siswa.index', compact("title", "kelas"));
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
}
