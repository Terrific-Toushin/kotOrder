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
        if (Auth::user()->role == 'root'){
            $allUsers = User::select('users.id','users.PropertyID','users.name','users.photo','users.username','users.email','users.role','users.phone','users.address','users.createby','users.created_at','users.status')->leftJoin('user_privileges', 'users.id', '=', 'user_privileges.user_id')->where('users.email','!=','toushin.java@gmail.com')->where('users.role','==','admin')->orderBy('id','DESC')->get();
        }else{
            $allUsers = User::select('users.id','users.name','users.photo','users.username','users.email','users.role','users.kot_void','users.Item_remove','users.phone','users.address','users.createby','users.created_at','users.status')->leftJoin('user_privileges', 'users.id', '=', 'user_privileges.user_id')->where('users.email','!=','toushin.java@gmail.com')->where('users.PropertyID','=',Auth::user()->PropertyID)->orderBy('id','DESC')->get();
        }
        $userType = config('dashboard_constant.USER_TYPE');
        return view('admin.systemUser.list')->with(compact('allUsers','userType'));
    }

    public function newUser($id)
    {
        if($id != 'new'){
            $userInfo = User::select('users.id','users.name','users.photo','users.username','users.email','users.role','users.phone','users.kot_void','users.Item_remove','users.outlets','users.address','users.status')->leftJoin('user_privileges', 'users.id', '=', 'user_privileges.user_id')->find($id);
        }else{
            $userInfo = null;
        }
        if (Auth::user()->role == 'root'){
            $companyList = DB::connection('sqlsrv')->table('tblProperty')->select('PropertyID','PropertyName')->where('isActive','1')->get();
            $userType = ['admin' => 'Admin'];
            $outlets = [];
            $kitchen = [];
            $kotVoid = 'No';
        }else{
            $userType = config('dashboard_constant.USER_TYPE');
            $companyList = [];
            $outlets = DB::connection('sqlsrv')->table('tblRestName')->where('PropertyID','=',Auth::user()->PropertyID)->orderBy('ResName')->get();
            $tblMenu_data = DB::connection('sqlsrv')->table('tblMenu')->where('PropertyID','=',Auth::user()->PropertyID)->orderBy('repname')->get();
            $kotVoid = DB::connection('sqlsrv')->table('tblProperty')->select('PrintTo')->where('PropertyID','=',Auth::user()->PropertyID)->first();
            $kotVoid = $kotVoid->PrintTo;
//        $tblMenu_data = DB::connection('mysql')->table('rest_fortis.tblmenu')->orderBy('repname')->get();
            $kitchen = array();
            foreach($tblMenu_data as $kitchen_items){
                array_push($kitchen, $kitchen_items->kitchen);
            }
            $kitchen = array_unique($kitchen);
        }

        $userPrivileges = config('dashboard_constant.USER_PRIVILEGE');
//        dump($kotVoid);
//        die();
//        dump($outlets);
//        die();
//        $outlets = DB::connection('mysql')->table('rest_fortis.tblrestname')->orderBy('ResName')->get();

        return view('admin.systemUser.userEdit')->with(compact('userInfo','userType','userPrivileges','outlets','kitchen','companyList','kotVoid'));
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
            $directory = 'public/assets/frontend/images/user/';
            $image->move($directory, $imageName);
            $imgUrl = $directory . $imageName;
            $user->photo = $imgUrl;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = $request->role;
        $user->PropertyID = Auth::user()->role == 'root' ? $request->PropertyID : Auth::user()->PropertyID;
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
        $user->kot_void = isset($request->kot_void) && !empty($request->kot_void) ? $request->kot_void : 'Y';
        $user->Item_remove = isset($request->Item_remove) && !empty($request->Item_remove) ? $request->Item_remove : 'Y';
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
