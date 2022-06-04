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
        Schema::table('workout_stats',function(Blueprint $table){
            $table->unsignedBigInteger('user_id');
        	$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('program_id')->nullable();
        	$table->foreign('program_id')->references('program_id')->on('programs')->onDelete('set null');

            $table->unsignedBigInteger('private_program_id')->nullable();
        	$table->foreign('private_program_id')->references('private_program_id')->on('private_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workout_stats');
    }
};
