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
            $table->id();
            $table->string('name', 255);
            $table->double('starting_balance', 13, 2);
            $table->double('current_balance', 13, 2);
            $table->double('interest_rate', 13, 2);
            $table->double('min_payment', 13, 2);
            $table->double('fixed_payment', 13, 2);
            $table->date('due_date');
            $table->integer('user_id');
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
        Schema::dropIfExists('loans');
    }
}
