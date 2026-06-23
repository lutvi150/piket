<?php
namespace App\Http\Controllers;

use App\Http\Requests\GuruRequest;
use App\Models\AbsenModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Guru";
        $guru  = GuruModel::with('user')->orderBy('created_at', 'desc')->get();
        return view('guru.index', compact("guru", "title"));
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
    public function store(GuruRequest $request)
    {

        $data = $request->validated();
        $user = User::create([
            'email'    => $request->email,
            'name'     => $request->nama_guru,
            'role'     => 'guru',
            'password' => bcrypt($request->nip), // Ensure you hash the password
        ]);
        $id_user = $user->id;
        if ($user) {
            if ($request->hasFile('foto')) {
                $file            = $request->file('foto');
                $filename        = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/guru');
                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);
            }
            $guru = GuruModel::create([
                'id_user'       => $id_user,
                'nama_guru'     => strtoupper($request->nama_guru),
                'nip'           => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'foto'          => $request->foto ? $filename : null,
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Data guru berhasil ditambahkan',
                'data'    => $guru,
            ], 201);
        } else {
            User::where('id', $id_user)->delete();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menambahkan data guru',
            ], 500);
        }
    }
    public function store_(GuruRequest $request)
    {
        $rules = [
            'nama_guru'     => 'required|min:3',
            'nip'           => 'required',
            'jenis_kelamin' => 'required',
            'alamat'        => 'required',
            'no_hp'         => 'required|numeric',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($request->jenis == 'store') {
            $rules['email'] = 'required|email|unique:users,email';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        if ($request->jenis == 'store') {
            $user = User::create([
                'email'    => $request->email,
                'name'     => $request->nama_guru,
                'role'     => 'guru',
                'password' => bcrypt($request->nip), // Ensure you hash the password
            ]);
            $id_user = $user->id;
        } else {
            $id_user = $request->id;
        }
        if ($request->hasFile('foto')) {
            $file            = $request->file('foto');
            $filename        = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/guru');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
        }
        if ($request->jenis == 'store') {
            $jenis = 'store';
            $guru  = GuruModel::create([
                'id_user'       => $id_user,
                'nama_guru'     => $request->nama_guru,
                'nip'           => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'foto'          => $request->foto ? $filename : null,
            ]);
        } else {
            $jenis = 'update';
            $guru  = GuruModel::find($request->id);
            if (! $guru) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data guru tidak ditemukan.',
                ], 404);
            }
            $guru->update([
                'nama_guru'     => $request->nama_guru,
                'nip'           => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'foto'          => $request->hasFile('foto') ? $filename : $guru->foto, // pakai data lama jika kosong
            ]);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Data guru berhasil disimpan.',
            'jenis'   => $jenis,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GuruModel $guruModel)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruModel $guruModel)
    {
        $guruModel->load('guru');
        return response()->json([
            'status'  => true,
            'message' => 'Data guru berhasil ditemukan.',
            'data'    => $guruModel,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruModel $guruModel)
    {
        $rules = [
            'nama_guru'     => 'required|min:3',
            'nip'           => 'required|min:18|max:18|numeric',
            'jenis_kelamin' => 'requiredin:L,P',
            'alamat'        => 'required',
            'no_hp'         => 'required|numeric|min:10|max:15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        $messages = [
            'nama_guru.required'     => 'Nama guru wajib diisi',
            'nama_guru.min'          => 'Nama guru minimal 3 karakter',
            'nip.required'           => 'NIP wajib diisi',
            'nip.numeric'            => 'NIP harus berupa angka',
            'nip.min'                => 'NIP harus 18 digit',
            'nip.max'                => 'NIP harus 18 digit',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid',
            'alamat.required'        => 'Alamat wajib diisi',
            'no_hp.required'         => 'No HP wajib diisi',
            'no_hp.numeric'          => 'No HP harus berupa angka',
            'no_hp.min'              => 'No HP minimal 10 digit',
            'no_hp.max'              => 'No HP maksimal 15 digit',
            'foto.image'             => 'File harus berupa gambar',
            'foto.mimes'             => 'Format gambar harus jpg, jpeg, atau png',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        if ($request->hasFile('foto')) {
            $file            = $request->file('foto');
            $filename        = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/guru');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $guruModel->foto = $filename;
        }
        $guruModel->nama_guru     = $request->nama_guru;
        $guruModel->nip           = $request->nip;
        $guruModel->jenis_kelamin = $request->jenis_kelamin;
        $guruModel->alamat        = $request->alamat;
        $guruModel->no_hp         = $request->no_hp;
        $guruModel->save();
        return response()->json([
            'status'  => true,
            'message' => 'Data guru berhasil diperbarui.',
            'data'    => $guruModel,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruModel $guruModel, $id)
    {
        $guru = GuruModel::find($id);
        if ($guru) {
            $guru->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data guru berhasil dihapus.',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan.',
            ], 404);
        }
    }
    public function getGuru()
    {
        $guru = GuruModel::select('id', 'nama_guru')->get();
        return response()->json([
            'status'  => true,
            'data'    => $guru,
            'message' => 'Data guru berhasil ditemukan.',
        ], 200);
    }
    // use for attendance
    public function absensi()
    {
        if (Session::get('data.role') == 'guru') {
            $session = Session::get('guru');
            $kelas   = KelasModel::withCount('siswa')->where('id_guru', $session['id'])->get();
        } else {
            $kelas = KelasModel::withCount('siswa')->get();
        }
        $title = "Absensi Murid";
        return view('guru.data_kelas', compact('kelas', 'title'));
    }
    public function makeAttendance($id_kelas)
    {
        $kelas   = KelasModel::find($id_kelas);
        $siswa   = KelasModel::find($id_kelas)->siswa;
        $absensi = AbsenModel::with('guru')->where('id_kelas', $id_kelas)->orderBy('tanggal', 'desc')->get();
        $title   = "Absensi Siswa " . $kelas->nama_kelas;
        // dd($kelas);
        // exit;
        return view('guru.absensi', compact('absensi', 'kelas', 'siswa', 'title'));
    }
    public function storeAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_absen'  => 'required|date',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i',
            'mata_pelajaran' => 'required|string',
            'id_kelas'       => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal_absen)->format('Y-m-d');
        $absensi = AbsenModel::create([
            'tanggal'        => $tanggal,
            'jam_masuk'      => $request->jam_mulai,
            'jam_keluar'     => $request->jam_selesai,
            'mata_pelajaran' => $request->mata_pelajaran,
            'id_kelas'       => $request->id_kelas,
            'jumlah_siswa'   => count(KelasModel::find($request->id_kelas)->siswa),
            // 'id_guru'       => Session::get('guru')['id'],
            'id_guru'        => $request->id_guru,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Absensi berhasil disimpan.',
        ], 201);
    }
}
