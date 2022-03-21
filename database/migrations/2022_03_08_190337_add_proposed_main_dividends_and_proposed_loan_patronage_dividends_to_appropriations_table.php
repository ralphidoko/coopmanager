<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProposedMainDividendsAndProposedLoanPatronageDividendsToAppropriationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appropriations', function (Blueprint $table) {
            //
            $table->decimal('proposed_main_dividend',16,2);
            $table->decimal('proposed_lpd',16,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appropriations', function (Blueprint $table) {
            //
        });
    }
}
