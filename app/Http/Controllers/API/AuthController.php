<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // cek credentials (login)
            $credential = request(['email', 'password']);
            if (!Auth::attempt([
                'email' => $credential['email'],
                'password' => $credential['password']
            ])) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            };

            // cek jika password tidak sesuai
            $user = User::where('email', $credential['email'])->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            // jika berhasil cek password maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated', 200);

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }



    public function register(Request $request) {
        try {
            // validate
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // cek kondisi password dan confirm password
            if($request->password != $request->confirm_password) {
                return ResponseFormatter::error([
                    'message' => 'Password not match'
                ], 'Authentication Failed', 401);
            }

            // create akun
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // get data akun
            $user = User::where('email', $request->email)->first();

            // create token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated', 200);

        } catch(\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something wemt wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }



    public function logout(Request $request) {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success([
            $token = 'Token Revoked'
        ], 'Token Revoked', 200);
    }

    public function updatePassword(Request $request){
        try {
            $this->request($request,[
            'old-password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6'
            ]);

            // get data user
            $user = Auth::user();
            if(!Hash::check($request->old_pssword, $user->password)){
                return ResponseFormatter::error([
                    'message' => 'Password lama tidak sesuai'
                ], 'Authentication Failed', 401);
            }

            // cek password baru dan konfirmasi password baru
            if($request->new_password != $request->confirm_password) {
                return ResponseFormatter::error([
                    'message' => 'Password tidak sesuai'
                ], 'Authentication Failed', 401);
            }

            // update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return ResponseFormatter::success([
                'message' => 'Password berhasil diubah'
            ], 'Authenticated', 200);

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }

    }

    public function allUsers() {
        $users = User::where('role', 'user')->get();
        return ResponseFormatter::success($users, 'Data user berhasil diambil');
    }
}
