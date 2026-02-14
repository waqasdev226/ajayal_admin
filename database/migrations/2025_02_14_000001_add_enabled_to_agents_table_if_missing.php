<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'enabled' to agents if missing (e.g. older DB created before column was in schema).
     */
    public function up(): void
    {
        if (Schema::hasTable('agents') && ! Schema::hasColumn('agents', 'enabled')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->boolean('enabled')->default(true)->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('agents') && Schema::hasColumn('agents', 'enabled')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->dropColumn('enabled');
            });
        }
    }
};
