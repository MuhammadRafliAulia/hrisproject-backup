<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bank;
use App\Policies\BankPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Bank::class => BankPolicy::class,
    ];

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
        $this->registerPolicies();
    }

    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            \Illuminate\Support\Facades\Gate::policy($model, $policy);
        }
    }
}

