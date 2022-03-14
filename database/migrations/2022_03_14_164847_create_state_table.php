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
        Schema::create('states', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('country_id');
            $table->string('name', 80);
            $table->string('slug', 4);

            $table->timestamps();

            $table->unique(['country_id', 'name'], 'unique_state_name');
            $table->unique(['country_id', 'slug'], 'unique_state_slug');
            $table->foreign('country_id', 'fk_state_country')->references('id')->on('countries')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
