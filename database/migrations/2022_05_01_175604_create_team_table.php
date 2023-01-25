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
        Schema::create('team', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("job");
            $table->string("email")->nullable();
            $table->string("image", 150);
            $table->string("country")->nullable();
            $table->text("linkedin")->nullable();
            //$table->text("facebook")->nullable();
            //$table->text("twitter")->nullable();
            $table->text("website")->nullable();
            $table->enum("type", ['editor', 'expert'])->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete("cascade")->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team');
    }
};
