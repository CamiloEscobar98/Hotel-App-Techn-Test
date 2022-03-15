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
        Schema::create('hotels', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedMediumInteger('city_id')->nullable();
            $table->string('nit', 40);
            $table->string('name', 80);
            $table->string('address', 150);
            $table->json('properties');

            $table->timestamps();

            $table->unique('nit', 'unique_nit_hotel');
            $table->unique(['city_id', 'name'], 'unique_hotels');
            $table->foreign('city_id', 'fk_hotel_city')->references('id')->on('cities')
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
        Schema::dropIfExists('hotels');
    }
};
