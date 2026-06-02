<?php

namespace App\Providers;
/* pendaftaran layanan dan binding aplikasi */

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // kosong: tidak ada layanan tambahan untuk didaftarkan saat ini
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // kosong: tidak ada proses bootstrap tambahan saat ini
    }
}
