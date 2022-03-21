<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingauthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saving_authorizations', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->decimal('current_amount',16,2)->nullable();
            $table->decimal('desired_amount',16,2)->nullable();
            $table->string('auth_type')->nullable();
            $table->string('auth_text')->nullable();
            $table->date('start_date');
            $table->string('status')->default('Awaiting Approval');
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
        Schema::dropIfExists('savingauthorizations');
    }
}
