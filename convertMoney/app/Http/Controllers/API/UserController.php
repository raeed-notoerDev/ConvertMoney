<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Role;
use App\RolePermission;
use App\User;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $members = User::all();
        return response()->json($this->list_users($members));
    }

    function list_users($members)
    {
        $myArray = [];
        for ($i = 0; $i < $members->count(); $i++) {
            if ($members[$i]->hasAnyRole('admin')) {
                array_push($myArray, (object)[
                    'ref_id' => $members[$i]->ref_id,
                    'first_name' => $members[$i]->first_name,
                    'last_name' => $members[$i]->last_name,
                    'user_name' => $members[$i]->user_name,
                    'role' => Role::where('id', $members[$i]->roles->first()['id'])->first()['name'],
                    'nationality' => $members[$i]->nationality,
                    'status' => $members[$i]->status,
                    'email' => $members[$i]->email,
                    'phone_number' => $members[$i]->phone_number,
                    'agent_commission' => $members[$i]->agent_commission,
                    'wallet' => $members[$i]->wallet,
                    'address' => $members[$i]->address,
                    'created_at' => $members[$i]->created_at,
                ]);
            }
        }
        return $myArray;
    }

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
        $name = 'Avatar.png';
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

    public function roles()
    {
        return response()->json([
            'admin' => auth('api')->user()->hasAnyRole('admin'),
            'client' => auth('api')->user()->hasAnyRole('client'),
        ]);
    }

    public function roles_index()
    {
        return response()->json(Role::all());
    }

    public function permissions()
    {
        $role = DB::table('users_roles')->where('user_id', auth('api')->user()->id)->select('role_id')->first();
        error_log($role->role_id);
//        $roles = auth('api')->user()->roles;

        return response()->json($this->list_permissions($role));

    }

    function list_permissions($role)
    {
        $myArray = [];
        $permissions = RolePermission::where('role_id', $role->role_id)->select('name')->get();

        error_log($permissions);
//        for ($i = 0; $i < $permissions->count(); $i++) {
//            array_push($myArray, (object)[
//                'users_view' => $permissions[$i]['route'] == 'user.view' ? true : false,
//                'user_block' => $permissions[$i]['route'] == 'member.block' ? true : false,
//                'roles_view' => $permissions[$i]['route'] == 'role.view' ? true : false,
//                'block_transaction' => $permissions[$i]['route'] == 'block.transaction' ? true : false,
////                'approve_transaction' => $permissions[++$i]['route'] == 'accept.transaction' ? true : false,
////                'cancel_transaction' => $permissions[++$i]['route'] == 'cancel.transaction' ? true : false,
////                'agent_register' => $permissions[++$i]['route'] == 'member.register' ? true : false,
////                'agents_hold' => $permissions[++$i]['route'] == 'member.hold' ? true : false,
////                'agent_profile' => $permissions[++$i]['route'] == 'profile.update' ? true : false,
////                'role_add' => $permissions[++$i]['route'] == 'role.store' ? true : false,
////                'role_edit' => $permissions[++$i]['route'] == 'role.update' ? true : false,
////                'address' => $permissions[$i]->address,
////                'created_at' => $permissions[$i]->created_at,
//            ]);
//        }
//        error_log(auth('api')->user()->roles);
//        return $myArray;
        return $permissions;
    }

    public function permission_show($id)
    {
        $role = $role = DB::table('users_roles')->where('role_id', $id)->select('role_id')->first();
        if ($role)
            return response()->json($this->list_permissions($role));
        else return response()->json([
            'message' => "This Role Not Found"
        ], 404);

    }


    public function permission_store(Request $request)
    {
        $permissions = RolePermission::where('role_id', $request->role_id);
        if ($permissions) {
            $permissions->delete();
            if ($request->roles) {
//            return $request->roles;
                foreach ($request->roles as $key => $data) {
                    if ($data[0]['status'] == true) {
                        $create['route'] = $data[2]['route'];
                        $create['name'] = $key; // || $data[1]['name'];
                        $create['role_id'] = $request->role_id;
                        RolePermission::create($create);
                    }
//                return $data;

                }
            }
        } else {
            return response()->json([
                'message' => 'This Role Not Found'
            ], 404);
        }

    }
}
