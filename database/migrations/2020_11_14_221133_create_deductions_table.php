<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authority_to_deduct_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->decimal('authorized_amount',16,2);
            $table->date('start_date');
            $table->decimal('inc_dec_amount',16,2);
            $table->string('status')->default('Awaiting Approval');
            $table->string('certification');
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
        Schema::dropIfExists('deductions');
    }
}
