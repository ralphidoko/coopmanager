<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('loan_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->decimal('amount',16,2)->default(0.00);
            $table->date('value_date');
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_income');
    }
}
