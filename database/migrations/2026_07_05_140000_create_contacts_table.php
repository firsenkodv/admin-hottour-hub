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
        // контакты свои на каждом сайте группы — одна запись на сайт (site_id уникален).
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->siteId();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('working_hours')->nullable();
            $table->text('map_embed')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();

            $table->unique('site_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
