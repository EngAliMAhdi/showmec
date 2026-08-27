<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('registration_id');
            $table->string('event_type');
            $table->json('metadata')->default('{}');
            $table->timestamp('created_at')->nullable();

            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->onDelete('cascade');

            $table->index('registration_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_logs');
    }
};
