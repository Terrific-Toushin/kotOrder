<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FormData;
use App\Models\MastersProgram;
use App\Models\PaymentDetails;
use App\Models\StudentInfo;
use App\Models\UserPrivileges;
use Response;
use DB;
use Auth;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class AdminDashboardController extends Controller
{
    public function index(){

        $users = UserPrivileges::selectRaw('count(user_id) as total, SUM(CASE WHEN user_type = "operator" THEN 1 ELSE 0 END) as operator_count,
                            SUM(CASE WHEN user_type = "AU" THEN 1 ELSE 0 END) as admins_count,
                            SUM(CASE WHEN user_type = "kitchen" THEN 1 ELSE 0 END) as kitchen_count')
            ->first();
        $panding_kots_count = DB::table('order_kot')->where('cancel', '=', 'N')->where(function ($q) {$q->where('status', '=', '1')->orWhere('status', '=', '4');})->count();
        $kitchen_complete_kot_count = DB::table('order_kot')->where('status', '=', '3')->where('cancel', '=', 'N')->count();
        $total_kots_count = DB::table('order_kot')->where('cancel', '=', 'N')->count();
        $cash_print_count = DB::table('order_kot')->where('status', '=', '2')->where('cancel', '=', 'N')->count();
        $kot_cancel_count = DB::table('order_kot')->where('cancel', '=', 'Y')->count();
        // $outlets_count=DB::table('order_kot')->selectRaw('outlet, SUM(CASE WHEN cancel = "N" AND (status = "1" OR status = "4") THEN 1 ELSE 0 END) as panding_kots_count,
        //                             SUM(CASE WHEN cancel = "N" AND status = "3" THEN 1 ELSE 0 END) as kitchen_complete_kot_count,
        //                             SUM(CASE WHEN cancel = "N" THEN 1 ELSE 0 END) as total_kots_count,
        //                             SUM(CASE WHEN cancel = "N" AND status = "2" THEN 1 ELSE 0 END) as cash_print_count,
        //                             SUM(CASE WHEN cancel = "Y" THEN 1 ELSE 0 END) as kot_cancel_count')
        //     ->first();
        $outlets_count=[];
        return view('admin.dashboard.dashboard')->with(compact('users','panding_kots_count','kitchen_complete_kot_count','total_kots_count','cash_print_count','outlets_count'));
    }

    public function redirects(){
        $role = Auth::user()->role;
        if ($role == 'admin'){
            return redirect()->route('adminDashboard');
        }elseif ($role == 'operator'){
            return redirect()->route('operatorDashboard');
        }elseif ($role == 'kitchen'){
            return redirect()->route('kitchenDashboard');
        }
    }

    public function allCourseDownload($type){

        $page_type = ['master','courses'];
//        DB::enableQueryLog();
        if($type == 'master'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Master's Program")->get();
        }elseif ($type == 'certificate'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Certificate Course")->get();
        }elseif ($type == 'diploma'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Post Graduate Diploma")->get();
        }elseif ($type == 'certification'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Certification Program")->get();
        }else{
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)->get();
        }
//        dd(DB::getQueryLog());
//        dump($studentCourses);
//        die();
        $studentPrograms = [];
        if($studentCourses){
            foreach ($studentCourses as $studentCours){
                if ($studentCours->page_type == 'master'){
                    $studentPrograms[$studentCours->program_id] = MastersProgram::select('tittle','amount')->where('masters_program_id',$studentCours->program_id)->first();
                }elseif ($studentCours->page_type == 'v'){
                    $studentPrograms[$studentCours->program_id] = Course::select('tittle','amount')->where('course_id',$studentCours->program_id)->first();
                }
            }
        }
        $paymentStatus = config("dashboard_constant.PAYMENT_STATUS");
        $csvData = [];
        $headers = ['SL','Student Name', 'Course Type', 'Course Name', 'Amount', 'Applied', 'Status']; // Add headers here
        $csvData[] = $headers;
        foreach ($studentCourses as $key=>$studentCourse) {
            $csvData[] = [
                'Sl.' => $key + 1,
                'Student Name' => $studentCourse->first_name,
                'Course Type' => $studentCourse->page_name,
                'Course Name' => !empty($studentPrograms) && isset($studentPrograms[$studentCourse->program_id]) ? $studentPrograms[$studentCourse->program_id]->tittle : "",
                'Amount' => !empty($studentPrograms) && isset($studentPrograms[$studentCourse->program_id]) ? $studentPrograms[$studentCourse->program_id]->amount : "0",
                'Applied' => $studentCourse->created_at,
                'Status' => isset($paymentStatus[$studentCourse->paid_status]) ? $paymentStatus[$studentCourse->paid_status] : $studentCourse->paid_status,
                // Add more fields as needed
            ];
        }
//        dump($csvData);
//        die();

        $csvFileName = date('d-m-Y').'_'.$type.'_'.'Course.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        return Response::stream(function () use ($csvData) {
            $file = fopen('php://output', 'w');

            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        }, 200, $headers);
//        return view('admin.dashboard.dashboard')->with(compact('studentCourses','paymentStatus','studentPrograms'));
    }

    public function allCourseDownloadPDF($type){

        $page_type = ['master','courses'];
//        DB::enableQueryLog();
        if($type == 'master'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Master's Program")->get();
        }elseif ($type == 'certificate'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "Certificate Course")->get();
        }elseif ($type == 'diploma'){
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)
                ->where('pages.page_name', "diploma")->get();
        }else{
            $studentCourses = FormData::select('form_data.*','pages.page_name','pages.page_type','payment_details.paid_status','student_info.first_name')
                ->leftJoin('pages','form_data.page_id','=','pages.page_id')
                ->leftJoin('payment_details','form_data.form_id','=','payment_details.form_id')
                ->leftJoin('student_info','form_data.student_id','=','student_info.id')
                ->whereIn('pages.page_type', $page_type)->get();
        }
//        dd(DB::getQueryLog());
//        dump($studentCourses);
//        die();
        $studentPrograms = [];
        if($studentCourses){
            foreach ($studentCourses as $studentCours){
                if ($studentCours->page_type == 'master'){
                    $studentPrograms[$studentCours->program_id] = MastersProgram::select('tittle','amount')->where('masters_program_id',$studentCours->program_id)->first();
                }elseif ($studentCours->page_type == 'v'){
                    $studentPrograms[$studentCours->program_id] = Course::select('tittle','amount')->where('course_id',$studentCours->program_id)->first();
                }
            }
        }
        $paymentStatus = config("dashboard_constant.PAYMENT_STATUS");
        $csvData = [];
        $headers = ['SL','Student Name', 'Course Type', 'Course Name', 'Amount', 'Applied', 'Status']; // Add headers here
        $csvData[] = $headers;
        foreach ($studentCourses as $key=>$studentCourse) {
            $csvData[] = [
                'Sl.' => $key + 1,
                'Student Name' => $studentCourse->first_name,
                'Course Type' => $studentCourse->page_name,
                'Course Name' => !empty($studentPrograms) && isset($studentPrograms[$studentCourse->program_id]) ? $studentPrograms[$studentCourse->program_id]->tittle : "",
                'Amount' => !empty($studentPrograms) && isset($studentPrograms[$studentCourse->program_id]) ? $studentPrograms[$studentCourse->program_id]->amount : "0",
                'Applied' => $studentCourse->created_at,
                'Status' => isset($paymentStatus[$studentCourse->paid_status]) ? $paymentStatus[$studentCourse->paid_status] : $studentCourse->paid_status,
                // Add more fields as needed
            ];
        }
//        dump($csvData);
//        die();

        $csvFileName = date('d-m-Y').'_'.$type.'_'.'Course.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        return Response::stream(function () use ($csvData) {
            $file = fopen('php://output', 'w');

            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        }, 200, $headers);
//        return view('admin.dashboard.dashboard')->with(compact('studentCourses','paymentStatus','studentPrograms'));
    }

}
