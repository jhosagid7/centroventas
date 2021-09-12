<?php

namespace App\Providers;

use App\Sessioncaja;
// use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SessionCajaProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $session_caja_id = \Session::get('session_caja_id');
            $session_caja = Sessioncaja::buscarOrCrearIDSession($session_caja_id);
            \Session::put('session_caja_id', $session_caja->id);
            $view->with('session_caja', $session_caja);
        });
    }
}
