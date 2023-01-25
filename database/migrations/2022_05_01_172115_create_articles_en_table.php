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
        Schema::create('articles_en', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->string('image');
            $table->text('meta_desc');
            $table->enum('status',[1,0])->default(1)->comment('1: active 
            0: unactive');
            $table->enum('version',["new","old"])->default("new");
            $table->unsignedBigInteger('added_by')->nullable("Deleted Account");
            $table->foreign('added_by')->references('id')->on('admins')->onDelete("set null")->onUpdate('cascade');
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
        Schema::dropIfExists('articles_en');
    }
};
