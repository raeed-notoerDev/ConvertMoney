<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            auth()->attempt(request(['email', 'password']));
            return response()->json([
                'success' => $token
            ], 200);
        }
        return response()->json(false);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'status' => 'required',
            'gender' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'agent_commission' => 'numeric',
            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $name ='Avatar.png';
        if ($request->picture) {
            $name = time() . '.' . explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
            \Image::make($request->picture)->save(public_path('img/profile/') . $name);
        }

        $user = User::create([
            'user_name' => $request['user_name'],
            'email' => $request['email'],
            'zip_code' => $request['zip_code'],
            'password' => Hash::make($request['password']),
            'country_id' => $request['country_id'],
            'gender' => $request['gender'],
            'agent_commission' => $request['agent_commission'],
            'phone_number' => $request['phone_number'],
            'first_name' => $request['first_name'],
            'address' => $request['address'],
            'last_name' => $request['last_name'],
            'nationality' => $request['nationality'],
            'uuid' => uniqid(),
            'status' => $request['status'],
            'ref_id' => random_strings(8),
            'picture' => $name,
        ]);

        $user->roles()->attach(Role::where('name', 'client')->first());
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], 200);

    }
}
