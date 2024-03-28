<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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



    public function register(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // cek kondisi password dan confirm password
            if ($request->password != $request->confirm_password) {
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
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something wemt wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }



    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success([
            $token = 'Token Revoked'
        ], 'Token Revoked', 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // get data user
            $user = Auth::user();
            if (!Hash::check($request->old_password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'Password lama tidak sesuai'
                ], 'Authentication Failed', 401);
            }

            // cek password baru dan konfirmasi password baru
            if ($request->new_password != $request->confirm_password) {
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

    public function allUsers()
    {
        $users = User::where('role', 'user')->get();
        return ResponseFormatter::success($users, 'Data user berhasil diambil');
    }

    public function storeProfile(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'first_name' => 'required|string|max:225',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // get data user
            $user = auth()->user();

            // upload image
            $image = $request->file('image');
            $image->storeAs('public/profile', $image->hashName());

            // create profile
            $user->profile()->create([
                'first_name' => $request->first_name,
                'image' => $image->hashName()
            ]);

            // get data profile
            $profile = $user->profile;

            return ResponseFormatter::success($profile, 'Data user berhasil diupdate');

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'first_name' => 'required|string|max:225',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // get data user
            $user = auth()->user();

            if ($request->file('image') == '') {
                $user->profile->update([
                    'first_name' => $request->first_name
                ]);
            } else {
                // delete image
                Storage::disk('local')->delete('public/profile' . basename($user->image));

                // upload image
                $image = $request->file('image');
                $image->storeAs('public/profile', $image->hashName());

                // update image
                $user->profile->update([
                    'first_name' => $request->first_name,
                    'image' => $image->hashName()
                ]);
            }

            return ResponseFormatter::success(['profile' => $user->profile], 'Data user berhasil diupdate');

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function allProfile()
    {
        $profile = Profile::latest()->get();
        return ResponseFormatter::success($profile, 'Data user berhasil diambil');
    }
}