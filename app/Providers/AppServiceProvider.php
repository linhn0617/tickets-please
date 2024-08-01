<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use App\Policies\V1\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*protected $policies = [
        Ticket::class => TicketPolicy::class,
    ];
    */
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
    // Laravel 11手動註冊Policies 需使用以下方法修改，參考資料：https://laravel.com/docs/11.x/authorization#manually-registering-policies
    public function boot(): void
    {
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
