<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_webhook_events', function (Blueprint $table) {
            $table->string('event_id')->primary();
            $table->string('event_type');
            $table->string('environment')->default('live');
            $table->uuid('registration_id')->nullable();
            $table->timestamp('processed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_webhook_events');
    }
};
