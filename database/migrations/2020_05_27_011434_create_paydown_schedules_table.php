<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaydownSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paydown_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('loan_id');
            $table->double('payment', 8, 2);
            $table->double('balance', 8, 2);
            $table->date('payment_date');
            $table->tinyInteger('complete')->default(0);            
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
        Schema::dropIfExists('paydown_schedules');
    }
}
