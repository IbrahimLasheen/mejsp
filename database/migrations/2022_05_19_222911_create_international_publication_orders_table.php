<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    
    public function up()
    {
        Schema::create('international_publication_orders', function (Blueprint $table) {
            $table->id();
            $table->string("file");
            $table->text("desc")->nullable();
            $table->enum("payment_response",[0,1])->comment("0 = false : The conference fee has not been paid 1 = true : The conference fee has been paid");
            $table->unsignedBigInteger("journal_id")->nullable("Deleted Account");
            $table->foreign('journal_id')->references("id")->on('international_journals')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign('user_id')->references("id")->on('users')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('international_publication_orders');
    }
};
