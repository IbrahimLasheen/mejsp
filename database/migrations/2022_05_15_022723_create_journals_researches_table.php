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
        Schema::create('journals_researches', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("slug");
            $table->string("author_name");
            $table->string("file", 255);
            $table->text("abstract");
            $table->enum("is_free", [0, 1])->comment("1 : Free Research 0: Not Free")->default(0);
            $table->float("price")->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete("cascade")->onUpdate('cascade');
            $table->unsignedBigInteger('version_id')->nullable();
            $table->foreign('version_id')->references('id')->on('versions')->onDelete("cascade")->onUpdate('cascade');
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
        Schema::dropIfExists('journals_researches');
    }
};
