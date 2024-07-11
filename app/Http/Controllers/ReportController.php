<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\ResearchForm;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use DB;

class ReportController extends Controller
{
    public function researchData()
    {
        $allResearch = ResearchForm::select('reasearch_id','researchers_name','researchers_email','researchers_number','created_at')->orderBy('created_at','DESC')->get();
        return view('admin.reportPage.researchList')->with(compact('allResearch'));
    }

    public function researchDetails($id)
    {
        $detailsResearch = ResearchForm::find($id);
        if($detailsResearch){
            $allFormData = json_decode($detailsResearch->form_data);
        }
        return view('admin.reportPage.researchDetails')->with(compact('id','allFormData'));
    }

    public function downloadPDF($filePath)
    {
        // Replace 'your-pdf-filename.pdf' with the actual filename of your PDF.

        $file = public_path(base64_decode($filePath));

        // Check if the file exists
        if (file_exists($file)) {
            // Prepare the response with the file as an attachment
            return Response::download($file, basename($file), ['content-type' => 'application/pdf']);
        } else {
            // Handle the case where the file doesn't exist
            return abort(404);
        }
    }

    public function downloadCSV($id)
    {
        // Replace 'your-pdf-filename.pdf' with the actual filename of your PDF.
        $detailsResearch = ResearchForm::find($id);

        if($detailsResearch) {
            $allFormData = json_decode($detailsResearch->form_data);

            $fileName = $detailsResearch->researchers_name . '_' . $detailsResearch->reasearch_id . '.csv';

            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $columns = array('Research Details','Info');

            $callback = function () use ($allFormData, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($allFormData as $key => $task) {
                    if (stripos($key, "file_name") === false && ($task != null || $task != '')){
                        $row['Research Details'] = ucwords(str_replace('_', ' ', $key));
                        $row['Info'] = $task;
                        fputcsv($file, array($row['Research Details'], $row['Info']));
                    }

                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    public function getLogData()
    {
        $allAuditLog = AuditLog::select('audit_log.*','users.name')->leftJoin('users','audit_log.user_id','=','users.id')->orderBy('created_at','DESC')->paginate(20);
        return view('admin.reportPage.auditList')->with(compact('allAuditLog'));
    }

    public function getPaymentDetails(Request $request){

        $queryParam = $request->query();

        $query = DB::table('payment_details')
            ->leftJoin('form_data', function ($join) {
                $join->on('payment_details.form_id', '=', 'form_data.form_id');
            });
        $query = $query->orderBy('payment_details.updated_at', 'DESC')->get();
//        $authUser = Session::get('loginUser');
        // DB::getQueryLog();
//         dd(DB::getQueryLog());
        //dd($query->toArray());
        $paymentList = $query->toArray();
        $paymentStatus = config("dashboard_constant.PAYMENT_STATUS");
        return view('admin.reportPage.paymentDetails')->with(compact('paymentList','paymentStatus'));
    }

    public function adminKotView(){

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

        return view('admin.reportPage.kotView',compact('billNo','tableNo','roomNo','terminal','serveTime','pax','waterName','gustName','companyName','email','contactNo', 'itencount', 'itencount_new', 'cancel_itencount', 'cancel', 'status', 'date', 'time', ['allMenuItems'], ['allMenuItems_new'], ['cancel_allMenuItems']));
    } // End OperatorKOTView Method


    public function cashPrint(){

        $cashPrint = DB::table('order_kot')->where('cancel', '=', 'N')->where('status', '=', '2')->get();

        return view('admin.reportPage.cashPrint',compact('cashPrint'));
    } // End OperatorCashPrint Method


}
