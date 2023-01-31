<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function upload(Request $request)
    {
        $user = Auth::user();

        if ($request->file('avatar')) {
            if ($user->avatar != NULL) {
                // delete existing image file
                Storage::disk('user_avatars')->delete($user->avatar);
            }

            $avatar_name = strtolower($user->name) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $avatar_path = $request->file('avatar')->storeAs('', $avatar_name, 'user_avatars');

            // Update user's avatar column on 'users' table
            $user->avatar = $avatar_path;
            $user->save();
        }

        return $this->getByEmail($user->email);
    }
}
