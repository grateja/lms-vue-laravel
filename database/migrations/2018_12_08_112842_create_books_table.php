<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_id');
            $table->double('price')->default(0);
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('isbn')->nullable();
            $table->string('year_published')->nullable();
            $table->string('edition')->nullable();
            $table->string('volume')->nullable();
            $table->unsignedInteger('publisher_id')->nullable();
            $table->unsignedInteger('publishing_place_id')->nullable();
            $table->unsignedInteger('dewey_id')->nullable();
            $table->timestamps();

            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
            $table->foreign('publishing_place_id')->references('id')->on('publishing_places')->onDelete('cascade');
            $table->foreign('dewey_id')->references('id')->on('deweys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
