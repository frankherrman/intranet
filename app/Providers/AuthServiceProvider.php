<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // define the roles
        Gate::define('isAdmin', function($user) {
           return $user->hasPermission('ADMIN');
        });

        Gate::define('manageClients', function($user) {
            return $user->hasPermission('MANAGE_CLIENTS');
        });

        Gate::define('manageSla', function($user) {
            return $user->hasPermission('MANAGE_SLA');
        });

        Gate::define('manageProjects', function($user) {
            return $user->hasPermission('MANAGE_PROJECTS');
        });

        Gate::define('manageActivities', function($user) {
            return $user->hasPermission('MANAGE_ACTIVITIES');
        });

        Gate::define('accessTimemanagement', function($user) {
            return $user->hasPermission('TIMEMANAGEMENT');
        });

        Gate::define('viewReporting', function($user) {
            return $user->hasPermission('REPORTING');
        });

        Gate::define('isHr', function($user) {
            return $user->hasPermission('HR');
        });

        Gate::define('accessInvoicing', function($user) {
            return $user->hasPermission('INVOICING');
        });
    }
}
