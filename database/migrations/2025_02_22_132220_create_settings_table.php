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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('telegram');
            $table->string('youtube');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'phone' => '998901234567',
            'email' => 'bereket-stroy@gmail.com',
            'instagram' => 'https://www.instagram.com/',
            'facebook' => 'https://www.facebook.com/',
            'telegram' => 'https://t.me/',
            'youtube' => 'https://www.youtube.com/',
        ]);
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
