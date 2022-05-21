<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Resources\UserCollection;
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
}
