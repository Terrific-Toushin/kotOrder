<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;

class OperatorController extends Controller
{
    public function OperatorOutlets(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        $userOutlets = json_decode($profileData->outlets,true);
        $tblRestName_data = DB::connection('sqlsrv')->table('tblRestName')->whereIn('ResSL',$userOutlets)->orderBy('ResName')->get();
//        $tblRestName_data = DB::connection('mysql')->table('rest_fortis.tblrestname')->whereIn('ResSL',$userOutlets)->orderBy('ResName')->get();
        // $date = date("Y-m-d");
//        dump($tblRestName_data);
//        die();

        return view('admin.operator.operatorOutlets',compact('profileData', 'tblRestName_data'));
    } // End Dashboard Method

    public function OperatorSetOutlets(){
        $id = Auth::user()->id;
        $uotlet = request('uotlet');
        $uotletName = request('uotletName');
//        error_log($uotlet);
        session()->put('uotlet',$uotlet);
        session()->put('uotletName',$uotletName);

        return redirect()->intended('/operator-dashboard');
    } // End Dashboard Method

    public function OperatorDashboard(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }else{
            $outlet = session()->get('uotlet');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);
        $dbDateGet = DB::connection('sqlsrv')->table('tbldate')->first();
        $dbDateOnly = mb_substr($dbDateGet->SDATE, 0, 10);
        $dbDate = date("d-m-Y", strtotime($dbDateOnly));

//        DB::enableQueryLog();
        $panding_kots_count = DB::table('order_kot')->where('cancel', 'N')
            ->where('ResSL',$outlet)
            ->where('userID',Auth::user()->username)
            ->where(static function ($query) {
                $query->where('status', '=', '1')
                ->orWhere('status', '=', '4');
            })->count();
        $kitchen_complete_kot_count = DB::table('order_kot')->where('ResSL',$outlet)->where('userID',Auth::user()->username)->where('status', '=', '3')->where('cancel', '=', 'N')->count();
        $total_kots_count = DB::table('order_kot')->where('ResSL',$outlet)->where('userID',Auth::user()->username)->where('cancel', '=', 'N')->count();
        $cash_print_count = DB::table('order_kot')->where('ResSL',$outlet)->where('userID',Auth::user()->username)->where('status', '=', '2')->where('cancel', '=', 'N')->count();
//        dd(DB::getQueryLog());
        return view('admin.operator.operatorDashboard',compact('profileData', 'panding_kots_count', 'kitchen_complete_kot_count', 'total_kots_count', 'cash_print_count','dbDate'));
    } // End Dashboard Method

    public function OperatorProfile(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $msg = '';
        if(session('msg')!=""){
            $msg = session('msg');
            session(['msg' => '']);
        }

        return view('operator.operatorProfile',compact('profileData','msg'));
    } // End Profile Method

    public function ProfileUpdateSave(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
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

        return redirect()->route('operator.profile');

    } // End Profile Update Method

    public function OperatorChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $msg = '';
        if(session('msg')!=""){
            $msg = session('msg');
            session(['msg' => '']);
        }

        return view('operator.operatorChangePassword',compact('profileData','msg'));
    } // End Change Password Method

    public function ChangePasswordSave(){
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        $password = Hash::make(request('password'));

        $updated_at=date("Y-m-d H:i:s");

        $UpdateUserID = DB::table('users')->where('id', $id)->update(['password' => $password, 'updated_at' => $updated_at]);

        // $msg = "Sec";

        session(['msg' => 'success']);

        return redirect()->route('operator.changePassword');

    } // End ChangPassword Method

    public function NewOrder(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        $userOperator = $profileData->name;

        $bill_No = 0;
        $uotletID =session()->get('uotlet');
        $bill_No_lst = DB::table('order_kot')->latest('date')->first();

        if(!empty($bill_No_lst->billNo)){
            $bill_No = $bill_No_lst->billNo;
        }

        $billauto = "N";
        $billautoDB = DB::table('billauto')->where('id', '=', '1')->get();

        foreach($billautoDB as $billautoDBlist){
            if(!empty($billautoDBlist->auto)){
                $billauto = $billautoDBlist->auto;
            }
        }

//        $tblGuestInfo_data = DB::connection('sqlsrv')->table('tblGuestInfo')->orderBy('fldRoom')->get();
//        $tblGuestInfo_data = DB::connection('mysql')->table('rest_fortis.tblguestinfo')->orderBy('fldRoom')->get();
//        $tblWaiter_data = DB::connection('sqlsrv')->table('tblWaiter')->where($uotletID, '1')->orderBy('Name')->get();
//        $tblWaiter_data = DB::connection('mysql')->table('rest_fortis.tblwaiter')->where($uotletID, '1')->orderBy('Name')->get();

//        $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();
        $uotlet = DB::connection('sqlsrv')->table('tblrestname')->where('ResSL', '=', $uotletID)->get();

        $uotletName = "";
        foreach($uotlet as $uotletData){
            $uotletName = $uotletData->ResName;
        }

        $tblMenu_data = DB::connection('sqlsrv')->table('tblMenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();
//        $tblMenu_data = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();

        $kitchen = array();
        foreach($tblMenu_data as $kitchen_items){
            array_push($kitchen, $kitchen_items->kitchen);
        }
        $kitchen = array_unique($kitchen);

        return view('admin.operator.operatorNewOrder',compact('profileData','bill_No', 'billauto','userOperator','tblMenu_data', 'kitchen'));
    } // End OperatorNewOrder Method


    public function TableExist(Request $request){
        // $id = Auth::user()->id;
        // $profileData = User::find($id);
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }else{
            $outlet = session()->get('uotlet');
        }

        $order_kot = DB::table('order_kot')->where('tableNo', '=', $request->tableNo)->where('cancel', '=', 'N')->where('ResSL', '=', $outlet)->where(function ($q) {$q->where('status', '=', '1')->orWhere('status', '=', '4');})->get();

        foreach($order_kot as $order_kots ){
            $tableNo = $order_kots->tableNo;
        }

        if(!empty($tableNo)){
            $table='true';
        }else{
            $table='false';
        }
        return $table;
    } // End TableExist Method

    public function RoomExist(Request $request){
        // $id = Auth::user()->id;
        // $profileData = User::find($id);
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }else{
            $outlet = session()->get('uotlet');
        }

        $order_kot = DB::table('order_kot')->where('roomNo', '=', $request->roomNo)->where('cancel', '=', 'N')->where('ResSL', '=', $outlet)->where(function ($q) {$q->where('status', '=', '1')->orWhere('status', '=', '4');})->get();

        foreach($order_kot as $order_kots ){
            $roomNo = $order_kots->roomNo;
        }

        if(!empty($roomNo)){
            $room='true';
        }else{
            $room='false';
        }
        return $room;
    } // End RoomExist Method

    public function NewOrderItem(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        // Seclet Outlet
        // error_log(session()->get('uotlet'));
        $uotletID = session()->get('uotlet');
        $uotlet = DB::connection('sqlsrv')->table('tblRestName')->where('ResSL', '=', $uotletID)->get();
//        $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();

        $uotletName = "";
        foreach($uotlet as $uotletData){
            $uotletName = $uotletData->ResName;
        }

        $tblMenu_data = DB::connection('sqlsrv')->table('tblMenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();
//        $tblMenu_data = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();

        $kitchen = array();
        foreach($tblMenu_data as $kitchen_items){
            array_push($kitchen, $kitchen_items->kitchen);
        }
        $kitchen = array_unique($kitchen);

        $billNo = request('billNo');
        $tableNo = request('tableNo');
        $room = request('room');
        $terminal = request('terminal');
        $serveTime = request('serveTime');
        $pax = request('pax');
        $waterName = request('waterName');
        $gustName = request('gustName');
        $companyName = request('companyName');
        $email = request('email');
        $contactNo = request('contactNo');

        return view('operator.operatorNewOrderItem',compact('tblMenu_data', 'kitchen','billNo','tableNo','room','terminal','serveTime','pax','waterName','gustName','companyName','email','contactNo'));


    } // End OperatorNewOrderItem Method

    public function NewOrderItemSave(Request $request){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
//        dump($request);
//        die();
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $uotletID = session()->get('uotlet');
        $uotlet = DB::connection('sqlsrv')->table('tblRestName')->where('ResSL', '=', $uotletID)->get();
//        $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();

        $uotletName = "";
        foreach($uotlet as $uotletData){
            $uotletName = $uotletData->ResName;
        }

        $billNo = (int)request('billNo');
        $tableNo = request('tableNo');
        $roomNo = request('room');
        $terminal = request('terminal');
        $serveTime = request('serveTime');
        $pax = request('pax');
        $waterName = Auth::user()->name;
        $gustName = request('gustName');
        $companyName = '';
        $email = '';
        $contactNo = request('contactNo');
        $itemCount = request('itemCount');

        $bill_No_lst_db = 0;
        $bill_No_lst = DB::table('order_kot')->latest('date')->first();
        if(!empty($bill_No_lst->billNo)){
            $bill_No_lst_db = $bill_No_lst->billNo;
        }

        if($billNo<=$bill_No_lst_db){
            $billNo = (int)$bill_No_lst_db+1;
        }elseif($billNo==0){
            $billNo=1;
        }

        $InsertOrderKot = DB::insert('insert into order_kot (billNo, tableNo, roomNo, terminal, serveTime, pax, waterName, gustName, companyName, email, contactNo, outlet, ResSL, userID) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$billNo, $tableNo, $roomNo, $terminal, $serveTime, $pax, $waterName, $gustName, $companyName, $email, $contactNo, $uotletName, $uotletID, $username]);

        for($count=1;$count<=$itemCount;$count++){
            if(request('repid'.$count)!=""){

                $repid = request('repid'.$count);
                $qty = request('qty'.$count);
                $price = request('price'.$count);
                $kitchen = request('kitchen'.$count);
                $remark = request('remark'.$count);
                if($InsertOrderKot){
                    DB::insert('insert into order_kot_item (billNo, repID, price, qty, remark, kitchen) values (?, ?, ?, ?, ?, ?)', [$billNo, $repid, $price, $qty,$remark, $kitchen]);
                }
            }
        }

        return redirect()->route('kotView',compact('billNo'));

    } // End OperatorNewOrderItemSave Method

    public function EditOrderAddItemSave(Request $request){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
//        dump($request);
//        die();
        $uotletID = session()->get('uotlet');
        $uotlet = DB::connection('sqlsrv')->table('tblRestName')->where('ResSL', '=', $uotletID)->get();
//        $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();

        $uotletName = "";
        foreach($uotlet as $uotletData){
            $uotletName = $uotletData->ResName;
        }

        $billNo = request('billNo');
        $tableNo = request('tableNo');
        $roomNo = request('room');
        $terminal = request('terminal');
        $serveTime = request('serveTime');
        $pax = request('pax');
        $waterName = Auth::user()->name;
        $gustName = request('gustName');
        $companyName = '';
        $email = '';
        $contactNo = request('contactNo');
        $itemCount = request('itemCount');


        // $InsertOrderKot = DB::insert('insert into order_kot (billNo, tableNo, roomNo, terminal, serveTime, pax, waterName, gustName, companyName, email, contactNo, userID) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$billNo, $tableNo, $roomNo, $terminal, $serveTime, $pax, $waterName, $gustName, $companyName, $email, $contactNo, $username]);
        $billState = DB::table('order_kot_item')->select('billState')->orderBy('date','DESC')->first();
        $nextBillState = $billState->billState;
        $nextBillState++;

        $updateOrderKotItem = DB::table('order_kot_item')->where('billNo', $billNo)->update(['cancel' => 'Y']);
        for($count=1;$count<=$itemCount;$count++){
            if(request('repid'.$count)!=""){

                $repid = request('repid'.$count);
                $qty = request('qty'.$count);
                $price = request('price'.$count);
                $kitchen = request('kitchen'.$count);
                $remark = request('remark'.$count);
                DB::insert('insert into order_kot_item (billNo, billState, repID, price, qty, remark, kitchen) values (?, ?, ?, ?, ?, ?, ?)', [$billNo, $nextBillState, $repid, $price, $qty, $remark, $kitchen]);

            }
        }


        if($itemCount>0){
            $updateOrderKot = DB::table('order_kot')->where('billNo', $billNo)->update(['billState' => $nextBillState,'status' => '4']);
        }

        return redirect()->route('kotView',compact('billNo'));

    } // End EditOrderAddItem Method

    public function EditOrderItem(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        // Seclet Outlet
        // error_log(session()->get('uotlet'));
        $uotletID = session()->get('uotlet');
        $uotlet = DB::connection('sqlsrv')->table('tblRestName')->where('ResSL', '=', $uotletID)->get();
//        $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();

        $uotletName = "";
        foreach($uotlet as $uotletData){
            $uotletName = $uotletData->ResName;
        }

        $tblMenu_data = DB::connection('sqlsrv')->table('tblMenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();
//        $tblMenu_data = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('outlet', '=', $uotletName)->orderBy('repname')->get();

        $kitchen = array();
        foreach($tblMenu_data as $kitchen_items){
            array_push($kitchen, $kitchen_items->kitchen);
        }
        $kitchen = array_unique($kitchen);

        $billNo = request('billNo');

        $order_kots = DB::table('order_kot')->where('billNo', '=', $billNo)->get();

        foreach ($order_kots as $order_kot) {
            $tableNo = $order_kot->tableNo;
            $room = $order_kot->roomNo;
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

            $date = date('Y-m-d',strtotime($entyDate));
            $time = date('H:m:s',strtotime($entyDate));
        }

        $order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('complete', '=', 'N')->get();

        $allMenuItems = array();

        foreach ($order_kot_items as $order_kot_item) {

            $kotID = $order_kot_item->id;
            $repID = $order_kot_item->repID;
            $qty = $order_kot_item->qty;
            $price = $order_kot_item->price * $qty;

            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID)->get();
//            $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID)->get();
            foreach ($kot_items_selects as $kot_items_select) {
                $repname = $kot_items_select->repname;
                $kitchens = $kot_items_select->kitchen;
            }

            array_push($allMenuItems, array("kotID"=>$kotID, "repID"=>$repID, "repname"=>$repname, "price"=>$price, "qty"=>$qty, "kitchen"=>$kitchens, "remark"=>$order_kot_item->remark));
        }

        $itemcount=1;

        return view('admin.operator.operatorEditOrderItem',compact('tblMenu_data', 'kitchen','billNo','tableNo','room','terminal','serveTime','pax','waterName','gustName','companyName','email','contactNo', 'itemcount', ['allMenuItems']));


    } // End EditOrderItem Method

    public function OrderCancle(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        $billNo = request('billNo');


        $updateOrderKot = DB::table('order_kot')->where('billNo', $billNo)->update(['cancel' => 'Y']);

        return redirect()->route('operator.kotView',compact('billNo'));

    } // End OrderCancle Method

    public function ItemCancle(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        // $id = Auth::user()->id;
        // $username = Auth::user()->username;
        // $profileData = User::find($id);

        $kotID = request('id');


        $updateOrderKot = DB::table('order_kot_item')->where('id', $kotID)->update(['cancel' => 'Y']);

        return true;

    } // End  Cancle Item Method

    public function OperatorKotView(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
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

        $order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('billState', '=', 'A')->get();

        $allMenuItems = array();

        foreach ($order_kot_items as $order_kot_item) {

            $repID = $order_kot_item->repID;
            $qty = $order_kot_item->qty;
            $complete = $order_kot_item->complete;
            $price = $order_kot_item->price * $qty;

            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID)->get();
//            $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID)->get();
            foreach ($kot_items_selects as $kot_items_select) {
                $repname = $kot_items_select->repname;
                $kitchen = $kot_items_select->kitchen;
            }

            array_push($allMenuItems, array("repID"=>$repID, "repname"=>$repname, "price"=>$price, "qty"=>$qty, "kitchen"=>$kitchen, "complete"=>$complete));
        }

        $order_kot_items_new = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('billState', '!=', 'A')->get();
//        dump($order_kot_items_new);
//        die();

        $allMenuItems_new = array();

        foreach ($order_kot_items_new as $order_kot_item_new) {

            $repID_new = $order_kot_item_new->repID;
            $qty_new = $order_kot_item_new->qty;
            $complete = $order_kot_item_new->complete;
            $price_new = $order_kot_item_new->price * $qty_new;

            $kot_items_selects_new = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID_new)->get();
//            $kot_items_selects_new = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID_new)->get();
            foreach ($kot_items_selects_new as $kot_items_select_new) {
                $repname_new = $kot_items_select_new->repname;
                $kitchen_new = $kot_items_select_new->kitchen;
            }

            array_push($allMenuItems_new, array("repID"=>$repID_new, "repname"=>$repname_new, "price"=>$price_new, "qty"=>$qty_new, "kitchen"=>$kitchen_new, "complete"=>$complete));
        }

        $cancel_order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'Y')->get();

        $cancel_allMenuItems = array();

        foreach ($cancel_order_kot_items as $cancel_order_kot_item) {

            $cancel_repID = $cancel_order_kot_item->repID;
            $cancel_qty = $cancel_order_kot_item->qty;
            $cancel_price = $cancel_order_kot_item->price * $cancel_qty;

            $cancel_kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $cancel_repID)->get();
//            $cancel_kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $cancel_repID)->get();
            foreach ($cancel_kot_items_selects as $cancel_kot_items_select) {
                $cancel_repname = $cancel_kot_items_select->repname;
                $cancel_kitchen = $cancel_kot_items_select->kitchen;
            }

            array_push($cancel_allMenuItems, array("repID"=>$cancel_repID, "repname"=>$cancel_repname, "price"=>$cancel_price, "qty"=>$cancel_qty, "kitchen"=>$cancel_kitchen));
        }

        $itencount=1;
        $itencount_new=1;
        $cancel_itencount=1;

        return view('admin.operator.kotView',compact('billNo','tableNo','roomNo','terminal','serveTime','pax','waterName','gustName','companyName','email','contactNo', 'itencount', 'itencount_new', 'cancel_itencount', 'cancel', 'status', 'date', 'time', ['allMenuItems'], ['allMenuItems_new'], ['cancel_allMenuItems']));
    } // End OperatorKOTView Method

    public function OperatorSendToKOT(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $profileData = User::find($id);

        $billNo = request('billNo');


        $order_kots = DB::table('order_kot')->where('billNo', '=', $billNo)->get();


        foreach ($order_kots as $order_kot) {
            $tableNo = $order_kot->tableNo;
            if($tableNo==""){$tableNo='N/A';}
            $roomNo = $order_kot->roomNo;
            if($roomNo==""){$roomNo='0';}
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

            $date = date('Y-m-d',strtotime($entyDate));
            $time = date('H:m:s',strtotime($entyDate));
        }

        $order_kot_items = DB::table('order_kot_item')->where('billNo', '=', $billNo)->where('cancel', '=', 'N')->where('status', '=', '1')->get();



        foreach ($order_kot_items as $order_kot_item) {

            $uotletID = session()->get('uotlet');
            $uotlet = DB::connection('sqlsrv')->table('tblRestName')->where('ResSL', '=', $uotletID)->get();
//            $uotlet = DB::connection('mysql')->table('rest_fortis.tblrestname')->where('ResSL', '=', $uotletID)->get();

            $uotletName = "";
            foreach($uotlet as $uotletData){
                $uotletName = $uotletData->ResName;
            }

            $repID = $order_kot_item->repID;
            $qty = $order_kot_item->qty;
            $price = $order_kot_item->price;

            $total_price = $price * $qty;

            $kot_items_selects = DB::connection('sqlsrv')->table('tblMenu')->where('repid', '=', $repID)->get();
//            $kot_items_selects = DB::connection('mysql')->table('rest_fortis.tblmenu')->where('repid', '=', $repID)->get();
            foreach ($kot_items_selects as $kot_items_select) {
                $repname = $kot_items_select->repname;
                $kitchen = $kot_items_select->kitchen;
                $foodtype = $kot_items_select->foodtype;
            }

            $waiter_selects = DB::connection('sqlsrv')->table('tblWaiter')->where('Name', '=', $waterName)->get();
//            $waiter_selects = DB::connection('mysql')->table('rest_fortis.tblwaiter')->where('Name', '=', $waterName)->get();
            $waiterno = 0;
            foreach ($waiter_selects as $waiter_select) {
                $waiterno = $waiter_select->waiterno;
            }




            $date_time = array( 'date' => $date.' '.$time, 'timezone_type' => '3', 'timezone' => 'Asia/Dhaka' );

            if(DB::connection('sqlsrv')->insert('insert into tblSales (itemcode, kotno, itemname, quentity, unitprice, totalprice, date, tableno, roomno, waiterno, time, cancel, paid, Closer, staffno, billprint, entrytime, itementryuser, printuser, KotMain, person, foodtype, kitchen, discount, disAmt, Flug, Course, Fire, Remarks, outlet, paymode, billno, ResSL) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$repID, $billNo, $repname, $qty, $price, $total_price, $date , $tableNo, $roomNo, $waiterno, $serveTime, 'N',  'N', 'N', '1', 'N', $time, $waterName, 'RES', '11', $pax, $foodtype, $kitchen, '0', '.00', '0', 'N/A', '0', 'spicy', $uotletName, 'N/A', '3', $uotletID])){
//            DB::enableQueryLog();
//            if(DB::connection('mysql')->insert('insert into rest_fortis.tblsales (itemcode, kotno, itemname, quentity, unitprice, totalprice, date, tableno, roomno, waiterno, time, cancel, paid, Closer, staffno, billprint, entrytime, itementryuser, printuser, KotMain, person, foodtype, kitchen, discount, disAmt, Flug, Course, Fire, Remarks, outlet, paymode, billno, ResSL) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$repID, $billNo, $repname, $qty, $price, $total_price, $date , $tableNo, $roomNo, $waiterno, $serveTime, 'N',  'N', 'N', '1', 'N', $time, $waterName, 'RES', '11', $pax, $foodtype, $kitchen, '0', '.00', '0', 'N/A', '0', 'spicy', $uotletName, 'N/A', '3', $uotletID])){
                $order_kot_sent_cash = DB::table('order_kot')->where('billNo', $billNo)->update(['status' => '2']);
            }
//            dd(DB::getQueryLog());
        }

        return redirect()->route('operatorCompleteKOTHistory');

    } // End OperatorSendToKOT Method

    public function OperatorOrderHistry(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        date_default_timezone_set('Asia/Dhaka');

        $date = request('date');

        if(isset($date) and !empty($date)){
            $timestamp = strtotime($date);
            $date = date("Y-m-d",$timestamp);
            // echo $date;
        }else{
            $timestamp = time();
            $date = date("Y-m-d", $timestamp);
        }

        $order_kots = DB::table('order_kot')->whereDate('date', '=', $date)->get();
        // $order_kots = DB::table('order_kot')->get();

        return view('admin.operator.operatorOrderHistry',compact('profileData', 'order_kots'));
    } // End OperatorOrderHistry Method

    public function OperatorPendingKOT(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }else{
            $outlet = session()->get('uotlet');
        }

        $pending_kots = DB::table('order_kot')->where('cancel', '=', 'N')->where('ResSL',$outlet)
            ->where('userID',Auth::user()->username)
            ->where(static function ($query) {
                $query->where('status', '=', '1')
                    ->orWhere('status', '=', '4');
            })->orderBy('date', 'DESC')->get();

        return view('admin.operator.operatorPendingKOT',compact('profileData', 'pending_kots'));
    } // End OperatorPandingKOT Method

    public function KitchenCompleteKotHistory(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);


        $kitchen_complete_kots = DB::table('order_kot')->where('cancel', '=', 'N')->where('status', '=', '3')->get();

        return view('admin.operator.operatorKitchenCompleteKOTHistory',compact('profileData', 'kitchen_complete_kots'));
    } // End KitchenCompleteKot Method

    public function OperatorTotalKOT(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        date_default_timezone_set('Asia/Dhaka');

        $timestamp = time();
        $date = date("Y-m-d", $timestamp);

        $total_kots = DB::table('order_kot')->where('cancel', '=', 'N')->whereDate('date', '=', $date)->get();

        return view('admin.operator.operatorTotalKOT',compact('profileData', 'total_kots'));
    } // End OperatorTotalKOT Method

    public function OperatorCashPrint(){
        if (empty(session()->get('uotlet'))){
            return redirect()->route('outlets');
        }
        $id = Auth::user()->id;
        $profileData = User::find($id);

        date_default_timezone_set('Asia/Dhaka');


        $timestamp = time();
        $date = date("Y-m-d", $timestamp);



        $cashPrint = DB::table('order_kot')->where('cancel', '=', 'N')->where('status', '=', '2')->whereDate('date', '=', $date)->get();

        return view('admin.operator.operatorCashPrint',compact('profileData', 'cashPrint'));
    } // End OperatorCashPrint Method
}
