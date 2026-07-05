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
        // Шейред-сущность (docs/hottour-group-multisite-architecture.html, Этап 1 и раздел «Структура разделов»):
        // одинаковая на каждом сайте группы, site_id не имеет — приходит синхронизацией из hub'а.
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->longText('text');
            $table->boolean('published')->default(true);
            $table->unsignedInteger('sorting')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
