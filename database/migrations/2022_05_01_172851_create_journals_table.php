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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text("slug")->unique();
            $table->string('impact', 60)->comment("Impact factor")->nullable();
            $table->string('issn', 60)->comment('International number of the magazine')->nullable();
            $table->text('meta_desc');
            $table->string('cover', 100)->comment('Journal Cover Image');
            $table->string('logo', 100)->comment('Journal Logo');
            $table->string('address', 255);
            $table->string('email', 150);
            $table->string('country_code', 40);
            $table->string('phone', 150);
            $table->text('brief_desc')->comment("A simple explanation of the objectives of the magazine");
            $table->longText('reviewers_instructions')->comment("General instructions for reviewers")->nullable();
            $table->longText('authors_instructions')->comment("General instructions for authors")->nullable();
            $table->longText('ethics')->comment("Publication Ethics")->nullable();
            $table->longText('publication_pricing')->comment("Arbitration fees and publication in this journal")->nullable();
            //  $table->string('how_to_publish')->comment("How to publish on the magazine");
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
        Schema::dropIfExists('journals');
    }
};
