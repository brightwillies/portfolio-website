<?php
namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        view()->composer('*', function ($view) {

            $customer_id = "";
            $customer_name = 'Hello Guest';
            if (\Session::get('eaglexpress-loggedin-name')) {
                $customer_name = "Hello " . \Session::get('eaglexpress-loggedin-name');

                $userData   = \Session::get('eaglexpress-loggedin');
                $customer_id = $userData['c_table_id'];
            }

            $view->with('customer_id',   $customer_id);
            $view->with('customer_name', $customer_name);

        });

        Schema::defaultStringLength(191);
    }
}
