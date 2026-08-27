<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waitlist', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('workshop_date');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->unique(['email', 'workshop_date'], 'waitlist_unique_email_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlist');
    }
};
