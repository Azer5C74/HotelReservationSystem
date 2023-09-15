<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', [
                'cancelled',
                'paid',
                'completed',
                'ongoing',
                'pending payment',
                'drafted',
            ]);
            $table->unsignedBigInteger('room_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        // Create the pivot table for the many-to-many relationship with guests
        Schema::create('guest_reservation', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('guest_id');

            // Foreign key constraints
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_guest');
        Schema::dropIfExists('reservations');
    }
};
