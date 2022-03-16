<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get the attributes which are used in validation.
     * 
     * @return array
     */
    protected $attributes = [];

    /**
     * Loggin an User.
     * 
     * @return Response
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:160'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $apiToken = Str::random(64);

        $data = $request->only(['name', 'email', 'password']);

        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = $apiToken;

        try {
            $user = User::create($data);
            $user->api_token = $apiToken;
            $user->save();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The User has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The User: ' . $user->name . ' has been created.', 'token' => base64_encode($apiToken)]);
    }

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

        if (!empty($user) && !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $apiToken = Str::random(64);

        $user->api_token = $apiToken;
        $user->save();

        return response()->json(['message' => 'Success!', 'user' => [
            'name' => $user->name,
            'email' => $user->email,
        ], 'token' => base64_encode($apiToken)], 401);
    }


    /**
     * Get the Auth User information.
     * 
     * @return Response
     */
    public function profile()
    {
        return response()->json(['data' => Auth::user()]);
    }

    /**
     * Loggout the Auth User.
     * 
     * @return Response
     */
    public function logout(Request $request)
    {
        $token = base64_decode($request->header('Authorization'));

        $user = User::where('api_token', $token)->first();

        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Success! Good Bye.']);
    }
}
