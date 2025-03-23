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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('provider')->nullable(); // e.g., 'google', 'facebook'
            $table->string('provider_id')->nullable(); // Unique ID from the provider
            $table->string('password')->nullable()->change(); // Make password nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_id']);
            $table->string('password')->nullable(false)->change();
    });
    }
};
