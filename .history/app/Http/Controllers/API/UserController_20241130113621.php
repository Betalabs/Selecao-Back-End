<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $user;

    /**
     * Method __construct
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Create new User
     * @param \Illuminate\Http\Request $request
     * @param mixed $productId
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Model
     */
    public function create(UserCreateRequest $request): User|Model
    {
        $request->user()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();
        return $this->user->create($request->all());
    }

    /**
     * Update a User
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Model
     */
    public function update(Request $request): User|Model
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email'
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return $user;
    }

    public function login(Request $request) {}
}