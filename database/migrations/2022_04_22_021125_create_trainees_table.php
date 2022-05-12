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
        Schema::create('trainees', function (Blueprint $table) {
            $table->bigIncrements('trainee_id');
            $table->enum('week_start', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->enum('times_a_week',['1','2','3','4','5']);
            $table->enum('time_per_day',['10','15','20','25','30','35','40']);
            $table->enum('initial_plan',['muscle','weight','height','stretching']);
            $table->enum('pushups',['0-5','5-10','10-20','20-30','35+']);
            $table->enum('plank',['0-5','5-10','10-20','20-30','35+']);
            $table->enum('knee',['Yes','No','A little Bit']);
            $table->float('height');
            $table->date('DOB');
            $table->float('weight');
        });

        Schema::table('trainees',function(Blueprint $table){
        	$table->unsignedBigInteger('usr_id');
        	$table->foreign('usr_id')->references('usr_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('active_program_id')->nullable();
        	$table->foreign('active_program_id')->references('program_id')->on('programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sleep_trackers');
    }
};
