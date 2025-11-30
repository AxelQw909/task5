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
        Schema::table('users', function (Blueprint $table) {
            // Переименовываем tel в phone
            $table->renameColumn('tel', 'phone');
            
            // Добавляем поле is_admin
            $table->boolean('is_admin')->default(false);
            
            // Делаем login обязательным и уникальным
            $table->string('login')->nullable(false)->change();
            $table->unique('login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('phone', 'tel');
            $table->dropColumn('is_admin');
            $table->dropUnique(['login']);
            $table->string('login')->nullable()->change();
        });
    }
};