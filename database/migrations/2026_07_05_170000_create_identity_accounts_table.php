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
        // Этап 3 (docs/hottour-group-multisite-architecture.html, раздел 6):
        // единая учётная запись туриста живёт на hub'е. Только credentials,
        // никаких профилей/броней/паспортов — это остаётся в локальной БД сайта.
        Schema::create('identity_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('status')->default('active');
            $table->string('reset_token')->nullable();
            $table->timestamp('reset_token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identity_accounts');
    }
};
