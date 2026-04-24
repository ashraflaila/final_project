<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Admin;
use App\Policies\CoursePolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();

        Gate::policy(Course::class, CoursePolicy::class);

        Gate::before(function ($user, string $ability) {
            if (method_exists($user, 'hasRole') && $user->hasRole('Super Admin', $this->resolveGuardName($user))) {
                return true;
            }

            return null;
        });

        Gate::define('view-course', function ($user) {
            return $this->hasPermission($user, 'view-course');
        });

        Gate::define('create-course', function ($user) {
            return $this->hasPermission($user, 'create-course');
        });

        Gate::define('edit-course', function ($user) {
            return $this->hasPermission($user, 'edit-course');
        });

        Gate::define('delete-course', function ($user) {
            return $this->hasPermission($user, 'delete-course');
        });
    }

    private function hasPermission($user, string $permission): bool
    {
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission, $this->resolveGuardName($user));
        }

        return $user instanceof Admin && ($user->status ?? 'Inactive') === 'Active';
    }

    private function resolveGuardName($user): string
    {
        if ($user instanceof Admin) {
            return 'admin';
        }

        return 'web';
    }
}
