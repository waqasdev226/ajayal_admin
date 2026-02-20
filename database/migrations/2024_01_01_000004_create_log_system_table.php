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
        if (Schema::hasTable('log_system')) {
            return;
        }
        Schema::create('log_system', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->text('url_request')->nullable();
            $table->string('entity_name')->nullable();
            $table->string('entity_id')->nullable();
            $table->text('description')->nullable();
            $table->longText('pre_data')->nullable();
            $table->longText('post_data')->nullable();
            $table->string('host_address')->nullable();
            $table->string('host_name')->nullable();
            $table->string('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_system');
    }
};
