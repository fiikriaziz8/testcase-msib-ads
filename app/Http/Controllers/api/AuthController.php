<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function userRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Isi semua kolom!',
                'data' => $validator->errors()
            ]);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        
        User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil!',
        ]);
    }

    public function userLogin(Request $request){
        if(Auth::attempt(['email' => $request->email,'password'=> $request->password])){
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken; 
            $sucess['name'] = $auth->name;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => $success
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Login gagal!',
            ]);
        }
    }

    public function userLogout(Request $request){
        $request->user()->currentAccessToken()->delete() ;

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function updateProfile(Request $request){
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'email' => [
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Email tidak tersedia! Gunakan email lain",
            ], 422);
        }
        
        if($request->has('password')){
            $request['password'] = bcrypt($request['password']);
        }

        $user->update($request->only('name', 'email', 'password'));

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diperbarui',
            'data' => $user,
        ]);
    }
}
