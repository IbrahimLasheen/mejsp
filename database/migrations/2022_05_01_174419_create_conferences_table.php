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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string("research_title")->nullable();
            $table->enum("payment_response", [0, 1])->default(0)->comment("
            0 = false : The conference fee has not been paid
            1 = true  : The conference fee has been paid
            ");
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('conference_categories')->onDelete("set null")->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conferences');
    }
};
