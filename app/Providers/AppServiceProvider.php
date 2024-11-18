<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Anda bisa melakukan binding layanan atau menambahkan dependensi lain di sini.
        // Misalnya, mengikat interface ke implementasi layanan tertentu, atau lainnya.
        // Contoh:
        // $this->app->bind(SomeInterface::class, SomeConcreteClass::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengatur default string length untuk schema (untuk kompatibilitas database MySQL)
        Schema::defaultStringLength(191);

        // Menyediakan data global ke semua view jika perlu
        View::share('key', 'value');

        // Contoh pengaturan lainnya
        // Mengatur timezone aplikasi
        config(['app.timezone' => 'Asia/Jakarta']);
    }
}
