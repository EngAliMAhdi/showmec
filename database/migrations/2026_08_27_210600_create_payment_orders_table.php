<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('token', 64)->unique();
            $table->string('order_number', 64)->unique();
            $table->uuid('registration_id')->nullable();
            $table->integer('total_cost')->default(0);
            $table->integer('remaining_amount')->default(0);
            $table->boolean('paid')->default(false);
            $table->string('status')->default('pending');
            $table->json('meta')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('registration_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};
