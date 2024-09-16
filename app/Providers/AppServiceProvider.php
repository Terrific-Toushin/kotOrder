<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//
//        $dbDateGet = DB::connection('sqlsrv')->table('tbldate')->first();
//        $dbDateOnly = mb_substr($dbDateGet->SDATE, 0, 10);
//        $dbDate = date("d-m-Y", strtotime($dbDateOnly));
//        View::composer('*', function ($view) use ($dbDate) {
//            $view->with(compact('dbDate'));
//        });
    }
}
