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
            $table ->unsignedBigInteger('ex_id');
            $table ->unsignedBigInteger('program_id');

            $table ->foreign('ex_id')->references('ex_id')->on('exercises')->onDelete('cascade');
            $table ->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');

            $table->primary(['ex_id','program_id']);

            $table->integer('reps')->nullable();
            $table->integer('sets')->nullable();
            $table->time('duration')->nullable();
            $table->enum('day_num',['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17'
            ,'18','19','20','21','22','23','24','25','26','27','28']);
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
