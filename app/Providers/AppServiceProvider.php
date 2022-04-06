<?php

namespace App\Providers;

use App\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        if (Schema::hasTable('branches')) {

            view()->share('branches', Branch::all());
        }

        view()->share('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        view()->share('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
    }
}
