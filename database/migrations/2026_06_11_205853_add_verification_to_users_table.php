<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verificación de email
            $table->boolean('email_verified')->default(false)->after('email');
            $table->string('email_token')->nullable()->after('email_verified');
            $table->timestamp('email_token_expires_at')->nullable()->after('email_token');

            // Recuperar contraseña
            $table->string('reset_token')->nullable()->after('email_token_expires_at');
            $table->timestamp('reset_token_expires_at')->nullable()->after('reset_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_verified', 'email_token', 'email_token_expires_at',
                'reset_token', 'reset_token_expires_at'
            ]);
        });
    }
};