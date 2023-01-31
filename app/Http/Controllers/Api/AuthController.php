<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getMe()
    {
        if (Auth::check()) {
            return response()->json([
                'success'   => true,
                'user'      => new UserResource(Auth::user()),
                'message'   => 'User found successfully',
            ], Response::HTTP_ACCEPTED);
        }
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request, UserServices $userServices)
    {
        try {
            $credentials = $request->validated();

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message'   => 'Email & Password does not match with our record.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $data = $userServices->getByEmail($credentials['email']);

            return response()->json([
                'success'   => true,
                'token'     => $data['token'],
                'user'      => new UserResource($data['user']),
                'message'   => 'User Logged In Successfully!',
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();

            return response()->json([
                'success'   => true,
                'data'      => [],
                'message'   => 'Logout in successfully',
            ], Response::HTTP_OK);
        }
    }

    public function register(RegisterRequest $request, UserServices $userServices)
    {
        try {
            $validated = $request->validated();

            $data = $userServices->create($validated);

            return response()->json([
                'success'   => true,
                'token'     => $data['token'],
                'user'      => new UserResource($data['user']),
                'message'   => 'User Created In Successfully!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
