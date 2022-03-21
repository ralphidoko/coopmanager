<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('staff_no')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('office_location')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('gender')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('lga')->nullable();
            $table->string('town')->nullable();
            $table->string('nok_fname')->nullable();
            $table->string('nok_mname')->nullable();
            $table->string('nok_lname')->nullable();
            $table->string('nok_address')->nullable();
            $table->string('nok_phone_number')->nullable();
            $table->string('nok_email')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('referee_one')->nullable();
            $table->string('referee_two')->nullable();
            $table->boolean('certification')->default(false);
            $table->rememberToken()->nullable();
            $table->timestamps();

           // $table->foreignId('user_id')->constrained();
            //$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('members');
    }
}
