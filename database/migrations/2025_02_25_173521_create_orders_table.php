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
            $table->foreign('customer_id')->references('id')->on('customers');
            
            // qabul qiluvchi
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_comment')->nullable();
            
            $table->unsignedBigInteger('delivery_method_id');
            $table->foreign('delivery_method_id')->references('id')->on('delivery_methods');
            
            // olib ketish
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
            
            // yetkazib berish
            $table->string('region')->nullable(); // Tuman yoki viloyat
            $table->string('district')->nullable(); // Rayon
            $table->string('address')->nullable(); // Uy manzili
            $table->json('location')->nullable();
            
            // payment
            $table->unsignedBigInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('payment_status_id');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->unsignedBigInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->longText('comment')->nullable(); 
            $table->softDeletes();
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
