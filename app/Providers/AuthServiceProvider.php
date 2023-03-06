<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

                /* define a admin user role */
                Gate::define('isAdmin', function($user) {
                    return $user->role == 'admin';
                 });
                
                 /* define a manager user role */
                 Gate::define('isTechnician', function($user) {
                     return $user->role == 'technician';
                 });
                 Gate::define('isStaff', function($user) {
                    return $user->role == 'staff';
                });
              
                 /* define a user role */
                 Gate::define('isStudent', function($user) {
                     return $user->role == 'student';
                 });
    }
}
