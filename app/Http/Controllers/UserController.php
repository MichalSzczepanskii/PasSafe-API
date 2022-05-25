<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function me() {
        return new UserCollection(auth()->user());
    }

    public function changePassword(ChangePasswordRequest $request) {
        $user = auth()->user();
        $user->password = Hash::make($request->get('new_password'));
        $user->encryption_key = $request->get('encryption_key');
        $user->save();

        return response()->json(null);
    }

    public function store(StoreUserRequest $request) {
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'encryption_key' => $request->encryption_key
        ]);
        return response()->json(null);
    }
}
