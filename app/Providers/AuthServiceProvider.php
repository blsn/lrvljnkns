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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function($user) {
            return $user->hasAnyRoles(['admin', 'author']); // can manage users
        });

        // Gate::define('edit-users', function($user) {
        //     return $user->hasRole('admin'); // can edit users
        // });

        Gate::define('edit-users', function($user) {
            return $user->hasAnyRoles(['admin', 'author']); // author can edit users
        });

        Gate::define('delete-users', function($user) {
            return $user->hasRole('admin'); // can delete users
        });

        // Gate::define('create-posts', function($user) {
        //     return $user->hasRole('author'); // can create and manage his posts
        // });

        Gate::define('create-posts', function($user) {
            return $user->hasAnyRoles(['admin', 'publisher', 'author']); // can create and manage his posts
        });

        Gate::define('manage-posts', function($user) {
            return $user->hasAnyRoles(['admin', 'publisher']); // can manage posts
        });
    }
}
