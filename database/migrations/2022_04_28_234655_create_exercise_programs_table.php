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
        Schema::create('exercise_programs', function (Blueprint $table) {
            $table->bigIncrements('ex_prg_id');
        });

        Schema::table('exercise_programs',function(Blueprint $table){
            $table ->unsignedBigInteger('ex_id');
            $table ->unsignedBigInteger('program_id');

            $table ->foreign('ex_id')->references('ex_id')->on('exercises')->onDelete('cascade');
            $table ->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_programs');
    }
};
