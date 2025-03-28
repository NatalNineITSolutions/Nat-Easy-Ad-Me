<?php

namespace App\Providers;

use App\Facades\ModuleDataFacade;
use App\Helpers\ModuleMetaData;
use App\Models\Backend\Language;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('ModuleDataFacade', function () {
            return new ModuleMetaData();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        try {
            $all_language = Language::all();
        } catch (\Exception $e) {
            $all_language = null;
        }

        Paginator::useBootstrap();

        if (get_static_option('site_force_ssl_redirection') === 'on') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        $this->loadViewsFrom(__DIR__.'/../../plugins/PageBuilder/views', 'pagebuilder');

        // Share authenticated user globally across all views
        View::composer('*', function ($view) {
            $view->with('user', Auth::user());
        });
    }

    // public function boot(): void
    // {
    //     Schema::defaultStringLength(191);

    //     try {
    //         $all_language = Language::all();
    //     } catch (\Exception $e) {
    //         $all_language = null;
    //     }

    //     Paginator::useBootstrap();

    //     if (get_static_option('site_force_ssl_redirection') === 'on') {
    //         URL::forceScheme('https');
    //     }

    //     $this->loadViewsFrom(__DIR__ . '/../../plugins/PageBuilder/views', 'pagebuilder');

    //     View::composer('*', function ($view) {
    //         $user = Auth::user();
    //         $view->with('user', $user);
            
    //         if ($user) {
    //             $user_ads_posted = $user->listings->count();
    //         } else {
    //             $user_ads_posted = 0;
    //         }

    //         if ($user) {
    //             $userWithData = User::with(['membershipUser', 'membershipHistory'])
    //                 ->withCount('listings')
    //                 ->find($user->id);

    //             // Get remaining listings from membership history
    //             $remaining_listings = optional($userWithData->membershipHistory)->listing_limit - $user_ads_posted ?? 0;
    //             $listing_limit = optional($userWithData->membershipUser)->listing_limit ?? 0;
    //             $user_ads_posted = $userWithData->listings_count;

    //             // Only show upgrade when exactly 0 remaining
    //             $show_upgrade = ($listing_limit > 0 && $remaining_listings === 0);

    //             $view->with([
    //                 'global_reached_limit' => $show_upgrade,
    //                 'global_listing_limit' => $listing_limit,
    //                 'global_user_ads_posted' => $user_ads_posted,
    //                 'global_remaining_listings' => $remaining_listings === 0 ? 0 : $remaining_listings
    //             ]);
    //         }
    //     });
    // }
}
