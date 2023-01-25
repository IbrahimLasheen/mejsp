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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("mail")->nullable();
            $table->string("facebook")->nullable();
            $table->string("youtube")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("linkedin")->nullable();
            $table->string("twitter")->nullable();
            $table->string("logo")->nullable();
            $table->string("phone")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
