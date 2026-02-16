<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing tasks with 'pending' status to 'review'
        DB::table('tasks')->where('status', 'pending')->update(['status' => 'review']);
    }

    public function down(): void
    {
        DB::table('tasks')->where('status', 'review')->update(['status' => 'pending']);
    }
};
