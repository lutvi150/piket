<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function chartSiswa() {
     $kelas=KelasModel::pluck('nama_kelas');
        $jumlahSiswa=KelasModel::select('kelas.nama_kelas',\DB::raw('COUNT(siswa.id) as jumlah_siswa'))
        ->leftJoin('siswa','siswa.id_kelas','=','kelas.id')
        ->groupBy('kelas.nama_kelas')
        ->pluck('jumlah_siswa')
        ->toArray();
        return response()->json(['status'=>'success','data'=>$jumlahSiswa,'dataKelas'=>$kelas],200);
    }
}
