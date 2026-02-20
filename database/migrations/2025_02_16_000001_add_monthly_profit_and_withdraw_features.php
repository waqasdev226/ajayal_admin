<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Monthly profit rate per month (admin sets one % for all investors)
        if (!Schema::hasTable('monthly_profit_rates')) {
            Schema::create('monthly_profit_rates', function (Blueprint $table) {
                $table->id();
                $table->string('year_month', 7)->unique(); // e.g. 2025-02
                $table->decimal('percentage', 5, 2);       // e.g. 3.50 for 3.5%
                $table->timestamps();
            });
        }

        // Add month/year to profit_ratio_log for duplicate prevention and reporting
        if (Schema::hasTable('profit_ratio_log') && !Schema::hasColumn('profit_ratio_log', 'year_month')) {
            Schema::table('profit_ratio_log', function (Blueprint $table) {
                $table->string('year_month', 7)->nullable()->after('user_id');
            });
        }

        // Withdraw: reject reason and explicit status (0=pending, 1=approved, 2=rejected)
        if (Schema::hasTable('withdraw') && !Schema::hasColumn('withdraw', 'reject_reason')) {
            Schema::table('withdraw', function (Blueprint $table) {
                $table->text('reject_reason')->nullable()->after('note');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_profit_rates');
        if (Schema::hasTable('profit_ratio_log') && Schema::hasColumn('profit_ratio_log', 'year_month')) {
            Schema::table('profit_ratio_log', fn (Blueprint $table) => $table->dropColumn('year_month'));
        }
        if (Schema::hasTable('withdraw') && Schema::hasColumn('withdraw', 'reject_reason')) {
            Schema::table('withdraw', fn (Blueprint $table) => $table->dropColumn('reject_reason'));
        }
    }
};
