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
        Schema::create('users_researches', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->mediumText("abstract");
            $table->text("keywords");
            $table->string("file");
            $table->enum("type", [0, 1])->default(0)->comment("0: This Research Open Source  1: Not Open Source");

            $table->unsignedBigInteger('user_id')->nullable("Deleted Account");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate('cascade');

            $table->unsignedBigInteger('journal_id')->nullable();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete("set null")->onUpdate('cascade');

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
        Schema::dropIfExists('users_researches');
    }
};
