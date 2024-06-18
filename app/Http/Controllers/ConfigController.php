<?php

namespace App\Http\Controllers;

use App\Mail\CustomVerificationEmail;
use Illuminate\Support\Facades\Mail;

class ConfigController extends Controller
{
    public function clearRoute()
    {
        \Artisan::call('route:clear');
        return 'Routes cache cleared';
    }
    public function clearCache()
    {
        \Artisan::call('config:cache');
        return 'Config cache cleared';
    }

    public function testEmail()
    {
        try{
            Mail::to('toushin.java@gmail.com')->send(new CustomVerificationEmail('Mail Tester','toushin.java@gmail.com', '87654321', route('verification.verify', ['id' => '2308000001', 'hash' => sha1('toushin.java@gmail.com')])));
            return 'Mail send';
        }
        catch (Exception $exception){
            return json_encode($exception);
        }
    }
}
