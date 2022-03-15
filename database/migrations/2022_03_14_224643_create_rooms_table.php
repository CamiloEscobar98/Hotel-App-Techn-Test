<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hotel_id');
            $table->unsignedMediumInteger('assignment_room_id')->nullable();
            $table->unsignedSmallInteger('ammount_rooms');

            $table->timestamps();

            $table->unique(['hotel_id', 'assignment_room_id'], 'unique_rooms');
            $table->foreign('hotel_id', 'fk_room_hotel')->references('id')->on('hotels')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('assignment_room_id', 'fk_assignment_room')->references('id')->on('assignment_accommodation_room_type')
                ->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
