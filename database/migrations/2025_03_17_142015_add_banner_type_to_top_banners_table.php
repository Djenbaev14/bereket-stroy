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
        Schema::table('top_banners', function (Blueprint $table) {
            $table->enum('banner_type',['big_banner','small_banner']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_banners', function (Blueprint $table) {
            $table->dropColumn('banner_type');
        });
    }
};
