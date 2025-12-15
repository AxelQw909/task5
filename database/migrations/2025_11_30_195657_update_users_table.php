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
            $table->renameColumn('tel', 'phone');
            $table->boolean('is_admin')->default(false);
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