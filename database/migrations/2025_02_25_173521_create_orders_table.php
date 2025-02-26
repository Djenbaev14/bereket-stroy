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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->enum('payment_method', ['cash', 'payme', 'click', 'uzum', 'other'])->default('cash'); // To‘lov usuli
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // To‘lov holati
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending'); // Buyurtma holati
            $table->string('transaction_id')->nullable(); // To‘lov tizimi uchun transaktsiya ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
