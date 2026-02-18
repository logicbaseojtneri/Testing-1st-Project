<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Enums\UserRole;

class ProjectAssignmentService
{
    /**
     * Automatically assign developers to a project
     * Assigns the least-loaded Frontend Developer, Backend Developer, and Server Administrator
     */
    public function assignDevelopersToProject(Project $project): array
    {
        $assigned = [];

        $frontendDev = $this->getLeastLoadedDeveloper(UserRole::FRONTEND);
        $backendDev = $this->getLeastLoadedDeveloper(UserRole::BACKEND);
        $serverAdmin = $this->getLeastLoadedDeveloper(UserRole::SERVER_ADMIN);

        if ($frontendDev) {
            $project->update(['frontend_dev_id' => $frontendDev->id]);
            $assigned['frontend'] = $frontendDev;
        }

        if ($backendDev) {
            $project->update(['backend_dev_id' => $backendDev->id]);
            $assigned['backend'] = $backendDev;
        }

        if ($serverAdmin) {
            $project->update(['server_admin_id' => $serverAdmin->id]);
            $assigned['server_admin'] = $serverAdmin;
        }

        // Sync as project members
        $this->syncProjectMembers($project);

        return $assigned;
    }

    /**
     * Auto-assign a specific role slot on a project
     */
    public function autoAssignRole(Project $project, string $roleSlot): ?User
    {
        $roleMap = [
            'frontend_dev_id' => UserRole::FRONTEND,
            'backend_dev_id' => UserRole::BACKEND,
            'server_admin_id' => UserRole::SERVER_ADMIN,
        ];

        if (!isset($roleMap[$roleSlot])) {
            return null;
        }

        $dev = $this->getLeastLoadedDeveloper($roleMap[$roleSlot]);

        if ($dev) {
            $project->update([$roleSlot => $dev->id]);
            $this->syncProjectMembers($project);
        }

        return $dev;
    }

    /**
     * Get the developer with the fewest active project assignments for the given role
     */
    protected function getLeastLoadedDeveloper(UserRole $role): ?User
    {
        $columnMap = [
            UserRole::FRONTEND->value => 'frontend_dev_id',
            UserRole::BACKEND->value => 'backend_dev_id',
            UserRole::SERVER_ADMIN->value => 'server_admin_id',
        ];

        $column = $columnMap[$role->value] ?? null;

        if (!$column) {
            return User::where('role', $role->value)->first();
        }

        return User::where('role', $role->value)
            ->orderByRaw(
                '(SELECT COUNT(*) FROM projects WHERE projects.' . $column . ' = users.id AND projects.deleted_at IS NULL) ASC'
            )
            ->first();
    }

    /**
     * Sync project members based on assigned dev columns (public wrapper)
     */
    public function syncProjectMembersPublic(Project $project): void
    {
        $this->syncProjectMembers($project);
    }

    /**
     * Sync project members based on assigned dev columns
     */
    protected function syncProjectMembers(Project $project): void
    {
        $members = [];

        if ($project->frontend_dev_id) {
            $members[$project->frontend_dev_id] = ['role' => 'frontend'];
        }

        if ($project->backend_dev_id) {
            $members[$project->backend_dev_id] = ['role' => 'backend'];
        }

        if ($project->server_admin_id) {
            $members[$project->server_admin_id] = ['role' => 'server_admin'];
        }

        if (!empty($members)) {
            $project->members()->syncWithoutDetaching($members);
        }
    }
}
