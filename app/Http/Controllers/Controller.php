<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * get all constant variables
     */
    public function getConstVar(){
        return config("dashboard_constant");
    }
    /**
     * check file exists
     */
    public function isFileExists(Request $request){
        $filePath = $request->query('filepath');
        if(file_exists($filePath)){
            return true;
        }
        return false;
    }

    public function createDBAccessLog($page, $type, $request, $responseMsg){

        $log = new AuditLog;
        $log->user_id = Auth::user()->id;
        $log->date_time = $this->dateToTimestamp(date('Y-m-d H:i:s'));
        $log->page_URL = $page;
        $log->ip = $_SERVER['REMOTE_ADDR'];
        $log->type = $type;
        $logTextRequest = !is_string($request) ? json_encode($request->except('_token')) : $request;
        $logData ['changed_Data'] = json_decode($logTextRequest);
        $logData ['update_Data'] = json_decode(json_encode($responseMsg));
        $logText = json_encode($logData);
        $log->log_text = $logText;

        $log->save();
    }

    public function dateToTimestamp($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->toDateTimeString();
    }
}
