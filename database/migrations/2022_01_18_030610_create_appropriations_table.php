<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppropriationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appropriations', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('education_reserve',16,2);
            $table->decimal('statutory_reserve',16,2);
            $table->decimal('proposed_dividend',16,2);
            $table->decimal('general_reserve',16,2);
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
        Schema::dropIfExists('income_distributions');
    }
}
