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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender',['Male','Female']);
            $table->string('image')->default(null)->nullable();
            $table->date('DOB');
            $table->enum('week_start', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->enum('times_a_week',['1','2','3','4','5']);
            $table->enum('time_per_day',['10','15','20','25','30','35','40']);
            $table->enum('initial_plan',['muscle','weight','height','stretching']);
            $table->enum('pushups',['0-5','5-10','10-20','20-30','35+']);
            $table->enum('plank',['0-5','5-10','10-20','20-30','35+']);
            $table->enum('knee',['Yes','No','A little']);
            $table->float('height');
            $table->float('weight');
            $table->integer('steps')->default(0);
            $table->date('step_update')->default(date('Y-m-d'));
            $table->time('duration')->default(0);
            $table->timestamps();
        });

        Schema::table('users',function(Blueprint $table){
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
        Schema::dropIfExists('users');
    }
};
