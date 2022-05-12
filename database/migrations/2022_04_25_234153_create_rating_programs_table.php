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
        Schema::create('rating_programs', function (Blueprint $table) {
            $table->enum('rating', ['1', '2', '3', '4', '5']);
        });

        Schema::table('rating_programs',function(Blueprint $table){
            $table ->unsignedBigInteger('program_id');
            $table ->unsignedBigInteger('trainee_id');

            $table ->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
            $table ->foreign('trainee_id')->references('trainee_id')->on('trainees')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_programs');
    }
};
