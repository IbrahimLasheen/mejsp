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
        Schema::create('international_journals', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->float('price');
            $table->string('logo')->nullable();
            $table->unsignedBigInteger("specialty_id");
            $table->foreign('specialty_id')->references("id")->on('international_specialties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('international_journals');
    }
};
