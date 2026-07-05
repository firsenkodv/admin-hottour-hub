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
        // страница «О нас» своя на каждом сайте группы — одна запись на сайт (site_id уникален).
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->siteId();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('smalltext')->nullable();
            $table->longText('text')->nullable();
            $table->string('metatitle')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();

            $table->unique('site_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
