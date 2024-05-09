<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Policies\EmployeePolicy;
use App\Policies\OrderPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Order::class => OrderPolicy::class,
        Employee::class => EmployeePolicy::class,
        Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-orders', function (User $user) {
            return $user->isAdmin() || $user->isManager();
        });
    }
}
