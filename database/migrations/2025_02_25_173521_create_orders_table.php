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
            $table->unsignedBigInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // To‘lov holati
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending'); // Buyurtma holati
            $table->decimal('total', 10, 2); // Buyurtma umumiy summasi
            $table->string('address_id')->nullable(); // Yetkazib berish manzili
            $table->longText('comment')->nullable(); // Buyurtma haqida izoh
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
