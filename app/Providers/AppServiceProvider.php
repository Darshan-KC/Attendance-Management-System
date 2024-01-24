<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else{
            if (auth()->check()) {
                // The user is logged in, so you can access their company property
                if (count(Auth::user()->company) != 0) {
                    $company_id = Auth::user()->company->id;

                } else{
                    $company_id = 0;
                }
                $count = Manage::where('manager_id', Auth::user()->role_id)->where('company_id', $company_id)->count();
            } else {
                $count = 0; // User is not logged in
            }
        }
        view()->share('cnt', Config::get('attendanceSideBar.cnt'));
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        // Share the data with all views
        view()->share('cnt', $count);
    }
}
