<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApiLoginRequest;
use App\Http\Requests\Api\V1\ApiRegisterRequest;
use App\Models\User;
use App\services\HasDBSafe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HasDBSafe;

    public function login(ApiLoginRequest $request) {
        return $this->DBSafe(function() use ($request) {
            $credentials = $request->only('email', 'password');
    
            $auth = Auth::attempt($credentials);
    
            if (!$auth) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
    
            $token = $request->user()->createToken('authToken')->plainTextToken;
    
            return response()->json(['message' => "Success", 'token' => $token], 201);
        });
    }

    public function register(ApiRegisterRequest $request) {
        return $this->DBSafe(function() use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            
            return response()->json(['message' => "Success", 'data' => $user], 201);
        });
    }
}
