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
        // «Полезное» своё на каждом сайте группы, поэтому обязателен site_id.
        Schema::create('travelcategories', function (Blueprint $table) {
            $table->id();
            $table->siteId();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('travelcategories');
    }
};
