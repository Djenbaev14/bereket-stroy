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
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // 'uz', 'ru', 'en' kabi kodlar
            $table->string('name'); // 'O‘zbek', 'Русский', 'English'
            $table->string('flag')->nullable(); // Bayroq rasmi (ixtiyoriy)
            $table->boolean('is_default')->default(false); // Asosiy tilni belgilash
            $table->boolean('is_active')->default(true); // Faol yoki yo‘qligini ko‘rsatish
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
