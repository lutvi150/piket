<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuruRequest;
use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = GuruModel::with('user')->get();
        return response()->json([
            'status'  => 'success',
            'msg'     => 'Data guru ditemukan',
            'errors'  => null,
            'data'    => $guru,
            'content' => null,
        ], 200);
    }
    // wali kelas
    public function getWaliKelas()
    {
        $guru=GuruModel::with('user')->whereHas('user', function($query){
            $query->whereJsonContains('role', 'wali_kelas');
        })->get();
        return response()->json([
            'status'  => 'success',
            'msg'     => 'Data guru ditemukan',
            'errors'  => null,
            'data'    => $guru,
            'content' => null,
        ], 200);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guru = GuruModel::with('user')->find($id);
        if ($guru) {
            return response()->json([
                'status'  => 'success',
                'msg'     => 'Data guru ditemukan',
                'errors'  => null,
                'data'    => $guru,
                'content' => null,
            ], 200);
        } else {
            return response()->json([
                'status'  => 'error',
                'msg'     => 'Data guru tidak ditemukan',
                'errors'  => null,
                'data'    => null,
                'content' => null,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_guru'     => 'required|min:3',
            'nip'           => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required',
            'no_hp'         => 'required|numeric|digits_between:10,15',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        $messages = [
            'nama_guru.required'     => 'Nama guru wajib diisi',
            'nama_guru.min'          => 'Nama guru minimal 3 karakter',
            'nip.required'           => 'NIP wajib diisi',
            'nip.numeric'            => 'NIP harus berupa angka',
            // 'nip.min' => 'NIP harus 18 digit',
            // 'nip.max' => 'NIP harus 18 digit',
            'nip.regex'              => 'NIP harus terdiri dari 18 digit angka',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid',
            'alamat.required'        => 'Alamat wajib diisi',
            'no_hp.required'         => 'No HP wajib diisi',
            'no_hp.numeric'          => 'No HP harus berupa angka',
            'no_hp.digits_between'   => 'No HP harus terdiri dari 10 hingga 15 digit',
            // 'no_hp.min' => 'No HP minimal 10 digit',
            // 'no_hp.max' => 'No HP maksimal 15 digit',
            'foto.image'             => 'File harus berupa gambar',
            'foto.mimes'             => 'Format gambar harus jpg, jpeg, atau png',
        ];
        // return response()->json([
        //     'data' => $request->all(),
        // ]);
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $guruModel = GuruModel::findOrFail($id);
        if ($request->hasFile('foto')) {
            if ($guruModel->foto && file_exists(public_path('uploads/guru/' . $guruModel->foto))) {
                unlink(public_path('uploads/guru/' . $guruModel->foto));
            }
            $file            = $request->file('foto');
            $filename        = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/guru');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $guruModel->foto = $filename;
        }
        $guruModel->update([
            'nama_guru'     => strtoupper($request->nama_guru),
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Data guru berhasil diperbarui.',
            'data'    => $guruModel,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = GuruModel::find($id);
        if (! $guru) {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan.',
            ], 404);
        }
        if ($guru->foto && file_exists(public_path('uploads/guru/' . $guru->foto))) {
            unlink(public_path('uploads/guru/' . $guru->foto));
        }
        $user = $guru->user;
        $guru->delete();
        if ($user) {
            $user->delete();
        }
        return response()->json([
            'status'  => true,
            'message' => 'Data guru berhasil dihapus.',
        ], 200);
    }
    public function assignRole(Request $request, $id)
    {
        $guru = GuruModel::find($id);
        if (! $guru) {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan.',
            ], 404);
        }

        $rules = [
            'roles' => 'required|array',
            // 'roles.*' => 'exists:roles,name',
        ];
        $messages = [
            'roles.required' => 'Roles wajib diisi.',
            'roles.array'    => 'Roles harus berupa array.',
            // 'roles.*.exists' => 'Role yang dipilih tidak valid.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $user = $guru->user;
        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User untuk guru ini tidak ditemukan.',
            ], 404);
        }
        $user       = User::find($user->id);
        $user->role = ($request->roles);
        $user->save();
        return response()->json([
            'status'  => true,
            'message' => 'Roles berhasil diperbarui.',
            'data'    => $user->role,
        ], 200);
    }
    public function getRoles($id)
    {
        $guru = GuruModel::find($id);
        if (! $guru) {
            return response()->json([
                'status'  => false,
                'message' => 'Data guru tidak ditemukan.',
            ], 404);
        }
        $user = $guru->user;
        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User untuk guru ini tidak ditemukan.',
            ], 404);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Roles berhasil diambil.',
            'data'    => is_array($user->role) ? $user->role : json_decode($user->role, true),
        ], 200);
    }
}
