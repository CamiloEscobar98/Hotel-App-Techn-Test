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
        Schema::create('cities', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('state_id');
            $table->string('name', 80);
            $table->string('slug', 4);

            $table->timestamps();

            $table->unique(['state_id', 'name'], 'unique_city_name');
            $table->unique(['state_id', 'slug'], 'unique_city_slug');
            $table->foreign('state_id', 'fk_city_state')->references('id')->on('states')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
