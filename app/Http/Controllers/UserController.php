<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPrivileges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use \App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use PasswordValidationRules;
    public function index()
    {
        $allUsers = User::select('users.id','users.name','users.photo','users.username','users.email','users.role','users.phone','users.address','users.status')->leftJoin('user_privileges', 'users.id', '=', 'user_privileges.user_id')->where('users.email','!=','toushin.java@gmail.com')->orderBy('id','DESC')->get();
        $userType = config('dashboard_constant.USER_TYPE');
//        $userPrivileges = config('dashboard_constant.USER_PRIVILEGE');
//        foreach ($allUsers as &$users){
//            $privileges = json_decode($users->privileges);
//            $defination = [];
//            foreach ($privileges as $key=>$privilege){
//                $defination[]=$userPrivileges[$privilege];
//            }
//            $users->privileges = json_encode($defination);
//        }
        return view('admin.systemUser.list')->with(compact('allUsers','userType'));
    }

    public function newUser($id)
    {
        if($id != 'new'){
            $userInfo = User::select('users.id','users.name','users.photo','users.username','users.email','users.role','users.phone','users.outlets','users.address','users.status')->leftJoin('user_privileges', 'users.id', '=', 'user_privileges.user_id')->find($id);
        }else{
            $userInfo = null;
        }
        $userType = config('dashboard_constant.USER_TYPE');
        $userPrivileges = config('dashboard_constant.USER_PRIVILEGE');
//        $outlets = DB::connection('sqlsrv')->table('tblRestName')->orderBy('ResName')->get();
        $outlets = DB::connection('mysql')->table('rest_fortis.tblrestname')->orderBy('ResName')->get();
//        $tblMenu_data = DB::connection('sqlsrv')->table('tblMenu')->orderBy('repname')->get();
        $tblMenu_data = DB::connection('mysql')->table('rest_fortis.tblmenu')->orderBy('repname')->get();
        $kitchen = array();
        foreach($tblMenu_data as $kitchen_items){
            array_push($kitchen, $kitchen_items->kitchen);
        }
        $kitchen = array_unique($kitchen);
        return view('admin.systemUser.userEdit')->with(compact('userInfo','userType','userPrivileges','outlets','kitchen'));
    }

    public function destroy($id)
    {
        // Find the item by ID
        $user = User::find($id);
        // Delete the item
        if ($user->delete()) {
            UserPrivileges::where('user_id', $id)->delete();
            session()->flash('success', 'user deleted successfully.');
        } else {
            session()->flash('error', 'Page not found.');
        }
        return redirect()->route('userList')->with('message', 'user removed already ');
    }

    public function userCreat(Request $request)
    {

        if (!isset($request->id) || empty($request->id)){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|unique:users',
                'role' => 'required|string',
                'privileges' => 'required',
                'status' => 'required|string|max:1',
                'password' => $this->passwordRules(),
            ]);
            $user = new User();
            $randomPassword = $request->password;
            $user->password = Hash::make($randomPassword);
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|unique:users,email,'.$request->id,
                'role' => 'required|string',
                'privileges' => 'required',
                'status' => 'required|string|max:1',
            ]);
            $user = User::find($request->id);
        }


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $image = $request->file('photo');
        if ($image){
            if(isset($request->id) && file_exists($user->photo)){
                unlink($user->photo);
            }
            $imageName = $request->id.'_'.$image->getClientOriginalName();
            $directory = 'assets/frontend/images/user/';
            $image->move('public/'.$directory, $imageName);
            $imgUrl = $directory . $imageName;
            $user->photo = $imgUrl;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = $request->role;
        $privileged = $request->privileges;
        if ($request->role == 'operator'){
            $outlets = json_encode($request->outlets);
            $privileged = ["OPT","UE"];
        }elseif ($request->role == 'kitchen'){
            $outlets = json_encode($request->kitchens);
            $privileged = ["KOT","UE"];
        }else{
            $outlets = '';
        }
        $user->outlets = $outlets;
        $user->status = $request->status;
        $user->createby = Auth::user()->username;

//        dump(Auth::user()->username);
//        dump($privileged);
//        die();
        if ($user->save()) {
            if ((!isset($request->id) || empty($request->id))){
                $userPrivileges = new UserPrivileges();
                $userPrivileges->user_id = $user->id;
                $userPrivileges->user_type = $request->role;
                $userPrivileges->privileges = json_encode($privileged);
                $userPrivileges->status = $request->status;
            }else{
                $userPrivileges = UserPrivileges::find($request->id);
                $userPrivileges->user_id = $user->id;
                $userPrivileges->user_type = $request->role;
                $userPrivileges->privileges = json_encode($privileged);
                $userPrivileges->status = $request->status;
            }
            $userPrivileges->save();
            return redirect()->route('userList')->with('message', 'User info Save successfully');
        } else
            return redirect()->back()->with('message', 'User info Save Failed');
    }

    public function changeUserPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $userInfo = User::find($request->id);
        $userInfo->password = Hash::make($request->password);
        if ($userInfo->save()) {
            return redirect()->route('userList')->with('message', 'User password change successfully');
        } else
            return redirect()->back()->with('message', 'User info Save Failed');
    }
}
