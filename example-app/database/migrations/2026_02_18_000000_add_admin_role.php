<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The role column already exists in users table,
        // this migration just ensures 'admin' role is available
        // Add any additional admin-specific columns here if needed
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
