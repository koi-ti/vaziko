<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Base\Empresa;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set paginate in al views
        view()->composer('*.index', function ($view) {
            $view->with('companyPagination', Empresa::value('empresa_paginacion'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
