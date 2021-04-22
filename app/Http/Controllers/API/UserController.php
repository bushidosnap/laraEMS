<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if($this->authorize("isAdmin")){
            $user = User::findOrFail($id);
            if($request->oldPassword){

                $data = request()->validate([
                    'oldPassword' => ['sometimes', new MatchOldPassword],
                    'newPassword' => 'sometimes | string | min:6 | max: 100',
                    'rePassword' => ['same:newPassword'],
                ]);
                $user->update(array_merge(
                    $data,
                    ['password' =>Hash::make($request->newPassword)],
                ));
                return ['message' => "Success"];
            }else{
                $request->merge(['password' => Hash::make($request['password'])]);
                $user->update($request->all());           
                return ['message' => "Success"];
            }
        }else{
            return response()->json(['message' => "you are not Authorize to use this function."]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        /* delete the user */
        $user->delete();

        return['message' => 'User Deleted!'];
    }
}
