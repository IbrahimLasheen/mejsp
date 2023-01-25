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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float("amount");
            $table->string("currency", 45);
            $table->string("source", 100)->comment("Payment Gateway Name");
            $table->string("payment_id");
            $table->string("payer_email");
            $table->string("payer_name");

            $table->string("payer_id");
            $table->string("status", 100)->comment('Status of this payment if approved or canceled');
            $table->unsignedBigInteger('payment_by')->nullable("Deleted Account");
            $table->foreign('payment_by')->references('id')->on('users')->onDelete("set null")->onUpdate('cascade');

            $table->unsignedBigInteger('for_conference')->nullable("Deleted Conference");
            $table->foreign('for_conference')->references('id')->on('conferences')->onDelete("set null")->onUpdate('cascade');

            $table->unsignedBigInteger('for_international_publishing')->nullable("Deleted International Publishing");
            $table->foreign('for_international_publishing')->references('id')->on('international_publication_orders')->onDelete("set null")->onUpdate('cascade');

            $table->unsignedBigInteger('for_research')->nullable("Deleted Research");
            $table->foreign('for_research')->references('id')->on('journals_researches')->onDelete("set null")->onUpdate('cascade');

            $table->unsignedBigInteger('for_invoice')->nullable("Deleted Invoice");
            $table->foreign('for_invoice')->references('id')->on('invoices')->onDelete("set null")->onUpdate('cascade');


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
        Schema::dropIfExists('payments');
    }
};
