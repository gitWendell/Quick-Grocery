<?php

namespace App\Providers;

use App\Observers\Customer\OrderDetailsObserver;
use App\Observers\Customer\OrderMasterObserver;
use App\OrderDetails;
use App\OrderMaster;
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
        //
        OrderMaster::observe(OrderMasterObserver::class);
        OrderDetails::observe(OrderDetailsObserver::class);
    }
}
