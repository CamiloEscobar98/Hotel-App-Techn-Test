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
        Schema::create('assignment_accommodation_room_type', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedTinyInteger('room_type_id');
            $table->unsignedTinyInteger('accommodation_type_id');

            $table->timestamps();

            $table->foreign('room_type_id', 'fk_assignment_room_type')->references('id')->on('room_types')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('accommodation_type_id', 'fk_assignment_accommodation_type')->references('id')->on('accommodation_types')
                ->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_accommodation_room_type');
    }
};
