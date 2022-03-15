<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

use App\Http\Resources\Localization\State\StateCollection;
use App\Http\Resources\Localization\State\StateShowResource;
use App\Models\Localization\State;

class StateController extends Controller
{
    /**
     * Display a listing of the State.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StateCollection(State::paginate(5));
    }

    /**
     * Display the specified State.
     *
     * @param  int $state
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new StateShowResource(State::findOrFail($id));
    }

    /**
     * Store a specified State.
     *
     * @param  int $state
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'country_id' => ['required', 'exists:countries,id'],
            'name' => ['required', Rule::unique('states', 'name')->where(function ($query) use ($request) {
                return !$query->where('name', $request->name)->where('country_id', $request->country_id);
            }), 'max:80', 'min:4'],
            'slug' => ['required', Rule::unique('states', 'slug')->where(function ($query) use ($request) {
                return !$query->where('slug', $request->slug)->where('country_id', $request->country_id);
            }), 'max:4', 'min:2']
        ];

        $attributes = [
            'country_id' => 'Country',
            'name' => "State's name",
            'slug' => "State's short name",
        ];

        $this->validate($request, $rules, [], $attributes);

        $data = $request->only(['name', 'slug', 'country_id']);

        try {
            $state = State::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The State has not been created.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The State: ' . $state->name . ' has been created.']);
    }

    /**
     * Updating a specified State.
     *
     * @param  int $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'country_id' => ['exists:countries,id'],
            'name' => [Rule::unique('states', 'name')->where(function ($query) use ($request) {
                return !$query->where('name', $request->name)->where('country_id', $request->country_id);
            })->ignore($id), 'max:80', 'min:4'],
            'slug' => [Rule::unique('states', 'slug')->where(function ($query) use ($request) {
                return !$query->where('slug', $request->slug)->where('country_id', $request->country_id);
            })->ignore($id), 'max:4', 'min:2']
        ];

        $attributes = [
            'country_id' => 'Country',
            'name' => "State's name",
            'slug' => "State's short name",
        ];

        $this->validate($request, $rules, [], $attributes);

        $data = $request->only(['name', 'slug', 'country_id']);

        try {
            $state = State::find($id);
            $state->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The State has not been updated.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The State: ' . $state->name . ' has been updated.']);
    }

    /**
     * Destroy a specified State.
     * 
     * @param int $state
     * @return response
     */
    public function destroy($id)
    {
        try {
            $state = State::findOrFail($id);
            $stateName = $state->name;
            $state->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The State has not been deleted.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'Success! The State: ' . $stateName . ' has been deleted.'], 200);
    }
}
