<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coa_id')->unsigned()->nullable();
            $table->integer('journal_id')->nullable();
            $table->string('vendor',100);
            $table->string('reference',255);
            $table->string('move',30)->nullable();
            $table->double('credit',16,2);
            $table->double('debit',16,2);
            $table->double('cumulative_balance',16,2);
            $table->timestamps();

            $table->foreign('coa_id')->references('id')->on('expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_ledgers');
    }
}
