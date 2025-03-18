<?php

namespace App\Providers;

use App\Facades\ModuleDataFacade;
use App\Helpers\ModuleMetaData;
use App\Models\Backend\Language;
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
        $this->app->bind('ModuleDataFacade',function(){
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
}
