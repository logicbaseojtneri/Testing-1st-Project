<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate old role values to new role values
        // This handles existing users with old role names
        
        // Map old roles to new roles
        $roleMapping = [
            'frontend_dev' => 'frontend',
            'backend_dev' => 'backend',
        ];

        foreach ($roleMapping as $oldRole => $newRole) {
            DB::table('users')
                ->where('role', $oldRole)
                ->update(['role' => $newRole]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to old role names if needed
        $roleMapping = [
            'frontend' => 'frontend_dev',
            'backend' => 'backend_dev',
        ];

        foreach ($roleMapping as $newRole => $oldRole) {
            DB::table('users')
                ->where('role', $newRole)
                ->update(['role' => $oldRole]);
        }
    }
};
