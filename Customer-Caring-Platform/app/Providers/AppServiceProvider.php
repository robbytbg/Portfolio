<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\UserSheet;
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
        View::composer('*', function ($view) {
            // Get distinct sheet codes from the UserSheet model
            $sheetCodes = UserSheet::distinct()->pluck('sheet_code');
            // Share the sheet codes with all views
            $view->with('sheetCodes', $sheetCodes);
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user && $user->roles) {
                    $view->with('userRoles', $user->roles->pluck('name'));
                } else {
                    $view->with('userRoles', []);
                }
            }
        });        
        Paginator::useBootstrapFive();
    }
}
