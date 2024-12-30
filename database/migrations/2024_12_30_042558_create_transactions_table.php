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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('province_id')->references('id')->on('provinces')->cascadeOnDelete();
            $table->foreignId('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->string('courier_name');
            $table->string('courier_service');
            $table->bigInteger('courier_cost');
            $table->integer('weight');
            $table->string('invoice');
            $table->text('address');
            $table->bigInteger('grand_total');
            $table->string('reference')->nullable();
            $table->enum('status', ['UNPAID', 'PAID', 'EXPIRED', 'CANCELLED'])->default('UNPAID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
