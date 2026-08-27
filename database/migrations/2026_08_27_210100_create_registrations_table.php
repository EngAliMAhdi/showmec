<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('workshop_date');
            $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->string('payment_status')->default('pending')->index();
            $table->integer('deposit_amount')->default(200);
            $table->string('payment_reference')->nullable();
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->boolean('refund_eligible')->nullable();
            $table->string('cancellation_note')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->integer('invitation_attempts')->default(0);
            $table->timestamp('invitation_last_attempt_at')->nullable();
            $table->timestamp('invitation_next_retry_at')->nullable();
            $table->string('invitation_last_error')->nullable();
            $table->timestamps();

            $table->index('workshop_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
