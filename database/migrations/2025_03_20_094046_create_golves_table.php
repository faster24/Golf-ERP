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
        Schema::create('golf_courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('sub_description');
            $table->string('yard');
            $table->string('location_city');
            $table->string('location_country');
            $table->text('description');
            $table->text('image');
            $table->decimal('rating');
            $table->decimal('discount')->default(0);
            $table->boolean('visibility')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golves');
    }
};
