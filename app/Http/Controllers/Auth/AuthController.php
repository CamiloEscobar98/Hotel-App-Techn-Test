<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Loggin an User.
     * 
     * @return Response
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string']
        ];

        $this->validate($request, $rules);

        $credentials = $request->only(['email', 'password']);

        $user = User::Where('email', $credentials['email'])->first();

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // if (!empty($user) && !Hash::check($credentials['password'], $user->password)) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
    }
}
