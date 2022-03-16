<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get the attributes which are used in the validation.
     * 
     * @return array
     */
    protected $attributes = ['name' => 'user name', 'email' => 'user email'];

    /**
     * Display a listing of the User.
     *
     * @return Response
     */
    public function index()
    {
        return new UserCollection(User::orderBy('name', 'ASC')->paginate(5));
    }

    /**
     * Display the specified User.
     *
     * @param  int $user
     * @return Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Store a specified User.
     *
     * @param  int $user
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:160'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'email', 'password']);

        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The User has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The User: ' . $user->name . ' has been created.']);
    }

    /**
     * Updating a specified User.
     *
     * @param  int $user
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['string', 'max:160', 'min:1'],
            'email' => ['email', 'unique:users,id,' . $id],
            'password' => ['string', 'min:4']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::find($id);
            $user->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The User has not been updated.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The User: ' . $user->name . ' has been updated.']);
    }

    /**
     * Destroy a specified User.
     * 
     * @param int $user
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $userName = $user->name;
            $user->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The User has not been deleted.', 'error_code' => $ex->getCode()], 501);
        }
        return response()->json(['message' => 'Success! The User: ' . $userName . ' has been deleted.'], 200);
    }
}
