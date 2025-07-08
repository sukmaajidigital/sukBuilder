<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DynamicTable;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            // Kita akan ambil semua tabel dinamis untuk dijadikan item menu
            $dynamicMenuItems = DynamicTable::select('name', 'slug')->get();
            $view->with('dynamicMenuItems', $dynamicMenuItems);
        });
    }
}
