<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PaymentRepositoryInterface',
            'App\Repositories\PaymentRepository',
        );

        $this->app->bind(
            'App\Repositories\EmployeeRepositoryInterface',
            'App\Repositories\EmployeeRepository'
        );

        $this->app->bind(
            'App\Repositories\PaymentDetailRepositoryInterface',
            'App\Repositories\PaymentDetailRepository'
        );

        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
