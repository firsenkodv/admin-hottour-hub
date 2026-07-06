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
        // Переопределение текстовых полей Country для конкретного сайта группы —
        // сама страна (id, slug, картинка, факты) остаётся общей и одинаковой везде,
        // но title/описание/SEO могут отличаться по языку/маркетингу на разных сайтах.
        // Редактируется только на хабе (CountryFormPage); если строки для сайта нет —
        // спутник получает базовый текст из countries.* как есть.
        Schema::create('country_site_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->siteId();
            $table->string('title')->nullable();
            $table->text('smalltext')->nullable();
            $table->longText('text')->nullable();
            $table->string('metatitle')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();

            $table->unique(['country_id', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_site_contents');
    }
};
