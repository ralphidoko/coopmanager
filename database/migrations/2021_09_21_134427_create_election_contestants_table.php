<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionContestantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_contestants', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('contestant_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('passport');
            $table->timestamps();

            $table->foreign('contestant_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('election_contestants');
    }
}
