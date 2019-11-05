<?php

namespace App\Providers;

use App\SystemSetting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use stdClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //uniquer
        /*Validator::extend('uniqueFirstAndLastName', function ($attribute, $value, $parameters, $validator) {
            $count = DB::table('people')->where('firstName', $value)
                ->where('lastName', $parameters[0])
                ->count();

            return $count === 0;
        });*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share settings to all views
        $settings = SystemSetting::find(1) ?? new stdClass();
        View::share('settings', $settings);
    }
}
