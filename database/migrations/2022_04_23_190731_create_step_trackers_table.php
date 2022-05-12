<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_trackers', function (Blueprint $table) {
            $table->float('steps');
            $table->date('date')->unique();
        });
        Schema::table('step_trackers',function(Blueprint $table){
        	$table->unsignedBigInteger('trainee_id');
        	$table->foreign('trainee_id')->references('trainee_id')
     			->on('trainees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_trackers');
    }
};
