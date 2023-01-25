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
        Schema::create('conference_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->enum("without_research", [0, 1])->default(0)->comment("
            0 : Without the need to add the name of the search
            1 : You need to add a search name");
            $table->float("price");
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
        Schema::dropIfExists('conference_categories');
    }
};
