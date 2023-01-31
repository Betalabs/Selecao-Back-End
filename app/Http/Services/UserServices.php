<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function create(array $request)
    {
        $user = User::create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'password'  => Hash::make($request['password'])
        ]);

        return $this->getByEmail($user->email);
    }

    public function getByEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        $token = $user->createToken("API TOKEN")->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
