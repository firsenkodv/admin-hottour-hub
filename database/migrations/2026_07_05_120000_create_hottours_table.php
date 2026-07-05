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
        // Локальная сущность (docs/hottour-group-multisite-architecture.html, Этап 1):
        // горящие туры свои на каждом сайте группы, поэтому обязателен site_id.
        Schema::create('hottours', function (Blueprint $table) {
            $table->id();
            $table->siteId();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->unsignedTinyInteger('nights')->nullable();
            $table->date('valid_until')->nullable();
            $table->text('smalltext')->nullable();
            $table->longText('text')->nullable();
            $table->boolean('published')->default(true);
            $table->unsignedInteger('sorting')->default(0);
            $table->string('metatitle')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();

            $table->unique(['site_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hottours');
    }
};
