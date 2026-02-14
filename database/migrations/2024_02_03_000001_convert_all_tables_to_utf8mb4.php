<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration ensures all tables use UTF8MB4 encoding for proper Arabic support
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return;
        }

        // Set database default charset
        $database = env('DB_DATABASE', 'laravel');
        
        DB::statement("ALTER DATABASE `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        // List of all tables to convert
        $tables = [
            'users',
            'agents',
            'setting',
            'transaction',
            'log_system',
            'profit_ratio_log',
            'users_otp',
            'withdraw',
            'password_reset_tokens',
            'failed_jobs',
            'personal_access_tokens',
            'migrations',
        ];
        
        foreach ($tables as $table) {
            // Check if table exists before converting
            $tableExists = DB::select("SHOW TABLES LIKE '{$table}'");
            
            if (!empty($tableExists)) {
                // Convert table to utf8mb4
                DB::statement("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Get all text columns and convert them specifically
                $columns = DB::select("SHOW FULL COLUMNS FROM `{$table}` WHERE Type LIKE '%char%' OR Type LIKE '%text%'");
                
                foreach ($columns as $column) {
                    $columnName = $column->Field;
                    $columnType = $column->Type;
                    $nullable = $column->Null === 'YES' ? 'NULL' : 'NOT NULL';
                    $default = $column->Default !== null ? "DEFAULT '{$column->Default}'" : '';
                    
                    // Modify each text column to ensure utf8mb4
                    if (!empty($columnType)) {
                        DB::statement("ALTER TABLE `{$table}` MODIFY `{$columnName}` {$columnType} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci {$nullable} {$default}");
                    }
                }
                
                echo "✅ Converted table: {$table}\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert to utf8 (not recommended)
        // This is left empty as reverting UTF8MB4 is not typically needed
    }
};
