<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function create(array $request)
    {
        $user = User::create($request);

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

    public function update($user, array $validated)
    {
        $user->update($validated);

        return $this->getByEmail($user->email);
    }
}
