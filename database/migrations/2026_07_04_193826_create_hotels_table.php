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
        // Шейред-сущность (docs/hottour-group-multisite-architecture.html, Этап 1):
        // одинаковая на каждом сайте группы, site_id не имеет — приходит синхронизацией из hub'а.
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('stars')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->text('smalltext')->nullable();
            $table->longText('text')->nullable();
            $table->boolean('published')->default(true);
            $table->unsignedInteger('sorting')->default(0);
            $table->string('metatitle')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
