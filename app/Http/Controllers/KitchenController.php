<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;

class KitchenController extends Controller
{
    public function KitchenDashboard(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        // $date = date("Y-m-d");

        date_default_timezone_set('Asia/Dhaka');

        $timestamp = time();
        $date = date("Y-m-d", $timestamp);

        $panding_kots_count = DB::table('order_kot')->where('status', '=', '1')->orWhere('status', '=', '4')->where('cancel', '=', 'N')->count();
        $kitchen_complete_kot_count = DB::table('order_kot')->where('status', '=', '3')->where('cancel', '=', 'N')->count();
        $total_kots_count = DB::table('order_kot')->where('cancel', '=', 'N')->count();
        $cash_print_count = DB::table('order_kot')->where('status', '=', '2')->where('cancel', '=', 'N')->count();

        return view('kitchen.kitchenDashboard',compact('profileData', 'panding_kots_count', 'kitchen_complete_kot_count', 'total_kots_count', 'cash_print_count', 'date'));
    } // End Dashboard Method

    public function KitchenProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $msg = '';
        if(session('msg')!=""){
            $msg = session('msg');
            session(['msg' => '']);
        }

        return view('kitchen.kitchenProfile',compact('profileData','msg'));
    } // End Profile Method

    public function KitchenProfileUpdateSave(){
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        $name = request('name');
        $email = request('email');
        $photo = request('photo');
        $phone = request('phone');
        $address = request('address');

        $updated_at=date("Y-m-d H:i:s");

        $UpdateUserID = DB::table('users')->where('id', $id)->update(['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'updated_at' => $updated_at]);

        // $msg = "Sec";

        session(['msg' => 'success']);

        return redirect()->route('kitchen.profile');

    } // End NewUsreSave Method

    public function KitchenChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $msg = '';
        if(session('msg')!=""){
            $msg = session('msg');
            session(['msg' => '']);
        }

        return view('kitchen.kitchenChangePassword',compact('profileData','msg'));
    } // End Change Password Method

    public function ChangePasswordSave(){
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        // $oldpassword = Hash::make(request('inputOldPassword'));
        // echo $profileData->password;
        // echo '<br>'.$oldpassword;

        // if($oldpassword==$profileData->password){
        //     echo 'sam';
            $password = Hash::make(request('password'));

            $updated_at=date("Y-m-d H:i:s");

            $UpdateUserID = DB::table('users')->where('id', $id)->update(['password' => $password, 'updated_at' => $updated_at]);

            session(['msg' => 'ChengePass']);
        // } else{
        //     session(['msg' => 'notMach']);
        // }

        return redirect()->route('kitchen.changePassword');

    } // End NewUsreSave Method

    public function KitchenPendingKOT(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        $userKitchen = json_decode($profileData->outlets,true);
//        die();

        date_default_timezone_set('Asia/Dhaka');

        $timestamp = time();
        $date = date("Y-m-d", $timestamp);
//        DB::enableQueryLog();
        $pending_kots = DB::table('order_kot_item')->leftJoin('order_kot', 'order_kot.billNo', '=', 'order_kot_item.billNo')->select('order_kot_item.*','order_kot.outlet')->where('order_kot_item.cancel', '=', 'N')->where('order_kot_item.complete', '=', 'N')->where(function ($q) {$q->where('order_kot_item.status', '=', '1')->orWhere('order_kot_item.status', '=', '2');})->orderBy('id')->get()->toArray();
//        dump($pending_kots);
//        dump(DB::getQueryLog());
//        die();
        $alreadyOrderItem = array_map(function($item) {
            return $item->repID;
        }, $pending_kots);

//            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $alreadyOrderItem)->get()->toArray();
        $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->select('repid','repname')->whereIn('repid', $alreadyOrderItem)->get()->toArray();
        $itemName = [];
        foreach ($kot_items_selects as $kot_items_select){
            $itemName[$kot_items_select->repid] = $kot_items_select->repname;
        }
//        dump($alreadyOrderItem);
//        dump($kot_items_selects);
//        dump($itemName);
//        die();
        return view('kitchen.kitchenPendingKOT',compact('profileData', 'pending_kots','itemName'));

    } // End KitchenPendingKOT Method

    public function KitchenKOTView(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $billNo = request('billNo');


        $order_kots = DB::table('order_kot')->where('billNo', '=', $billNo)->get();


        foreach ($order_kots as $order_kot) {
            $tableNo = $order_kot->tableNo;
            $roomNo = $order_kot->roomNo;
            $terminal = $order_kot->terminal;
            $serveTime = $order_kot->serveTime;
            $pax = $order_kot->pax;
            $waterName = $order_kot->waterName;
            $gustName = $order_kot->gustName;
            $companyName = $order_kot->companyName;
            $email = $order_kot->email;
            $contactNo = $order_kot->contactNo;
            $entyDate = $order_kot->date;
            $cancel = $order_kot->cancel;
            $status = $order_kot->status;

            $date = date('Y-m-d',strtotime($entyDate));
            $time = date('H:m:s',strtotime($entyDate));
        }

        $order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('status', '=', '1')->get();

        $allMenuItems = array();

        foreach ($order_kot_items as $order_kot_item) {

            $repID = $order_kot_item->repID;
            $qty = $order_kot_item->qty;
            $price = $order_kot_item->price * $qty;

//            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID)->get();
            $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID)->get();
            foreach ($kot_items_selects as $kot_items_select) {
                $repname = $kot_items_select->repname;
                $kitchen = $kot_items_select->kitchen;
            }

            array_push($allMenuItems, array("repID"=>$repID, "repname"=>$repname, "price"=>$price, "qty"=>$qty, "kitchen"=>$kitchen));
        }

        $order_kot_items_new = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('status', '=', '2')->get();

        $allMenuItems_new = array();

        foreach ($order_kot_items_new as $order_kot_item_new) {

            $repID_new = $order_kot_item_new->repID;
            $qty_new = $order_kot_item_new->qty;
            $price_new = $order_kot_item_new->price * $qty_new;

//            $kot_items_selects_new = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID)->get();
            $kot_items_selects_new = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID_new)->get();
            foreach ($kot_items_selects_new as $kot_items_select_new) {
                $repname_new = $kot_items_select_new->repname;
                $kitchen_new = $kot_items_select_new->kitchen;
            }

            array_push($allMenuItems_new, array("repID"=>$repID_new, "repname"=>$repname_new, "price"=>$price_new, "qty"=>$qty_new, "kitchen"=>$kitchen_new));
        }

        $cancel_order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'Y')->get();

        $cancel_allMenuItems = array();

        foreach ($cancel_order_kot_items as $cancel_order_kot_item) {

            $cancel_repID = $cancel_order_kot_item->repID;
            $cancel_qty = $cancel_order_kot_item->qty;
            $cancel_price = $cancel_order_kot_item->price * $cancel_qty;

//            $cancel_kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $cancel_repID)->get();
            $cancel_kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $cancel_repID)->get();
            foreach ($cancel_kot_items_selects as $cancel_kot_items_select) {
                $cancel_repname = $cancel_kot_items_select->repname;
                $cancel_kitchen = $cancel_kot_items_select->kitchen;
            }

            array_push($cancel_allMenuItems, array("repID"=>$cancel_repID, "repname"=>$cancel_repname, "price"=>$cancel_price, "qty"=>$cancel_qty, "kitchen"=>$cancel_kitchen));
        }

        $itencount=1;
        $itencount_new=1;
        $cancel_itencount=1;

        return view('kitchen.kitchenKOTView',compact('billNo','tableNo','roomNo','terminal','serveTime','pax','waterName','gustName','companyName','email','contactNo', 'itencount', 'itencount_new', 'cancel_itencount', 'cancel', 'status', 'date', 'time', ['allMenuItems'], ['allMenuItems_new'], ['cancel_allMenuItems']));
    } // End KitchenKOTView Method

    public function KitchenCompleteKOT(){
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        $billId = request('id');

        $updateOrderKot = DB::table('order_kot_item')->where('id', $billId)->update(['complete' => 'Y']);
        $order_kot_item = DB::table('order_kot_item')->select('billNo')->where('id', '=', $billId)->first();
        $billNo = $order_kot_item->billNo;
        $checkOrderStatus = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('complete', '!=', 'Y')->where('cancel','=','N')->get();
//        dump($checkOrderStatus);
//        dump(count($checkOrderStatus));
        if (count($checkOrderStatus) == 0){
//            dump($billNo);
            $updateOrderKot = DB::table('order_kot')->where('billNo', $billNo)->update(['status' => '3']);
        }
//        die();

        return redirect()->route('kitchen.KitchenPendingKOT',compact('billId'));

    } // End KitchenCompleteKOT Method

    public function KitchenCompleteKOTHistory(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        date_default_timezone_set('Asia/Dhaka');

        $timestamp = time();
        $date = date("Y-m-d", $timestamp);

        $kitchen_complete_kots = DB::table('order_kot_item')->leftJoin('order_kot', 'order_kot.billNo', '=', 'order_kot_item.billNo')->select('order_kot_item.*','order_kot.outlet')->where('order_kot_item.cancel', '=', 'N')->where('order_kot_item.complete', '=', 'Y')->get()->toArray();

        $alreadyOrderItem = array_map(function($item) {
            return $item->repID;
        }, $kitchen_complete_kots);

//            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $alreadyOrderItem)->get()->toArray();
        $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->select('repid','repname')->whereIn('repid', $alreadyOrderItem)->get()->toArray();
        $itemName = [];
        foreach ($kot_items_selects as $kot_items_select){
            $itemName[$kot_items_select->repid] = $kot_items_select->repname;
        }
        return view('kitchen.kitchenKitchenCompleteKOTHistory',compact('profileData', 'kitchen_complete_kots','itemName'));
    } // End KitchenCompleteKOTHistory Method
}
