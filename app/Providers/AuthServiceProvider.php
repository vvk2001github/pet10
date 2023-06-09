<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

// use Illuminate\Auth\Access\Gate;

use App\Models\User;
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
    ];

    /**
     * Register any authentication / authorization services.
     * Set user with ID == 1 as Super Admin
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user, $ability) {
            return $user->hasRole('Super User') ? true : null;
        });
    }
}
