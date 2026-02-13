<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Enums\UserRole;

class ProjectAssignmentService
{
    /**
     * Automatically assign developers to a project
     * Assigns 1 Frontend Developer, 1 Backend Developer, and 1 Server Administrator
     */
    public function assignDevelopersToProject(Project $project): void
    {
        $frontendDev = User::where('role', UserRole::FRONTEND_DEV)->first();
        $backendDev = User::where('role', UserRole::BACKEND_DEV)->first();
        $serverAdmin = User::where('role', UserRole::SERVER_ADMIN)->first();

        if ($frontendDev) {
            $project->update(['frontend_dev_id' => $frontendDev->id]);
        }

        if ($backendDev) {
            $project->update(['backend_dev_id' => $backendDev->id]);
        }

        if ($serverAdmin) {
            $project->update(['server_admin_id' => $serverAdmin->id]);
        }

        // Add developers as members of the project
        if ($frontendDev) {
            $project->members()->syncWithoutDetaching([
                $frontendDev->id => ['role' => 'frontend_dev'],
            ]);
        }

        if ($backendDev) {
            $project->members()->syncWithoutDetaching([
                $backendDev->id => ['role' => 'backend_dev'],
            ]);
        }

        if ($serverAdmin) {
            $project->members()->syncWithoutDetaching([
                $serverAdmin->id => ['role' => 'server_admin'],
            ]);
        }
    }
}
