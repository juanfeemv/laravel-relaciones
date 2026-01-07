<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthTokenResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Crear profile automáticamente:
        $user->profile()->create(['bio' => '']);

        $tokenName = $data['device_name'] ?? 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json(new AuthTokenResource([
            'token' => $token,
            'user'  => $user,
        ]), 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas.'
            ], 401);
        }

        $tokenName = $data['device_name'] ?? 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json(new AuthTokenResource([
            'token' => $token,
            'user'  => $user,
        ]), 200);
    }

    public function me(Request $request)
    {
        // incluir profile:
        $user = $request->user()->load('profile');
        return response()->json([
        'user' => new UserResource($user),
        'profile' => new ProfileResource($user->profile),
    ]);
    }

    public function logout(Request $request)
    {
        /** @var PersonalAccessToken|null $token */
        $token = $request->user()->currentAccessToken();
        //todos los tokens
        //$token = $request->user()->tokens();
        if ($token) {
            $token->delete();
        }
        return response()->json([
            'message' => 'Sesión cerrada',
        ], 200);
    }
}
