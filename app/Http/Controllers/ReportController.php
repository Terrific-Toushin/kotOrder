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


}
