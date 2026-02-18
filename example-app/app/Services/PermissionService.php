<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;

class PermissionService
{
    /**
     * Check if user can register new users
     */
    public static function canRegisterUsers(User $user): bool
    {
        return $user->role->canRegisterUsers();
    }

    /**
     * Check if user can manage users
     */
    public static function canManageUsers(User $user): bool
    {
        return $user->role->canManageUsers();
    }

    /**
     * Check if user can create tasks
     */
    public static function canCreateTask(User $user): bool
    {
        return $user->role->canCreateTask();
    }

    /**
     * Check if user can create projects
     */
    public static function canCreateProject(User $user): bool
    {
        return $user->role->canCreateProject();
    }

    /**
     * Check if user can delete project
     */
    public static function canDeleteProject(User $user): bool
    {
        return $user->role->canDeleteProject();
    }

    /**
     * Check if user can delete task
     */
    public static function canDeleteTask(User $user): bool
    {
        return $user->role->canDeleteTask();
    }

    /**
     * Check if user can edit task
     */
    public static function canEditTask(User $user, $task): bool
    {
        // Admin can edit any task
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        // User can edit their own tasks
        return $task->assigned_to === $user->id || $task->created_by === $user->id;
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Check if user is developer
     */
    public static function isDeveloper(User $user): bool
    {
        return in_array($user->role, UserRole::developerRoles());
    }

    /**
     * Get available roles for registration (only admin can see all)
     */
    public static function getAvailableRoles(User $user): array
    {
        if ($user->role === UserRole::ADMIN) {
            return [
                UserRole::CUSTOMER->value => UserRole::CUSTOMER->label(),
                UserRole::DEVELOPER->value => UserRole::DEVELOPER->label(),
                UserRole::FRONTEND->value => UserRole::FRONTEND->label(),
                UserRole::BACKEND->value => UserRole::BACKEND->label(),
                UserRole::SERVER_ADMIN->value => UserRole::SERVER_ADMIN->label(),
                UserRole::ADMIN->value => UserRole::ADMIN->label(),
            ];
        }

        // Non-admin users cannot register anyone
        return [];
    }
}
