<?php

namespace App\Http\Controllers;

use App\Models\RekapPiket;
use App\Models\KelasModel;
use App\Models\Mapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title='Rekap Piket';
        $kelas=KelasModel::all();
        $mapel=Mapel::all();
        return view('rekap-piket.index',compact('title','kelas','mapel'));
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
    public function show(RekapPiket $rekapPiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekapPiket $rekapPiket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekapPiket $rekapPiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekapPiket $rekapPiket)
    {
        //
    }
}
