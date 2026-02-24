<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }
        if (Schema::hasColumn('users', 'start_contract')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->date('start_contract')->nullable()->after('contract_ref');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('start_contract');
        });
    }
};
