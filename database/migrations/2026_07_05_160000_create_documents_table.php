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
        // Локальная сущность (уточнение пользователя от 2026-07-05: документы разные на каждом
        // домене группы, без переопределений из hub'а — обычная local-сущность, как контакты/о нас).
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->siteId();
            $table->string('title');
            $table->string('slug');
            $table->string('file');
            $table->text('description')->nullable();
            $table->boolean('published')->default(true);
            $table->unsignedInteger('sorting')->default(0);
            $table->timestamps();

            $table->unique(['site_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
