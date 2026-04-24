<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User|Admin $user): bool
    {
        return $this->hasCoursePermission($user, 'view-course');
    }

    public function view(User|Admin $user, Course $course): bool
    {
        return $this->hasCoursePermission($user, 'view-course');
    }

    public function create(User|Admin $user): bool
    {
        return $this->hasCoursePermission($user, 'create-course');
    }

    public function update(User|Admin $user, Course $course): bool
    {
        return $this->hasCoursePermission($user, 'edit-course');
    }

    public function delete(User|Admin $user, Course $course): bool
    {
        return $this->hasCoursePermission($user, 'delete-course');
    }

    private function hasCoursePermission(User|Admin $user, string $permission): bool
    {
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission, $this->resolveGuardName($user));
        }

        return $user instanceof Admin && ($user->status ?? 'Inactive') === 'Active';
    }

    private function resolveGuardName(User|Admin $user): string
    {
        if ($user instanceof Admin) {
            return 'admin';
        }

        return 'web';
    }
}
