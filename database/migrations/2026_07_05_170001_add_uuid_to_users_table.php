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
        // Этап 3: локальная «теневая» запись пользователя ссылается на
        // центральную учётку (identity_accounts.uuid на hub'е) этим полем.
        // Пароль в этой таблице не хранится и не используется — единственный
        // источник правды по паролю — hub.
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->string('password')->nullable(false)->change();
        });
    }
};
