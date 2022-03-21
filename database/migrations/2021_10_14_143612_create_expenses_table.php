<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description',200);
            $table->string('product_service',200);
            $table->integer('account_id')->unsigned()->nullable();
            $table->decimal('unit_price',16,2);
            $table->integer('quantity');
            $table->decimal('total_price',16,2);
            $table->string('expense_number',20);
            $table->string('vendor',50);
            $table->foreignUuid('posted_by')->nullable();
            $table->timestamps();

            $table->foreign('posted_by')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('chart_of_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
