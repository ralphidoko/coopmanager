<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_contests', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('contestant_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('no_of_vote')->default(0);
            $table->uuid('voted_by')->nullable();
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('contestant_id')->references('contestant_id')->on('election_contestants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('election_contests');
    }
}
