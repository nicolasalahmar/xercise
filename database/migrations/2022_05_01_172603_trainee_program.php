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
        Schema::create('trainee_programs', function (Blueprint $table) {
            $table->bigIncrements('trainee_program_id');
            $table->date('date');
        });

        Schema::table('trainee_programs',function(Blueprint $table){
        	$table->unsignedBigInteger('trainee_id');
        	$table->foreign('trainee_id')->references('trainee_id')->on('trainees')->onDelete('cascade');

            $table->unsignedBigInteger('program_id');
        	$table->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
