<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    function form_login()
    {
        // $session = Session::get('data');
        $session = session()->get('data');
        return response()->json([
            'status'  => 'success',
            'msg'     => 'success',
            'errors'   => null,
            'data'    => $session['role'],
            'content' => null,
        ], 200);
    }
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required',
            'password' => 'required',
        ];
        $message = [
            'email.required'    => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            $respon = [
                'status'  => 'validationerror',
                'msg'     => 'Validation Error',
                'errors'   => $validator->errors(),
                'content' => null,
            ];
            return response()->json($respon, 200);
        } else {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->select('email','name', 'role','id')->first();
                Session::put(['data' => $user]);
                if($user->role == 'guru'){
                    $guru = GuruModel::where('id_user', $user->id)->first();
                    Session::put(['guru' => $guru]);
                }
                $guru=GuruModel::where('id_user', $user->id)->first();
                $respon = [
                    'status'  => 'success',
                    'msg'     => 'success',
                    'errors'   => null,
                    'data'    => $user,
                    'content' => null,
                ];
                return response()->json($respon, 200);
            } else {
                $respon = [
                    'status'  => 'failed',
                    'msg'     => 'failed',
                    'errors'   => null,
                    'content' => null,
                ];
                return response()->json($respon, 200);
            }
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah.'
        ], 200);
    }
}
