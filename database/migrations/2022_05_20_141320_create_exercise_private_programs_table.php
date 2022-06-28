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
        Schema::create('exercise_private_programs', function (Blueprint $table) {
            $table ->unsignedBigInteger('ex_id');
            $table ->unsignedBigInteger('private_program_id');

            $table ->foreign('ex_id')->references('ex_id')->on('exercises')->onDelete('cascade');
            $table ->foreign('private_program_id')->references('private_program_id')->on('private_programs')->onDelete('cascade');

            $table->primary(['ex_id','private_program_id']);

            $table->integer('reps');
            $table->time('duration');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_private_programs');
    }
};
