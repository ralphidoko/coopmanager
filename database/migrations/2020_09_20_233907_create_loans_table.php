<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->decimal('loan_amount',16,2)->nullable();
            $table->decimal('amount_recovered',16,2)->nullable();
            $table->decimal('total_amount_payable',16,2)->nullable();
            $table->decimal('total_interest_payable',16,2)->nullable();
            $table->decimal('monthly_interest_payable',16,2)->nullable();
            $table->string('loan_type',20)->nullable();
            $table->string('cash_loan_rate',3)->nullable();
            $table->string('no_of_installments',3)->nullable();
            $table->string('item_loan_tenor',3)->nullable();
            $table->string('item_loan_rate',3)->nullable();
            $table->string('cash_loan_tenor',3)->nullable();
            $table->string('guarantor_one',50)->nullable();
            $table->string('guarantor_two',50)->nullable();
            $table->string('g1_phone_no',15)->nullable();
            $table->string('g2_phone_no',15)->nullable();
            $table->string('status',50)->nullable();
            $table->string('reason_for_rejection',255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
