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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('booking_date');
            $table->string('booking_time');
            $table->string('location_city');
            $table->string('location_country');
            $table->unsignedBigInteger('course_id');
            $table->integer('golfers');
            $table->integer('holes');
            $table->unsignedBigInteger('package_id');
            $table->decimal('hole_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->string('status');
            $table->timestamp('canceled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
