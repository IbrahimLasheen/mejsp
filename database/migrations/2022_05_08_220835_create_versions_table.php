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
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->string("version")->nullable(); 
            $table->string("year", 100)->nullable(); 
            $table->string("month", 100)->nullable(); 
            $table->string("day", 100)->nullable(); 
            $table->string("old_version")->nullable(); 
            $table->unsignedBigInteger('journal_id');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete("cascade")->onUpdate('cascade');
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
        Schema::dropIfExists('versions');
    }
};
