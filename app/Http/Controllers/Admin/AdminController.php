<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $kelas = KelasModel::count();
        $siswa = SiswaModel::count();
        $guru = GuruModel::count();
        return view('admin.dashboard', ['title' => $title, 'kelas' => $kelas, 'siswa' => $siswa, 'guru' => $guru]);
    }
    function countDataChart()
    {
        $dataKelas = KelasModel::pluck('nama_kelas');
        $jumlahSiswa = KelasModel::select('kelas.nama_kelas', \DB::raw('COUNT(siswa.id) as jumlah_siswa'))
            ->leftJoin('siswa', 'siswa.id_kelas', '=', 'kelas.id')
            ->groupBy('kelas.nama_kelas')
            ->pluck('jumlah_siswa')
            ->toArray();
        return response()->json(['status' => 'success', 'data' => $jumlahSiswa, 'dataKelas' => $dataKelas], 200);
    }
    public function guru()
    {
        $title = 'Dashboard';
        return view('guru.dashboard', ['title' => $title]);
    }
    function data_kelas()
    {
        $title = 'Data Kelas';
        return view('admin.data_kelas', ['title' => $title]);
    }
    function data_siswa()
    {
        $title = 'Data Siswa';
        return view('admin.data_siswa', ['title' => $title]);
    }
    function data_guru()
    {
        $title = 'Data Guru';
        return view('admin.data_guru', ['title' => $title]);
    }
    function data_mapel()
    {
        $title = 'Data Mata Pelajaran';
        return view('admin.data_mapel', ['title' => $title]);
    }
    function data_jadwal()
    {
        $title = 'Data Jadwal';
        return view('admin.data_jadwal', ['title' => $title]);
    }
    function data_presensi()
    {
        $title = 'Data Presensi';
        return view('admin.data_presensi', ['title' => $title]);
    }
}
