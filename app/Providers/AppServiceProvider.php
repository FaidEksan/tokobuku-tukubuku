<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

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
        // Menyuntikkan data cart ke navbar web
        View::composer('layouts.web.partials.navbar_web', function ($view) {
            // Jika pengguna login
            if (auth()->check()) {
                $cartTotal = Cart::where('user_id', auth()->id())->sum('qty');
            } else {
                $cartTotal = 0;
            }

            // Mengirimkan jumlah cart ke navbar
            $view->with('cartTotal', $cartTotal);
        });
    }
}