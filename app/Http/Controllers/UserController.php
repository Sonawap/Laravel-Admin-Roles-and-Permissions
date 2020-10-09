<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Notifications\Notification;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user');
    }

    public function profile(){
        return view('profile.profile');
    }

    public function photo(){
        return view('profile.photo');
    }

    public function getNotifications(){
        return response()->json([
            'notification' => auth()->user()->unreadNotifications,
            'allnotification' => auth()->user()->Notifications,
            'count' =>DB::table('notifications')->where('notifiable_id', auth()->user()->id)->where('read_at', null)->count()
        ],200);
    }

    public function getIndex(){
        $users = User::latest()->with('roles')->get();


        $roles = Role::all();
        $permissions = Permission::all();
        return response()->json([
            'users' => $users,
            'roles' =>$roles,
            'permissions' => $permissions
        ]);
    }

    public function UploadImage(Request $request){
        $this->validate($request,[
            'icon' => 'required',

        ]);
        if(!empty($request->icon)){
            $currentphoto = auth()->user()->photo;
            $name = auth()->user()->name."profilePhoto".time().'.' .explode('/', explode(':', substr($request->icon, 0, strpos($request->icon, ';')))[1])[1];
            Image::make($request->icon)->save(public_path('/assets/profile/').$name);
            $request->merge(['photo' => $name]);

            $storePhoto = public_path('/assets/profile/').$currentphoto;
            if(file_exists($storePhoto)){
                @unlink($storePhoto);
            }

        }
        if(auth()->user()->update([
            'photo' => $request->photo
        ])){
            return response()->json([
                'message' => 'uploaded'
            ],200);

        };
    }

    public function getUser(){
        $users = User::role('user')->with('roles')->get();

        $roles = Role::all()->load('permissions');
        return response()->json([
            'users' => $users,
            'roles' =>$roles
        ]);
    }

    public function getAdmin(){
        $users = User::role('admin')->with('roles')->get();

        $roles = Role::all()->load('permissions');
        return response()->json([
            'users' => $users,
            'roles' =>$roles
        ]);
    }

    public function search($search){

        $users = User::where(function($query) use ($search){
            $query->where('name','LIKE',"%$search%")->
            orWhere('email','LIKE',"%$search%");
        })->with('roles')->get();

        $roles = Role::all()->load('permissions');
        return response()->json([
            'users' => $users,
            'roles' =>$roles
        ]);
    }

    public function getPassword(){
        return view('passwords.change');
    }

    public function postPassword(Request $request){
        $this->validate($request, [
            'newpassword' => 'required|min:6|max:20|confirmed',
        ]);

        $user = auth()->user();

        $user->update([
            'pword' => $request->newpassword,
            'password' => bcrypt($request->newpassword)
        ]);

        return redirect()->route('password.change')->with('success', 'Password Has been Changed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:15|alpha_num',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $user = new User;
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->phone =  $request->phone;
            $user->password = bcrypt($request->password);

            $user->save();
            $user->assignRole($request->role);
            if($request->has('permissions')){
                $user->givePermissionTo($request->permissions);
            };


        return "ok";
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $user->name = $request->name;
        $user->email =  $request->email;
        $user->phone =  $request->phone;
        $user->update();

        return redirect()->route('user.profile')->with('success', 'Profile Updated');

    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
        ]);
        if(!empty($request->password)){
            $request->merge(['password' => $request['password']]);
            $request->merge(['pword' => $request['password']]);
        }
        if(empty($request->password)){
            $request->merge(['password' => $user->pword]);
            $request->merge(['pword' =>  $user->pword]);
        }
        $user->name = $request->name;
        $user->email =  $request->email;
        $user->phone =  $request->phone;
        $user->password = bcrypt($request->password);

        $user->update();

        $userRole = $user->getRoleNames();

        if($request->has('role')){
            foreach($userRole as $userName){
                $user->removeRole($userName);
            };
            $user->assignRole($request->role);
        };

        return 'OK';

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
